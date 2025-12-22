/**
 * Pout Theme Service Worker
 * オフラインキャッシュとパフォーマンス最適化
 */

const CACHE_NAME = 'pout-cache-v1';
const OFFLINE_URL = '/offline/';

// キャッシュするリソース
const PRECACHE_RESOURCES = [
    '/',
    '/wp-content/themes/pout-theme/assets/css/main.css',
    '/wp-content/themes/pout-theme/assets/js/scripts.js',
    '/wp-content/themes/pout-theme/style.css',
];

// キャッシュ戦略の設定
const CACHE_STRATEGIES = {
    // キャッシュファースト（静的アセット用）
    cacheFirst: [
        /\.css$/,
        /\.js$/,
        /\.woff2?$/,
        /\.ttf$/,
        /\.eot$/,
    ],
    // ネットワークファースト（HTML、API用）
    networkFirst: [
        /\/$/,
        /\.html$/,
        /\/wp-json\//,
    ],
    // ステイルワイルリバリデート（画像用）
    staleWhileRevalidate: [
        /\.png$/,
        /\.jpg$/,
        /\.jpeg$/,
        /\.gif$/,
        /\.webp$/,
        /\.svg$/,
        /\.ico$/,
    ],
};

/**
 * インストールイベント
 */
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[SW] Precaching resources');
                return cache.addAll(PRECACHE_RESOURCES);
            })
            .then(() => {
                return self.skipWaiting();
            })
            .catch((error) => {
                console.error('[SW] Precache failed:', error);
            })
    );
});

/**
 * アクティベートイベント
 */
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames
                        .filter((cacheName) => cacheName !== CACHE_NAME)
                        .map((cacheName) => {
                            console.log('[SW] Deleting old cache:', cacheName);
                            return caches.delete(cacheName);
                        })
                );
            })
            .then(() => {
                return self.clients.claim();
            })
    );
});

/**
 * フェッチイベント
 */
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // 同一オリジンのみ処理
    if (url.origin !== location.origin) {
        return;
    }

    // POSTリクエストはスキップ
    if (request.method !== 'GET') {
        return;
    }

    // 管理画面はスキップ
    if (url.pathname.startsWith('/wp-admin') || url.pathname.startsWith('/wp-login')) {
        return;
    }

    // キャッシュ戦略を決定
    const strategy = getStrategy(url.pathname);

    switch (strategy) {
        case 'cacheFirst':
            event.respondWith(cacheFirst(request));
            break;
        case 'networkFirst':
            event.respondWith(networkFirst(request));
            break;
        case 'staleWhileRevalidate':
            event.respondWith(staleWhileRevalidate(request));
            break;
        default:
            event.respondWith(networkFirst(request));
    }
});

/**
 * キャッシュ戦略を取得
 */
function getStrategy(pathname) {
    for (const [strategy, patterns] of Object.entries(CACHE_STRATEGIES)) {
        for (const pattern of patterns) {
            if (pattern.test(pathname)) {
                return strategy;
            }
        }
    }
    return 'networkFirst';
}

/**
 * キャッシュファースト戦略
 */
async function cacheFirst(request) {
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
        return cachedResponse;
    }

    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        console.error('[SW] Cache first failed:', error);
        return new Response('Offline', { status: 503 });
    }
}

/**
 * ネットワークファースト戦略
 */
async function networkFirst(request) {
    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }

        // オフラインページを返す（HTMLリクエストの場合）
        if (request.headers.get('Accept')?.includes('text/html')) {
            const offlineResponse = await caches.match(OFFLINE_URL);
            if (offlineResponse) {
                return offlineResponse;
            }
        }

        return new Response('Offline', {
            status: 503,
            headers: { 'Content-Type': 'text/plain' }
        });
    }
}

/**
 * Stale While Revalidate戦略
 */
async function staleWhileRevalidate(request) {
    const cachedResponse = await caches.match(request);

    const fetchPromise = fetch(request)
        .then((networkResponse) => {
            if (networkResponse.ok) {
                caches.open(CACHE_NAME)
                    .then((cache) => cache.put(request, networkResponse.clone()));
            }
            return networkResponse;
        })
        .catch(() => cachedResponse);

    return cachedResponse || fetchPromise;
}

/**
 * プッシュ通知（将来の拡張用）
 */
self.addEventListener('push', (event) => {
    if (!event.data) {
        return;
    }

    const data = event.data.json();
    const options = {
        body: data.body || '',
        icon: '/wp-content/themes/pout-theme/assets/images/icon-192x192.png',
        badge: '/wp-content/themes/pout-theme/assets/images/badge-72x72.png',
        vibrate: [100, 50, 100],
        data: {
            url: data.url || '/',
        },
    };

    event.waitUntil(
        self.registration.showNotification(data.title || 'Pout', options)
    );
});

/**
 * 通知クリック
 */
self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    const url = event.notification.data?.url || '/';
    event.waitUntil(
        clients.matchAll({ type: 'window' })
            .then((windowClients) => {
                for (const client of windowClients) {
                    if (client.url === url && 'focus' in client) {
                        return client.focus();
                    }
                }
                return clients.openWindow(url);
            })
    );
});

/**
 * バックグラウンド同期（将来の拡張用）
 */
self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-forms') {
        event.waitUntil(syncForms());
    }
});

async function syncForms() {
    // オフライン時に保存されたフォームデータを送信
    console.log('[SW] Syncing forms...');
}

/**
 * メッセージハンドラ
 */
self.addEventListener('message', (event) => {
    if (event.data === 'skipWaiting') {
        self.skipWaiting();
    }

    if (event.data === 'clearCache') {
        caches.delete(CACHE_NAME).then(() => {
            console.log('[SW] Cache cleared');
        });
    }
});
