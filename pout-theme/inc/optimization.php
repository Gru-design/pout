<?php
/**
 * Optimization & Security
 *
 * 高速化・セキュリティ対策
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ========================================
 * 高速化
 * ========================================
 */

/**
 * 不要なヘッダー出力を削除
 */
function pout_remove_unnecessary_headers() {
    // WordPress バージョン
    remove_action('wp_head', 'wp_generator');

    // Windows Live Writer
    remove_action('wp_head', 'wlwmanifest_link');

    // RSD
    remove_action('wp_head', 'rsd_link');

    // 短縮URL
    remove_action('wp_head', 'wp_shortlink_wp_head');

    // 絵文字
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');

    // REST API リンク
    remove_action('wp_head', 'rest_output_link_wp_head');

    // oEmbed
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');

    // DNS Prefetch
    remove_action('wp_head', 'wp_resource_hints', 2);

    // 投稿リレーション
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
}
add_action('init', 'pout_remove_unnecessary_headers');

/**
 * クエリストリングを削除
 */
function pout_remove_query_strings($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'pout_remove_query_strings', 10);
add_filter('script_loader_src', 'pout_remove_query_strings', 10);

/**
 * jQueryをフッターに移動
 */
function pout_move_jquery_to_footer() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js'), array(), null, true);
        wp_enqueue_script('jquery');
    }
}
// add_action('wp_enqueue_scripts', 'pout_move_jquery_to_footer');

/**
 * 不要なスクリプト・スタイルの遅延読み込み
 */
