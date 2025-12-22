<?php
/**
 * AMP Support
 *
 * 基本的なAMP対応機能
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * AMP対応を有効化するかどうか
 */
function pout_amp_enabled() {
    return apply_filters('pout_amp_enabled', true);
}

/**
 * AMPページかどうかを判定
 */
function pout_is_amp() {
    return isset($_GET['amp']) && $_GET['amp'] === '1';
}

/**
 * AMPページURLを取得
 */
function pout_get_amp_url($url = null) {
    if (!$url) {
        $url = get_permalink();
    }
    return add_query_arg('amp', '1', $url);
}

/**
 * 通常ページURLを取得（AMPページから）
 */
function pout_get_canonical_url($url = null) {
    if (!$url) {
        $url = get_permalink();
    }
    return remove_query_arg('amp', $url);
}

/**
 * AMPリンクをhead内に出力
 */
function pout_amp_link_rel() {
    if (!pout_amp_enabled()) {
        return;
    }

    // 投稿ページのみAMP対応
    if (!is_singular('post')) {
        return;
    }

    // AMPページではcanonicalリンクを出力
    if (pout_is_amp()) {
        echo '<link rel="canonical" href="' . esc_url(pout_get_canonical_url()) . '">' . "\n";
    } else {
        // 通常ページではamphtml リンクを出力
        echo '<link rel="amphtml" href="' . esc_url(pout_get_amp_url()) . '">' . "\n";
    }
}
add_action('wp_head', 'pout_amp_link_rel', 1);

/**
 * AMPページ用のテンプレートリダイレクト
 */
function pout_amp_template_redirect() {
    if (!pout_amp_enabled() || !pout_is_amp()) {
        return;
    }

    // 投稿ページ以外はリダイレクト
    if (!is_singular('post')) {
        wp_redirect(remove_query_arg('amp'));
        exit;
    }
}
add_action('template_redirect', 'pout_amp_template_redirect');

/**
 * AMPページ用のコンテンツフィルタ
 */
function pout_amp_content_filter($content) {
    if (!pout_is_amp()) {
        return $content;
    }

    // 禁止されているタグを削除/変換
    $content = pout_amp_sanitize_content($content);

    return $content;
}
add_filter('the_content', 'pout_amp_content_filter', 999);

/**
 * AMPコンテンツのサニタイズ
 */
function pout_amp_sanitize_content($content) {
    // style属性を削除（一部除く）
    $content = preg_replace('/\s+style="[^"]*"/i', '', $content);

    // onclick等のイベントハンドラを削除
    $content = preg_replace('/\s+on\w+="[^"]*"/i', '', $content);

    // imgをamp-imgに変換
    $content = preg_replace_callback(
        '/<img([^>]+)>/i',
        'pout_amp_convert_img',
        $content
    );

    // iframeをamp-iframeに変換
    $content = preg_replace_callback(
        '/<iframe([^>]+)><\/iframe>/i',
        'pout_amp_convert_iframe',
        $content
    );

    // scriptタグを削除（一部除く）
    $content = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $content);

    // YouTube埋め込みをamp-youtubeに変換
    $content = preg_replace_callback(
        '/<amp-iframe[^>]+src="[^"]*youtube\.com\/embed\/([^"?]+)[^"]*"[^>]*>.*?<\/amp-iframe>/is',
        function($matches) {
            $video_id = $matches[1];
            return '<amp-youtube data-videoid="' . esc_attr($video_id) . '" layout="responsive" width="480" height="270"></amp-youtube>';
        },
        $content
    );

    // Twitter埋め込みをamp-twitterに変換
    $content = preg_replace_callback(
        '/class="twitter-tweet"[^>]*>.*?<a[^>]+href="https?:\/\/twitter\.com\/[^\/]+\/status\/(\d+)"[^>]*>.*?<\/blockquote>/is',
        function($matches) {
            $tweet_id = $matches[1];
            return '<amp-twitter data-tweetid="' . esc_attr($tweet_id) . '" layout="responsive" width="375" height="472"></amp-twitter>';
        },
        $content
    );

    return $content;
}

/**
 * imgタグをamp-imgに変換
 */
