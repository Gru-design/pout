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