function pout_defer_scripts($tag, $handle, $src) {
    // 除外するスクリプト
    $exclude = array('jquery', 'jquery-core', 'jquery-migrate');

    if (in_array($handle, $exclude)) {
        return $tag;
    }

    // defer属性を追加
    if (strpos($tag, 'defer') === false && strpos($tag, 'async') === false) {
        $tag = str_replace(' src=', ' defer src=', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'pout_defer_scripts', 10, 3);

/**
 * CSSをプリロード
 */
function pout_preload_styles() {
    // 重要なCSSをプリロード
    $preload_styles = array(
        'pout-main' => get_template_directory_uri() . '/assets/css/main.css',
    );

    foreach ($preload_styles as $handle => $href) {
        echo '<link rel="preload" href="' . esc_url($href) . '" as="style">' . "\n";
    }
}
add_action('wp_head', 'pout_preload_styles', 1);

/**
 * 重要なフォントをプリロード
 */
function pout_preload_fonts() {
    // Google Fonts をプリコネクト
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'pout_preload_fonts', 1);

/**
 * 画像の遅延読み込み（ネイティブ）
 */
function pout_add_lazy_loading($content) {
    if (is_admin()) {
        return $content;
    }

    // img タグに loading="lazy" を追加
    $content = preg_replace(
        '/<img(?![^>]*loading=)([^>]*)>/i',
        '<img loading="lazy"$1>',
        $content
    );

    // iframe タグに loading="lazy" を追加
    $content = preg_replace(
        '/<iframe(?![^>]*loading=)([^>]*)>/i',
        '<iframe loading="lazy"$1>',
        $content
    );

    return $content;
}
add_filter('the_content', 'pout_add_lazy_loading');
add_filter('post_thumbnail_html', 'pout_add_lazy_loading');

/**
 * WebP 対応チェック
 */
function pout_supports_webp() {
    return isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
}

/**
 * HTTP/2 サーバープッシュ
 */
function pout_server_push() {
    if (is_admin()) {
        return;
    }

    $resources = array(
        array(
            'uri'  => get_template_directory_uri() . '/assets/css/main.css',
            'type' => 'style',
        ),
        array(
            'uri'  => get_template_directory_uri() . '/assets/js/scripts.js',
            'type' => 'script',
        ),
    );

    $push_links = array();
    foreach ($resources as $resource) {
        $push_links[] = sprintf(
            '<%s>; rel=preload; as=%s',
            esc_url($resource['uri']),
            esc_attr($resource['type'])
        );
    }

    if (!empty($push_links)) {
        header('Link: ' . implode(', ', $push_links), false);
    }
}
add_action('send_headers', 'pout_server_push');

/**
 * ========================================
 * セキュリティ
 * ========================================
 */

/**
 * セキュリティヘッダー追加
 */
function pout_security_headers() {
    if (is_admin()) {
        return;
    }

    // X-Content-Type-Options
    header('X-Content-Type-Options: nosniff');

    // X-Frame-Options
    header('X-Frame-Options: SAMEORIGIN');

    // X-XSS-Protection
    header('X-XSS-Protection: 1; mode=block');

    // Referrer-Policy
    header('Referrer-Policy: strict-origin-when-cross-origin');

    // Permissions-Policy
    header("Permissions-Policy: camera=(), microphone=(), geolocation=()");
}
add_action('send_headers', 'pout_security_headers');

/**
 * XML-RPC を無効化
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * REST API を制限（認証ユーザーのみ）
 */
function pout_restrict_rest_api($result) {
    // ログインしていないユーザーには一部のエンドポイントを制限
    if (!is_user_logged_in()) {
        // 許可するエンドポイント
        $allowed_endpoints = array(
            '/wp/v2/posts',
            '/wp/v2/pages',
            '/wp/v2/categories',
            '/wp/v2/tags',
        );

        $request_route = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

        // wp-json 以降のパスを取得
        if (preg_match('/\/wp-json(\/.*)?/', $request_route, $matches)) {
            $endpoint = isset($matches[1]) ? $matches[1] : '';

            // /users エンドポイントをブロック
            if (strpos($endpoint, '/wp/v2/users') !== false) {
                return new WP_Error(
                    'rest_forbidden',
                    __('アクセスが拒否されました。', 'pout-theme'),
                    array('status' => 403)
                );
            }
        }
    }

    return $result;
}
add_filter('rest_authentication_errors', 'pout_restrict_rest_api');

/**
 * ログイン試行を制限
 */
function pout_limit_login_attempts() {
    $max_attempts = 5;
    $lockout_duration = 15 * MINUTE_IN_SECONDS;

    $ip = $_SERVER['REMOTE_ADDR'];
    $transient_key = 'login_attempts_' . md5($ip);

    $attempts = get_transient($transient_key);

    if ($attempts === false) {
        $attempts = 0;
    }

    if ($attempts >= $max_attempts) {
        wp_die(
            __('ログイン試行回数の上限に達しました。しばらくしてから再試行してください。', 'pout-theme'),
            __('ログインブロック', 'pout-theme'),
            array('response' => 403)
        );
    }
}
add_action('wp_login_failed', 'pout_record_failed_login');

function pout_record_failed_login($username) {
    $lockout_duration = 15 * MINUTE_IN_SECONDS;

    $ip = $_SERVER['REMOTE_ADDR'];
    $transient_key = 'login_attempts_' . md5($ip);

    $attempts = get_transient($transient_key);

    if ($attempts === false) {
        $attempts = 0;
    }

    $attempts++;
    set_transient($transient_key, $attempts, $lockout_duration);
}

function pout_reset_login_attempts($user_login, $user) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $transient_key = 'login_attempts_' . md5($ip);
    delete_transient($transient_key);
}
add_action('wp_login', 'pout_reset_login_attempts', 10, 2);

/**
 * ログインエラーメッセージを汎用化
 */
function pout_login_error_message($error) {
    return __('ユーザー名またはパスワードが正しくありません。', 'pout-theme');
}
add_filter('login_errors', 'pout_login_error_message');

/**
 * ファイルエディターを無効化
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

/**
 * ピングバックを無効化
 */
function pout_disable_pingbacks(&$links) {
    foreach ($links as $l => $link) {
        if (0 === strpos($link, get_option('home'))) {
            unset($links[$l]);
        }
    }
}
add_action('pre_ping', 'pout_disable_pingbacks');

/**
 * コメントのHTMLを制限
 */
function pout_comment_allowed_tags() {
    return array(
        'a'      => array('href' => true, 'title' => true),
        'strong' => array(),
        'em'     => array(),
        'code'   => array(),
    );
}
add_filter('comment_text', 'wp_kses_post');

/**
 * アップロードファイルタイプを制限
 */
function pout_restrict_upload_mimes($mimes) {
    // 許可するファイルタイプ
    $allowed = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'webp'         => 'image/webp',
        'svg'          => 'image/svg+xml',
        'pdf'          => 'application/pdf',
        'doc'          => 'application/msword',
        'docx'         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls'          => 'application/vnd.ms-excel',
        'xlsx'         => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'zip'          => 'application/zip',
    );

    return $allowed;
}
add_filter('upload_mimes', 'pout_restrict_upload_mimes');

/**
 * ========================================
 * キャッシュ
 * ========================================
 */