function pout_amp_convert_img($matches) {
    $attributes = $matches[1];

    // src属性を取得
    preg_match('/src="([^"]+)"/i', $attributes, $src_match);
    $src = isset($src_match[1]) ? $src_match[1] : '';

    // alt属性を取得
    preg_match('/alt="([^"]*)"/i', $attributes, $alt_match);
    $alt = isset($alt_match[1]) ? $alt_match[1] : '';

    // width/height属性を取得
    preg_match('/width="([^"]+)"/i', $attributes, $width_match);
    preg_match('/height="([^"]+)"/i', $attributes, $height_match);

    $width = isset($width_match[1]) ? intval($width_match[1]) : 800;
    $height = isset($height_match[1]) ? intval($height_match[1]) : 600;

    // amp-imgタグを生成
    return sprintf(
        '<amp-img src="%s" alt="%s" width="%d" height="%d" layout="responsive"></amp-img>',
        esc_url($src),
        esc_attr($alt),
        $width,
        $height
    );
}

/**
 * iframeタグをamp-iframeに変換
 */
function pout_amp_convert_iframe($matches) {
    $attributes = $matches[1];

    // src属性を取得
    preg_match('/src="([^"]+)"/i', $attributes, $src_match);
    $src = isset($src_match[1]) ? $src_match[1] : '';

    // HTTPSに変換
    $src = str_replace('http://', 'https://', $src);

    // width/height属性を取得
    preg_match('/width="([^"]+)"/i', $attributes, $width_match);
    preg_match('/height="([^"]+)"/i', $attributes, $height_match);

    $width = isset($width_match[1]) ? intval($width_match[1]) : 600;
    $height = isset($height_match[1]) ? intval($height_match[1]) : 400;

    // amp-iframeタグを生成
    return sprintf(
        '<amp-iframe src="%s" width="%d" height="%d" layout="responsive" sandbox="allow-scripts allow-same-origin" frameborder="0"><amp-img layout="fill" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" placeholder></amp-img></amp-iframe>',
        esc_url($src),
        $width,
        $height
    );
}

/**
 * AMPページ用のhead出力
 */
function pout_amp_head() {
    if (!pout_is_amp()) {
        return;
    }

    // AMP必須スクリプト
    echo '<script async src="https://cdn.ampproject.org/v0.js"></script>' . "\n";

    // AMP拡張コンポーネント
    $extensions = array(
        'amp-analytics'  => 'https://cdn.ampproject.org/v0/amp-analytics-0.1.js',
        'amp-iframe'     => 'https://cdn.ampproject.org/v0/amp-iframe-0.1.js',
        'amp-youtube'    => 'https://cdn.ampproject.org/v0/amp-youtube-0.1.js',
        'amp-twitter'    => 'https://cdn.ampproject.org/v0/amp-twitter-0.1.js',
        'amp-accordion'  => 'https://cdn.ampproject.org/v0/amp-accordion-0.1.js',
        'amp-sidebar'    => 'https://cdn.ampproject.org/v0/amp-sidebar-0.1.js',
    );

    foreach ($extensions as $name => $src) {
        echo '<script async custom-element="' . esc_attr($name) . '" src="' . esc_url($src) . '"></script>' . "\n";
    }
}
add_action('wp_head', 'pout_amp_head', 0);

/**
 * AMPページ用のboilerplate CSS
 */
function pout_amp_boilerplate() {
    if (!pout_is_amp()) {
        return;
    }
    ?>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style>
    <noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <?php
}
add_action('wp_head', 'pout_amp_boilerplate', 1);

/**
 * AMPページ用のカスタムCSS
 */
