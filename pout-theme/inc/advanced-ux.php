<?php
/**
 * Advanced UX
 *
 * 爆速表示・遷移のためのUX強化機能
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ========================================
 * Prefetch / Prerender
 * ========================================
 */

/**
 * 次のページをプリフェッチ
 */
function pout_prefetch_next_page() {
    if (is_singular('post')) {
        $next_post = get_next_post();
        if ($next_post) {
            echo '<link rel="prefetch" href="' . esc_url(get_permalink($next_post)) . '">' . "\n";
        }
    }

    // ホームページでは最初の記事をプリフェッチ
    if (is_front_page() || is_home()) {
        $first_post = get_posts(array('posts_per_page' => 1));
        if ($first_post) {
            echo '<link rel="prefetch" href="' . esc_url(get_permalink($first_post[0])) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'pout_prefetch_next_page');

/**
 * DNS プリフェッチ
 */
function pout_dns_prefetch() {
    $domains = array(
        '//fonts.googleapis.com',
        '//fonts.gstatic.com',
        '//www.google-analytics.com',
        '//www.googletagmanager.com',
    );

    foreach ($domains as $domain) {
        echo '<link rel="dns-prefetch" href="' . esc_attr($domain) . '">' . "\n";
    }
}
add_action('wp_head', 'pout_dns_prefetch', 0);

/**
 * Instant Page（リンクホバー時にプリロード）
 */
function pout_instant_page() {
    if (is_admin()) {
        return;
    }
    ?>
    <script type="module">
    // Instant.page lite implementation
    (function() {
        let prefetcher = null;
        let prefetchedUrl = null;

        function prefetch(url) {
            if (prefetchedUrl === url) return;

            if (prefetcher) {
                prefetcher.remove();
            }

            prefetcher = document.createElement('link');
            prefetcher.rel = 'prefetch';
            prefetcher.href = url;
            document.head.appendChild(prefetcher);
            prefetchedUrl = url;
        }

        function isInternalLink(a) {
            return a.hostname === location.hostname &&
                   a.pathname !== location.pathname &&
                   !a.hash &&
                   a.target !== '_blank';
        }

        document.addEventListener('mouseover', function(e) {
            const link = e.target.closest('a');
            if (link && isInternalLink(link)) {
                prefetch(link.href);
            }
        });

        document.addEventListener('touchstart', function(e) {
            const link = e.target.closest('a');
            if (link && isInternalLink(link)) {
                prefetch(link.href);
            }
        }, { passive: true });
    })();
    </script>
    <?php
}
add_action('wp_footer', 'pout_instant_page');

/**
 * ========================================
 * スクロール体験向上
 * ========================================
 */

/**
 * スムーズスクロール CSS
 */
function pout_smooth_scroll_css() {
    ?>
    <style>
    html {
        scroll-behavior: smooth;
    }
    @media (prefers-reduced-motion: reduce) {
        html {
            scroll-behavior: auto;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'pout_smooth_scroll_css', 1);

/**
 * スクロール位置の復元
 */
function pout_scroll_restoration() {
    ?>
    <script>
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }

    // 戻る時のスクロール位置を復元
    window.addEventListener('popstate', function() {
        const scrollPos = sessionStorage.getItem('scrollPos_' + location.href);
        if (scrollPos) {
            setTimeout(function() {
                window.scrollTo(0, parseInt(scrollPos, 10));
            }, 0);
        }
    });

    // スクロール位置を保存
    window.addEventListener('beforeunload', function() {
        sessionStorage.setItem('scrollPos_' + location.href, window.scrollY);
    });
    </script>
    <?php
}
add_action('wp_footer', 'pout_scroll_restoration');

/**
 * ========================================
 * 読み込み体験向上
 * ========================================
 */

/**
 * ページ遷移時のプログレスバー
 */
function pout_page_progress_bar() {
    ?>
    <style>
    .page-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
        z-index: 9999;
        transition: width 0.2s ease;
    }
    .page-progress.loading {
        animation: progressPulse 1.5s ease-in-out infinite;
    }
    @keyframes progressPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    </style>
    <div class="page-progress" id="pageProgress"></div>
    <script>
    (function() {
        const progress = document.getElementById('pageProgress');
        let value = 0;
        let interval = null;

        window.addEventListener('beforeunload', function() {
            progress.classList.add('loading');
            progress.style.width = '30%';

            interval = setInterval(function() {
                value += Math.random() * 10;
                if (value > 90) value = 90;
                progress.style.width = value + '%';
            }, 200);
        });

        window.addEventListener('load', function() {
            if (interval) clearInterval(interval);
            progress.style.width = '100%';
            setTimeout(function() {
                progress.classList.remove('loading');
                progress.style.width = '0';
            }, 200);
        });
    })();
    </script>
    <?php
}
add_action('wp_footer', 'pout_page_progress_bar');

/**
 * スケルトンローダー用クラス
 */
function pout_skeleton_loader_styles() {
    ?>
    <style>
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: skeleton-loading 1.5s infinite;
        border-radius: var(--radius-sm);
    }
    .skeleton-text {
        height: 1em;
        margin-bottom: 0.5em;
    }
    .skeleton-text:last-child {
        width: 80%;
    }
    .skeleton-image {
        aspect-ratio: 16/9;
    }
    .skeleton-circle {
        border-radius: 50%;
    }
    @keyframes skeleton-loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    </style>
    <?php
}
add_action('wp_head', 'pout_skeleton_loader_styles');

/**
 * ========================================
 * インタラクション強化
 * ========================================
 */

/**
 * 画像の表示アニメーション
 */
function pout_image_reveal_animation() {
    ?>
    <style>
    .reveal-image {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .reveal-image.visible {
        opacity: 1;
        transform: translateY(0);
    }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.article-content img, .post-card-image img');

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        images.forEach(function(img) {
            img.classList.add('reveal-image');
            observer.observe(img);
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'pout_image_reveal_animation');

/**
 * スクロール位置によるヘッダー変化
 */
function pout_header_scroll_effect() {
    ?>
    <style>
    .site-header {
        transition: background-color 0.3s ease, box-shadow 0.3s ease, height 0.3s ease;
    }
    .site-header.compact {
        height: 60px;
    }
    .site-header.compact .header-inner {
        height: 60px;
    }
    </style>
    <script>
    (function() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScrollY = 0;
        let ticking = false;

        function updateHeader() {
            const scrollY = window.scrollY;

            if (scrollY > 100) {
                header.classList.add('scrolled');
                if (scrollY > lastScrollY && scrollY > 200) {
                    // 下スクロール時
                    header.style.transform = 'translateY(-100%)';
                } else {
                    // 上スクロール時
                    header.style.transform = 'translateY(0)';
                }
            } else {
                header.classList.remove('scrolled');
                header.style.transform = 'translateY(0)';
            }

            lastScrollY = scrollY;
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        });
    })();
    </script>
    <?php
}
add_action('wp_footer', 'pout_header_scroll_effect');

/**
 * ========================================
 * パフォーマンスモニタリング
 * ========================================
 */

/**
 * Core Web Vitals 計測
 */
function pout_web_vitals() {
    if (is_admin() || !current_user_can('manage_options')) {
        return;
    }
    ?>
    <script>
    // Web Vitals 簡易計測
    (function() {
        // LCP (Largest Contentful Paint)
        new PerformanceObserver(function(entryList) {
            const entries = entryList.getEntries();
            const lastEntry = entries[entries.length - 1];
            console.log('LCP:', lastEntry.startTime.toFixed(2), 'ms');
        }).observe({ type: 'largest-contentful-paint', buffered: true });

        // FID (First Input Delay)
        new PerformanceObserver(function(entryList) {
            const entries = entryList.getEntries();
            entries.forEach(function(entry) {
                console.log('FID:', entry.processingStart - entry.startTime, 'ms');
            });
        }).observe({ type: 'first-input', buffered: true });

        // CLS (Cumulative Layout Shift)
        let clsValue = 0;
        new PerformanceObserver(function(entryList) {
            const entries = entryList.getEntries();
            entries.forEach(function(entry) {
                if (!entry.hadRecentInput) {
                    clsValue += entry.value;
                }
            });
            console.log('CLS:', clsValue.toFixed(4));
        }).observe({ type: 'layout-shift', buffered: true });
    })();
    </script>
    <?php
}
// add_action('wp_footer', 'pout_web_vitals');

/**
 * ========================================
 * アクセシビリティ向上
 * ========================================
 */

/**
 * フォーカス表示の改善
 */
function pout_focus_styles() {
    ?>
    <style>
    /* キーボードフォーカス時のみアウトラインを表示 */
    :focus {
        outline: none;
    }
    :focus-visible {
        outline: 2px solid var(--color-primary);
        outline-offset: 2px;
    }
    /* ボタンのアクティブ状態 */
    .btn:active {
        transform: scale(0.98);
    }
    /* リンクのタッチ領域を拡大 */
    @media (pointer: coarse) {
        .primary-menu a,
        .footer-menu a {
            padding: 0.75rem;
            margin: -0.75rem;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'pout_focus_styles');

/**
 * 読み上げ用の追加情報
 */
function pout_screen_reader_info() {
    ?>
    <div class="screen-reader-text" aria-live="polite" id="sr-announcer"></div>
    <script>
    // ページ遷移時のアナウンス
    window.addEventListener('load', function() {
        const announcer = document.getElementById('sr-announcer');
        if (announcer) {
            announcer.textContent = document.title + 'を読み込みました';
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'pout_screen_reader_info');

/**
 * ========================================
 * オフライン対応（Service Worker）
 * ========================================
 */

/**
 * PWA マニフェストリンク出力
 */
function pout_pwa_manifest() {
    $manifest_url = get_template_directory_uri() . '/manifest.json';
    echo '<link rel="manifest" href="' . esc_url($manifest_url) . '">' . "\n";
    echo '<meta name="theme-color" content="#0F172A">' . "\n";
    echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' . "\n";
    echo '<meta name="apple-mobile-web-app-title" content="Pout">' . "\n";

    // Apple Touch Icons
    $icon_sizes = array(180, 152, 144, 120, 114, 76, 72, 60, 57);
    foreach ($icon_sizes as $size) {
        $icon_url = get_template_directory_uri() . '/assets/images/apple-touch-icon-' . $size . 'x' . $size . '.png';
        echo '<link rel="apple-touch-icon" sizes="' . $size . 'x' . $size . '" href="' . esc_url($icon_url) . '">' . "\n";
    }
}
add_action('wp_head', 'pout_pwa_manifest', 1);

/**
 * Service Worker 登録
 */
function pout_register_service_worker() {
    if (is_admin()) {
        return;
    }
    ?>
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('<?php echo esc_url(get_template_directory_uri()); ?>/sw.js')
                .then(function(registration) {
                    console.log('ServiceWorker registered:', registration.scope);

                    // アップデートチェック
                    registration.addEventListener('updatefound', function() {
                        const newWorker = registration.installing;
                        newWorker.addEventListener('statechange', function() {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                // 新しいバージョンが利用可能
                                if (confirm('新しいバージョンが利用可能です。更新しますか？')) {
                                    newWorker.postMessage('skipWaiting');
                                    window.location.reload();
                                }
                            }
                        });
                    });
                })
                .catch(function(error) {
                    console.log('ServiceWorker registration failed:', error);
                });
        });
    }
    </script>
    <?php
}
add_action('wp_footer', 'pout_register_service_worker');

/**
 * ========================================
 * 読了率トラッキング
 * ========================================
 */

/**
 * 記事の読了率を計測
 */
function pout_reading_progress() {
    if (!is_singular('post')) {
        return;
    }
    ?>
    <style>
    .reading-progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        width: 0;
        height: 3px;
        background: var(--color-primary);
        z-index: 9999;
        transition: width 0.1s ease;
    }
    </style>
    <div class="reading-progress-bar" id="readingProgress"></div>
    <script>
    (function() {
        const progressBar = document.getElementById('readingProgress');
        const article = document.querySelector('.article-content');

        if (!article || !progressBar) return;

        function updateProgress() {
            const articleRect = article.getBoundingClientRect();
            const articleTop = articleRect.top + window.scrollY;
            const articleHeight = articleRect.height;
            const windowHeight = window.innerHeight;
            const scrollY = window.scrollY;

            const start = articleTop - windowHeight;
            const end = articleTop + articleHeight - windowHeight;
            const progress = Math.min(Math.max((scrollY - start) / (end - start), 0), 1);

            progressBar.style.width = (progress * 100) + '%';

            // 読了イベント
            if (progress >= 0.9 && !window.articleRead) {
                window.articleRead = true;
                // ここでアナリティクスイベントを送信
                if (typeof gtag === 'function') {
                    gtag('event', 'article_read', {
                        'event_category': 'engagement',
                        'event_label': document.title
                    });
                }
            }
        }

        window.addEventListener('scroll', function() {
            requestAnimationFrame(updateProgress);
        });
    })();
    </script>
    <?php
}
add_action('wp_footer', 'pout_reading_progress');

/**
 * ========================================
 * ダークモード
 * ========================================
 */

/**
 * ダークモード CSS変数
 */
function pout_dark_mode_styles() {
    ?>
    <style id="dark-mode-styles">
    /* ダークモード CSS変数 */
    :root {
        --color-scheme: light;
    }

    [data-theme="dark"] {
        --color-scheme: dark;
        --color-primary: #60a5fa;
        --color-primary-dark: #3b82f6;
        --color-primary-light: #93c5fd;
        --color-secondary: #94a3b8;
        --color-accent: #fbbf24;
        --color-text: #f1f5f9;
        --color-text-light: #94a3b8;
        --color-text-muted: #64748b;
        --color-bg: #0f172a;
        --color-bg-secondary: #1e293b;
        --color-bg-tertiary: #334155;
        --color-border: #334155;
        --color-border-light: #475569;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.3);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.4);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.4);
        color-scheme: dark;
    }

    /* ダークモード時のスタイル調整 */
    [data-theme="dark"] body {
        background-color: var(--color-bg);
        color: var(--color-text);
    }

    [data-theme="dark"] .site-header {
        background-color: var(--color-bg);
        border-bottom: 1px solid var(--color-border);
    }

    [data-theme="dark"] .site-header.scrolled {
        background-color: rgba(15, 23, 42, 0.95);
    }

    [data-theme="dark"] .btn-outline {
        border-color: var(--color-border);
        color: var(--color-text);
    }

    [data-theme="dark"] .btn-ghost {
        color: var(--color-text);
    }

    [data-theme="dark"] .btn-ghost:hover {
        background-color: var(--color-bg-secondary);
    }

    [data-theme="dark"] .post-card,
    [data-theme="dark"] .card {
        background-color: var(--color-bg-secondary);
        border-color: var(--color-border);
    }

    [data-theme="dark"] .sidebar-widget {
        background-color: var(--color-bg-secondary);
        border-color: var(--color-border);
    }

    [data-theme="dark"] input,
    [data-theme="dark"] textarea,
    [data-theme="dark"] select {
        background-color: var(--color-bg-secondary);
        border-color: var(--color-border);
        color: var(--color-text);
    }

    [data-theme="dark"] input:focus,
    [data-theme="dark"] textarea:focus,
    [data-theme="dark"] select:focus {
        border-color: var(--color-primary);
    }

    [data-theme="dark"] .site-footer {
        background-color: var(--color-bg-secondary);
        border-top: 1px solid var(--color-border);
    }

    [data-theme="dark"] code,
    [data-theme="dark"] pre {
        background-color: var(--color-bg-tertiary);
    }

    [data-theme="dark"] .article-content img {
        opacity: 0.9;
    }

    [data-theme="dark"] .skeleton {
        background: linear-gradient(90deg, #1e293b 25%, #334155 50%, #1e293b 75%);
        background-size: 200% 100%;
    }

    /* ダークモード切り替えボタン */
    .dark-mode-toggle {
        position: relative;
        width: 48px;
        height: 24px;
        background-color: var(--color-bg-secondary);
        border: 1px solid var(--color-border);
        border-radius: 12px;
        cursor: pointer;
        transition: background-color var(--transition-base);
        padding: 0;
    }

    .dark-mode-toggle::before {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 18px;
        height: 18px;
        background-color: var(--color-primary);
        border-radius: 50%;
        transition: transform var(--transition-base);
    }

    [data-theme="dark"] .dark-mode-toggle::before {
        transform: translateX(24px);
    }

    .dark-mode-toggle-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        line-height: 1;
    }

    .dark-mode-toggle-icon.sun {
        left: 6px;
    }

    .dark-mode-toggle-icon.moon {
        right: 6px;
    }

    /* システム設定に従う（デフォルト） */
    @media (prefers-color-scheme: dark) {
        :root:not([data-theme="light"]) {
            --color-scheme: dark;
            --color-primary: #60a5fa;
            --color-primary-dark: #3b82f6;
            --color-primary-light: #93c5fd;
            --color-secondary: #94a3b8;
            --color-accent: #fbbf24;
            --color-text: #f1f5f9;
            --color-text-light: #94a3b8;
            --color-text-muted: #64748b;
            --color-bg: #0f172a;
            --color-bg-secondary: #1e293b;
            --color-bg-tertiary: #334155;
            --color-border: #334155;
            --color-border-light: #475569;
            color-scheme: dark;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'pout_dark_mode_styles', 2);

/**
 * ダークモード切り替えスクリプト
 */
function pout_dark_mode_script() {
    ?>
    <script>
    (function() {
        'use strict';

        const STORAGE_KEY = 'pout-theme';
        const THEME_DARK = 'dark';
        const THEME_LIGHT = 'light';
        const THEME_AUTO = 'auto';

        // 保存されているテーマを取得
        function getStoredTheme() {
            try {
                return localStorage.getItem(STORAGE_KEY);
            } catch (e) {
                return null;
            }
        }

        // テーマを保存
        function setStoredTheme(theme) {
            try {
                localStorage.setItem(STORAGE_KEY, theme);
            } catch (e) {
                // localStorage使用不可
            }
        }

        // システムのカラースキームを取得
        function getSystemTheme() {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? THEME_DARK : THEME_LIGHT;
        }

        // 現在のテーマを取得
        function getCurrentTheme() {
            const stored = getStoredTheme();
            if (stored === THEME_DARK || stored === THEME_LIGHT) {
                return stored;
            }
            return getSystemTheme();
        }

        // テーマを適用
        function applyTheme(theme) {
            const root = document.documentElement;
            if (theme === THEME_DARK) {
                root.setAttribute('data-theme', THEME_DARK);
            } else {
                root.setAttribute('data-theme', THEME_LIGHT);
            }

            // メタタグのtheme-colorも更新
            const themeColorMeta = document.querySelector('meta[name="theme-color"]');
            if (themeColorMeta) {
                themeColorMeta.content = theme === THEME_DARK ? '#0f172a' : '#ffffff';
            }
        }

        // テーマを切り替え
        function toggleTheme() {
            const current = getCurrentTheme();
            const newTheme = current === THEME_DARK ? THEME_LIGHT : THEME_DARK;
            setStoredTheme(newTheme);
            applyTheme(newTheme);
            updateToggleButtons(newTheme);
        }

        // トグルボタンの状態を更新
        function updateToggleButtons(theme) {
            document.querySelectorAll('.dark-mode-toggle').forEach(function(btn) {
                btn.setAttribute('aria-pressed', theme === THEME_DARK);
                btn.setAttribute('aria-label', theme === THEME_DARK ? 'ライトモードに切り替え' : 'ダークモードに切り替え');
            });
        }

        // 初期化
        function init() {
            // 即座にテーマを適用（FOUC防止）
            applyTheme(getCurrentTheme());

            // DOMContentLoaded後にトグルボタンを設定
            document.addEventListener('DOMContentLoaded', function() {
                // トグルボタンにイベントリスナーを追加
                document.querySelectorAll('.dark-mode-toggle').forEach(function(btn) {
                    btn.addEventListener('click', toggleTheme);
                });
                updateToggleButtons(getCurrentTheme());
            });

            // システム設定の変更を監視
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                if (!getStoredTheme() || getStoredTheme() === THEME_AUTO) {
                    applyTheme(e.matches ? THEME_DARK : THEME_LIGHT);
                    updateToggleButtons(e.matches ? THEME_DARK : THEME_LIGHT);
                }
            });
        }

        // グローバルに公開
        window.poutDarkMode = {
            toggle: toggleTheme,
            setTheme: function(theme) {
                setStoredTheme(theme);
                applyTheme(theme === THEME_AUTO ? getSystemTheme() : theme);
            },
            getTheme: getCurrentTheme
        };

        init();
    })();
    </script>
    <?php
}
add_action('wp_head', 'pout_dark_mode_script', 3);