/**
 * ブラウザキャッシュヘッダー
 */
function pout_cache_headers() {
    if (is_admin()) {
        return;
    }

    // 静的ファイル用のキャッシュヘッダー
    if (is_singular()) {
        $max_age = 3600; // 1時間
    } else {
        $max_age = 300; // 5分
    }

    header('Cache-Control: public, max-age=' . $max_age);
}
// add_action('send_headers', 'pout_cache_headers');

/**
 * ========================================
 * データベース最適化
 * ========================================
 */

/**
 * 投稿リビジョンを制限
 */
if (!defined('WP_POST_REVISIONS')) {
    define('WP_POST_REVISIONS', 5);
}

/**
 * 自動保存間隔を延長
 */
if (!defined('AUTOSAVE_INTERVAL')) {
    define('AUTOSAVE_INTERVAL', 120); // 2分
}

/**
 * 不要なトランジェントをクリーンアップ
 */
function pout_cleanup_expired_transients() {
    global $wpdb;

    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s AND option_value < %d",
            '_transient_timeout_%',
            time()
        )
    );

    $wpdb->query(
        "DELETE a FROM {$wpdb->options} a
        LEFT JOIN {$wpdb->options} b ON b.option_name = CONCAT('_transient_timeout_', SUBSTRING(a.option_name, 12))
        WHERE a.option_name LIKE '_transient_%' AND a.option_name NOT LIKE '_transient_timeout_%' AND b.option_name IS NULL"
    );
}
add_action('wp_scheduled_delete', 'pout_cleanup_expired_transients');

/**
 * ========================================
 * 管理画面最適化
 * ========================================
 */

/**
 * 管理画面のダッシュボードウィジェットを削除
 */
function pout_remove_dashboard_widgets() {
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    remove_action('welcome_panel', 'wp_welcome_panel');
}
add_action('wp_dashboard_setup', 'pout_remove_dashboard_widgets');

/**
 * 管理バーからWordPressロゴを削除
 */
function pout_remove_admin_bar_items($wp_admin_bar) {
    $wp_admin_bar->remove_node('wp-logo');
    $wp_admin_bar->remove_node('comments');
}
add_action('admin_bar_menu', 'pout_remove_admin_bar_items', 999);

/**
 * ========================================
 * Critical CSS（ファーストビュー最適化）
 * ========================================
 */

/**
 * Critical CSS をインライン出力
 */