function pout_amp_custom_css() {
    if (!pout_is_amp()) {
        return;
    }
    ?>
    <style amp-custom>
    /* AMP用ベーススタイル */
    :root {
        --color-primary: #2563eb;
        --color-text: #1a1a1a;
        --color-text-light: #64748b;
        --color-bg: #ffffff;
        --max-width: 800px;
    }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        font-family: 'Noto Sans JP', -apple-system, BlinkMacSystemFont, sans-serif;
        font-size: 16px;
        line-height: 1.8;
        color: var(--color-text);
        background: var(--color-bg);
    }
    .amp-header {
        position: sticky;
        top: 0;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 1rem;
        z-index: 100;
    }
    .amp-header-inner {
        max-width: var(--max-width);
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .amp-logo { font-weight: 700; font-size: 1.25rem; color: var(--color-text); text-decoration: none; }
    .amp-main { max-width: var(--max-width); margin: 0 auto; padding: 2rem 1rem; }
    .amp-article-header { margin-bottom: 2rem; }
    .amp-article-title { font-size: 1.75rem; margin: 0 0 1rem; line-height: 1.4; }
    .amp-article-meta { color: var(--color-text-light); font-size: 0.875rem; }
    .amp-article-content { font-size: 1rem; }
    .amp-article-content h2 { font-size: 1.5rem; margin: 2rem 0 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--color-primary); }
    .amp-article-content h3 { font-size: 1.25rem; margin: 1.5rem 0 0.75rem; }
    .amp-article-content p { margin: 0 0 1.5rem; }
    .amp-article-content a { color: var(--color-primary); }
    .amp-article-content amp-img { margin: 1.5rem 0; }
    .amp-article-content blockquote { margin: 1.5rem 0; padding: 1rem 1.5rem; background: #f8fafc; border-left: 4px solid var(--color-primary); }
    .amp-article-content pre { background: #1e293b; color: #e2e8f0; padding: 1rem; overflow-x: auto; border-radius: 0.5rem; }
    .amp-article-content code { font-family: 'JetBrains Mono', monospace; font-size: 0.875em; }
    .amp-footer { background: #f8fafc; padding: 2rem 1rem; text-align: center; border-top: 1px solid #e5e7eb; }
    .amp-footer-link { color: var(--color-primary); margin: 0 0.5rem; }
    .amp-cta { background: var(--color-primary); color: #fff; padding: 2rem; text-align: center; margin: 2rem 0; border-radius: 0.5rem; }
    .amp-cta-title { font-size: 1.25rem; margin: 0 0 0.5rem; }
    .amp-cta-btn { display: inline-block; background: #fff; color: var(--color-primary); padding: 0.75rem 1.5rem; border-radius: 0.25rem; text-decoration: none; font-weight: 600; margin-top: 1rem; }
    .amp-related { margin: 2rem 0; padding: 1.5rem; background: #f8fafc; border-radius: 0.5rem; }
    .amp-related-title { font-size: 1.125rem; margin: 0 0 1rem; }
    .amp-related-list { list-style: none; padding: 0; margin: 0; }
    .amp-related-item { margin-bottom: 0.75rem; }
    .amp-related-item a { color: var(--color-text); text-decoration: none; }
    .amp-related-item a:hover { color: var(--color-primary); }
    </style>
    <?php
}
add_action('wp_head', 'pout_amp_custom_css', 2);

/**
 * AMPページでは通常のスクリプト/スタイルを無効化
 */
function pout_amp_disable_scripts() {
    if (!pout_is_amp()) {
        return;
    }

    // 全てのスクリプトをデキュー
    global $wp_scripts;
    if (isset($wp_scripts->queue) && is_array($wp_scripts->queue)) {
        foreach ($wp_scripts->queue as $handle) {
            wp_dequeue_script($handle);
        }
    }

    // 全てのスタイルをデキュー
    global $wp_styles;
    if (isset($wp_styles->queue) && is_array($wp_styles->queue)) {
        foreach ($wp_styles->queue as $handle) {
            wp_dequeue_style($handle);
        }
    }
}
add_action('wp_enqueue_scripts', 'pout_amp_disable_scripts', 999);

/**
 * AMP Google Analytics
 */
function pout_amp_analytics() {
    if (!pout_is_amp()) {
        return;
    }

    $ga_id = get_theme_mod('pout_ga_id', '');
    if (!$ga_id) {
        return;
    }
    ?>
    <amp-analytics type="gtag" data-credentials="include">
        <script type="application/json">
        {
            "vars": {
                "gtag_id": "<?php echo esc_js($ga_id); ?>",
                "config": {
                    "<?php echo esc_js($ga_id); ?>": {
                        "groups": "default"
                    }
                }
            }
        }
        </script>
    </amp-analytics>
    <?php
}
add_action('wp_footer', 'pout_amp_analytics');

/**
 * AMPバリデーションエラーログ（開発用）
 */
function pout_amp_validation_log() {
    if (!pout_is_amp() || !WP_DEBUG) {
        return;
    }
    ?>
    <script>
    // AMP validation errors will be logged to console in development mode
    </script>
    <?php
}