function pout_critical_css() {
    ?>
    <style id="critical-css">
    /* Critical CSS - ファーストビューに必要な最小限のスタイル */
    *,*::before,*::after{box-sizing:border-box}
    :root{
        --color-primary:#2563eb;
        --color-primary-dark:#1d4ed8;
        --color-secondary:#64748b;
        --color-accent:#f59e0b;
        --color-text:#1a1a1a;
        --color-text-light:#64748b;
        --color-bg:#ffffff;
        --color-bg-secondary:#f8fafc;
        --font-sans:'Noto Sans JP',-apple-system,BlinkMacSystemFont,sans-serif;
        --max-width:1200px;
        --header-height:80px;
        --spacing-4:1rem;
        --spacing-6:1.5rem;
        --spacing-8:2rem;
        --radius-md:0.5rem;
        --shadow-md:0 4px 6px -1px rgb(0 0 0/0.1);
        --transition-base:200ms ease;
    }
    html{font-size:16px;line-height:1.5;-webkit-text-size-adjust:100%}
    body{margin:0;font-family:var(--font-sans);color:var(--color-text);background:var(--color-bg)}
    img,video{max-width:100%;height:auto;display:block}
    a{color:var(--color-primary);text-decoration:none}
    h1,h2,h3,h4,h5,h6{margin:0 0 1rem;line-height:1.3;font-weight:700}
    p{margin:0 0 1rem}
    .container{width:100%;max-width:var(--max-width);margin:0 auto;padding:0 var(--spacing-4)}
    .site-header{position:fixed;top:0;left:0;right:0;height:var(--header-height);background:var(--color-bg);z-index:1000;transition:transform var(--transition-base),box-shadow var(--transition-base)}
    .site-header.scrolled{box-shadow:var(--shadow-md)}
    .header-inner{display:flex;align-items:center;justify-content:space-between;height:var(--header-height);padding:0 var(--spacing-4)}
    .site-logo img{height:40px;width:auto}
    .primary-menu{display:flex;gap:var(--spacing-6);list-style:none;margin:0;padding:0}
    .primary-menu a{color:var(--color-text);font-weight:500;transition:color var(--transition-base)}
    .primary-menu a:hover{color:var(--color-primary)}
    .btn{display:inline-flex;align-items:center;justify-content:center;padding:0.75rem 1.5rem;font-weight:600;border-radius:var(--radius-md);transition:all var(--transition-base);cursor:pointer;border:none}
    .btn-primary{background:var(--color-primary);color:#fff}
    .btn-primary:hover{background:var(--color-primary-dark)}
    .hero{padding:calc(var(--header-height) + var(--spacing-8)) 0 var(--spacing-8);min-height:80vh;display:flex;align-items:center}
    .hero-title{font-size:clamp(2rem,5vw,3.5rem);margin-bottom:var(--spacing-4)}
    .hero-description{font-size:1.125rem;color:var(--color-text-light);max-width:600px}
    .mobile-menu-toggle{display:none;padding:0.5rem;background:none;border:none;cursor:pointer}
    .hamburger{display:block;width:24px;height:2px;background:var(--color-text);position:relative}
    .hamburger::before,.hamburger::after{content:'';position:absolute;width:24px;height:2px;background:var(--color-text);left:0}
    .hamburger::before{top:-8px}
    .hamburger::after{top:8px}
    @media(max-width:768px){
        .primary-menu{display:none}
        .mobile-menu-toggle{display:block}
        .hero-title{font-size:clamp(1.75rem,6vw,2.5rem)}
    }
    /* スケルトンローダー（FOUC防止） */
    .skeleton-loading{background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:skeleton 1.5s infinite}
    @keyframes skeleton{0%{background-position:200% 0}100%{background-position:-200% 0}}
    </style>
    <?php
}
add_action('wp_head', 'pout_critical_css', 0);

/**
 * メインCSSを非同期読み込み
 */
function pout_async_css($html, $handle, $href, $media) {
    if (is_admin()) {
        return $html;
    }

    // 非同期読み込み対象のスタイル
    $async_styles = array('pout-main', 'pout-style');

    if (in_array($handle, $async_styles)) {
        // preloadで非同期読み込み、onloadでstylesheetに切り替え
        $html = sprintf(
            '<link rel="preload" href="%s" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n" .
            '<noscript><link rel="stylesheet" href="%s"></noscript>' . "\n",
            esc_url($href),
            esc_url($href)
        );
    }

    return $html;
}
add_filter('style_loader_tag', 'pout_async_css', 10, 4);

/**
 * ========================================
 * WebP 画像最適化
 * ========================================
 */

/**
 * 画像アップロード時にWebPを自動生成
 */
function pout_generate_webp_on_upload($metadata, $attachment_id) {
    // WebP変換が可能かチェック
    if (!function_exists('imagewebp')) {
        return $metadata;
    }

    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . '/' . $metadata['file'];

    // 対応する画像形式のみ処理
    $mime_type = get_post_mime_type($attachment_id);
    $supported_types = array('image/jpeg', 'image/png');

    if (!in_array($mime_type, $supported_types)) {
        return $metadata;
    }

    // オリジナル画像をWebPに変換
    pout_convert_to_webp($file_path);

    // 各サイズの画像もWebPに変換
    if (isset($metadata['sizes']) && is_array($metadata['sizes'])) {
        $file_dir = dirname($file_path);
        foreach ($metadata['sizes'] as $size => $size_data) {
            $size_path = $file_dir . '/' . $size_data['file'];
            pout_convert_to_webp($size_path);
        }
    }

    return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'pout_generate_webp_on_upload', 10, 2);

/**
 * 画像をWebPに変換
 */
function pout_convert_to_webp($source_path, $quality = 80) {
    if (!file_exists($source_path)) {
        return false;
    }

    $webp_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $source_path);

    // すでにWebPが存在する場合はスキップ
    if (file_exists($webp_path)) {
        return $webp_path;
    }

    $mime_type = mime_content_type($source_path);
    $image = null;

    switch ($mime_type) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source_path);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source_path);
            // PNG透過を保持
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            break;
        default:
            return false;
    }

    if (!$image) {
        return false;
    }

    $result = imagewebp($image, $webp_path, $quality);
    imagedestroy($image);

    return $result ? $webp_path : false;
}

/**
 * 画像削除時にWebPも削除
 */
function pout_delete_webp_on_attachment_delete($attachment_id) {
    $metadata = wp_get_attachment_metadata($attachment_id);

    if (!$metadata || !isset($metadata['file'])) {
        return;
    }

    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . '/' . $metadata['file'];
    $webp_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file_path);

    if (file_exists($webp_path)) {
        unlink($webp_path);
    }

    // 各サイズのWebPも削除
    if (isset($metadata['sizes']) && is_array($metadata['sizes'])) {
        $file_dir = dirname($file_path);
        foreach ($metadata['sizes'] as $size_data) {
            $size_webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file_dir . '/' . $size_data['file']);
            if (file_exists($size_webp)) {
                unlink($size_webp);
            }
        }
    }
}
add_action('delete_attachment', 'pout_delete_webp_on_attachment_delete');

/**
 * pictureタグでWebPを優先表示
 */
function pout_webp_picture_tag($content) {
    if (is_admin() || empty($content)) {
        return $content;
    }

    // imgタグを検索
    $pattern = '/<img([^>]+)src=["\']([^"\']+\.(jpe?g|png))["\']([^>]*)>/i';

    $content = preg_replace_callback($pattern, function($matches) {
        $before_src = $matches[1];
        $src = $matches[2];
        $ext = $matches[3];
        $after_src = $matches[4];

        // WebPパスを生成
        $webp_src = preg_replace('/\.(jpe?g|png)$/i', '.webp', $src);

        // WebPファイルの存在チェック（相対パスの場合）
        $upload_dir = wp_upload_dir();
        $webp_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $webp_src);

        // WebPが存在しない場合は元のimgタグを返す
        if (!file_exists($webp_path)) {
            return $matches[0];
        }

        // pictureタグで包む
        $picture = '<picture>';
        $picture .= '<source srcset="' . esc_url($webp_src) . '" type="image/webp">';
        $picture .= '<img' . $before_src . 'src="' . esc_url($src) . '"' . $after_src . '>';
        $picture .= '</picture>';

        return $picture;
    }, $content);

    return $content;
}
add_filter('the_content', 'pout_webp_picture_tag', 100);
add_filter('post_thumbnail_html', 'pout_webp_picture_tag', 100);

/**
 * WebP対応ブラウザにはWebPを返す（.htaccess用ヘルパー）
 */
function pout_webp_htaccess_rules($rules) {
    $webp_rules = <<<HTACCESS

# WebP画像の配信
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP_ACCEPT} image/webp
    RewriteCond %{REQUEST_FILENAME} (.*)\.(jpe?g|png)$
    RewriteCond %{REQUEST_FILENAME}.webp -f
    RewriteRule ^(.+)\.(jpe?g|png)$ $1.webp [T=image/webp,E=WEBP:1,L]
</IfModule>

<IfModule mod_headers.c>
    Header append Vary Accept env=WEBP
</IfModule>

HTACCESS;

    return $webp_rules . $rules;
}
// add_filter('mod_rewrite_rules', 'pout_webp_htaccess_rules');

/**
 * ========================================
 * ローカルフォントホスティング
 * ========================================
 */

/**
 * ローカルフォント設定をカスタマイザーに追加
 */
function pout_local_fonts_customizer($wp_customize) {
    $wp_customize->add_section('pout_fonts', array(
        'title'    => __('フォント設定', 'pout-theme'),
        'priority' => 45,
    ));

    // ローカルフォント有効化
    $wp_customize->add_setting('pout_local_fonts_enabled', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('pout_local_fonts_enabled', array(
        'label'       => __('ローカルフォントを使用', 'pout-theme'),
        'description' => __('Google FontsをローカルにホストしてGDPR対応＆高速化', 'pout-theme'),
        'section'     => 'pout_fonts',
        'type'        => 'checkbox',
    ));

    // 日本語フォント選択
    $wp_customize->add_setting('pout_japanese_font', array(
        'default'           => 'noto-sans-jp',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pout_japanese_font', array(
        'label'   => __('日本語フォント', 'pout-theme'),
        'section' => 'pout_fonts',
        'type'    => 'select',
        'choices' => array(
            'noto-sans-jp' => 'Noto Sans JP',
            'zen-kaku-gothic' => 'Zen Kaku Gothic New',
            'system' => 'システムフォント',
        ),
    ));
}
add_action('customize_register', 'pout_local_fonts_customizer');

/**
 * ローカルフォントディレクトリを取得
 */
function pout_get_fonts_dir() {
    return get_template_directory() . '/assets/fonts';
}

function pout_get_fonts_url() {
    return get_template_directory_uri() . '/assets/fonts';
}

/**
 * ローカルフォントのCSSを出力
 */
function pout_local_fonts_css() {
    if (!get_theme_mod('pout_local_fonts_enabled', false)) {
        return;
    }

    $font = get_theme_mod('pout_japanese_font', 'noto-sans-jp');
    $fonts_url = pout_get_fonts_url();

    if ($font === 'system') {
        ?>
        <style id="pout-local-fonts">
        :root {
            --font-sans: -apple-system, BlinkMacSystemFont, "Segoe UI", "Hiragino Sans", "Hiragino Kaku Gothic ProN", "Yu Gothic UI", Meiryo, sans-serif;
        }
        </style>
        <?php
        return;
    }

    $font_faces = array(
        'noto-sans-jp' => array(
            'family' => 'Noto Sans JP',
            'weights' => array(400, 500, 700),
            'file_prefix' => 'NotoSansJP',
        ),
        'zen-kaku-gothic' => array(
            'family' => 'Zen Kaku Gothic New',
            'weights' => array(400, 500, 700),
            'file_prefix' => 'ZenKakuGothicNew',
        ),
    );

    if (!isset($font_faces[$font])) {
        return;
    }

    $font_config = $font_faces[$font];
    ?>
    <style id="pout-local-fonts">
    <?php foreach ($font_config['weights'] as $weight) : ?>
    @font-face {
        font-family: '<?php echo esc_attr($font_config['family']); ?>';
        font-style: normal;
        font-weight: <?php echo intval($weight); ?>;
        font-display: swap;
        src: url('<?php echo esc_url($fonts_url . '/' . $font_config['file_prefix'] . '-' . $weight . '.woff2'); ?>') format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD, U+3000-9FFF, U+FF00-FFEF;
    }
    <?php endforeach; ?>
    :root {
        --font-sans: '<?php echo esc_attr($font_config['family']); ?>', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    </style>
    <?php
}
add_action('wp_head', 'pout_local_fonts_css', 2);

/**
 * ローカルフォント使用時はGoogle Fontsを読み込まない
 */
function pout_disable_google_fonts_preconnect() {
    if (get_theme_mod('pout_local_fonts_enabled', false)) {
        // pout_preload_fonts の preconnect を無効化
        remove_action('wp_head', 'pout_preload_fonts', 1);
    }
}
add_action('init', 'pout_disable_google_fonts_preconnect');

/**
 * Google Fontsをローカルにダウンロード（管理画面用）
 */
function pout_download_google_fonts() {
    if (!current_user_can('manage_options')) {
        wp_die(__('権限がありません。', 'pout-theme'));
    }

    check_admin_referer('pout_download_fonts');

    $fonts_dir = pout_get_fonts_dir();

    // フォントディレクトリを作成
    if (!file_exists($fonts_dir)) {
        wp_mkdir_p($fonts_dir);
    }

    // Noto Sans JP のダウンロードURL（Google Fonts API）
    $font_urls = array(
        'NotoSansJP-400.woff2' => 'https://fonts.gstatic.com/s/notosansjp/v52/-F6jfjtqLzI2JPCgQBnw7HFyzSD-AsregP8VFBEj75vY0rw-oME.woff2',
        'NotoSansJP-500.woff2' => 'https://fonts.gstatic.com/s/notosansjp/v52/-F6jfjtqLzI2JPCgQBnw7HFyzSD-AsregP8VFCsj75vY0rw-oME.woff2',
        'NotoSansJP-700.woff2' => 'https://fonts.gstatic.com/s/notosansjp/v52/-F6jfjtqLzI2JPCgQBnw7HFyzSD-AsregP8VFJQg75vY0rw-oME.woff2',
    );

    $downloaded = 0;
    foreach ($font_urls as $filename => $url) {
        $file_path = $fonts_dir . '/' . $filename;

        if (file_exists($file_path)) {
            continue;
        }

        $response = wp_remote_get($url, array('timeout' => 30));

        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            file_put_contents($file_path, wp_remote_retrieve_body($response));
            $downloaded++;
        }
    }

    wp_redirect(add_query_arg(array(
        'page' => 'pout-settings',
        'fonts_downloaded' => $downloaded,
    ), admin_url('themes.php')));
    exit;
}
