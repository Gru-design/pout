<?php
/**
 * Pout Theme Functions
 *
 * テーマの全機能を統括する司令塔
 *
 * @package Pout_Theme
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// テーマ定数
define('POUT_THEME_VERSION', '2.0.0');
define('POUT_THEME_DIR', get_template_directory());
define('POUT_THEME_URI', get_template_directory_uri());

/**
 * テーマセットアップ
 */
function pout_theme_setup() {
    // タイトルタグ自動出力
    add_theme_support('title-tag');

    // アイキャッチ画像
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 630, true);
    add_image_size('pout-card', 400, 210, true);
    add_image_size('pout-hero', 1920, 1080, true);

    // HTML5マークアップ
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // カスタムロゴ
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // 自動フィードリンク
    add_theme_support('automatic-feed-links');

    // レスポンシブ埋め込み
    add_theme_support('responsive-embeds');

    // エディタースタイル
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // ナビゲーションメニュー登録
    register_nav_menus(array(
        'primary'   => __('メインメニュー', 'pout-theme'),
        'footer'    => __('フッターメニュー', 'pout-theme'),
        'mobile'    => __('モバイルメニュー', 'pout-theme'),
    ));

    // 翻訳ファイル
    load_theme_textdomain('pout-theme', POUT_THEME_DIR . '/languages');
}
add_action('after_setup_theme', 'pout_theme_setup');

/**
 * スタイル・スクリプト読み込み
 */
function pout_enqueue_assets() {
    // メインスタイル
    wp_enqueue_style(
        'pout-main',
        POUT_THEME_URI . '/assets/css/main.css',
        array(),
        POUT_THEME_VERSION
    );

    // テーマスタイル
    wp_enqueue_style(
        'pout-style',
        get_stylesheet_uri(),
        array('pout-main'),
        POUT_THEME_VERSION
    );

    // メインスクリプト
    wp_enqueue_script(
        'pout-scripts',
        POUT_THEME_URI . '/assets/js/scripts.js',
        array(),
        POUT_THEME_VERSION,
        true
    );

    // スクリプトにデータを渡す
    wp_localize_script('pout-scripts', 'poutData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('pout_nonce'),
        'homeUrl' => home_url('/'),
    ));

    // コメント返信スクリプト
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'pout_enqueue_assets');

/**
 * ウィジェットエリア登録
 */
function pout_widgets_init() {
    register_sidebar(array(
        'name'          => __('サイドバー', 'pout-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('メインサイドバー', 'pout-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('フッターウィジェット1', 'pout-theme'),
        'id'            => 'footer-1',
        'description'   => __('フッター左エリア', 'pout-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('フッターウィジェット2', 'pout-theme'),
        'id'            => 'footer-2',
        'description'   => __('フッター中央エリア', 'pout-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('フッターウィジェット3', 'pout-theme'),
        'id'            => 'footer-3',
        'description'   => __('フッター右エリア', 'pout-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'pout_widgets_init');

/**
 * カスタム投稿タイプ: Tools（エコシステム）
 */
function pout_register_post_types() {
    register_post_type('tools', array(
        'labels' => array(
            'name'               => __('ツール', 'pout-theme'),
            'singular_name'      => __('ツール', 'pout-theme'),
            'add_new'            => __('新規追加', 'pout-theme'),
            'add_new_item'       => __('新規ツールを追加', 'pout-theme'),
            'edit_item'          => __('ツールを編集', 'pout-theme'),
            'view_item'          => __('ツールを表示', 'pout-theme'),
            'search_items'       => __('ツールを検索', 'pout-theme'),
            'not_found'          => __('ツールが見つかりません', 'pout-theme'),
        ),
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'tools'),
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon'          => 'dashicons-admin-tools',
        'show_in_rest'       => true,
    ));
}
add_action('init', 'pout_register_post_types');

/**
 * 機能モジュール読み込み
 */
$pout_modules = array(
    'inc/seo.php',           // SEO・構造化データ
    'inc/shortcodes.php',    // ショートコード
    'inc/cta.php',           // CTA自動挿入
    'inc/optimization.php',  // 高速化・セキュリティ
    'inc/advanced-ux.php',   // UX強化
    'inc/extras.php',        // 便利ツール
    'inc/contact-logic.php', // フォーム処理
    'inc/amp.php',           // AMP対応
);

foreach ($pout_modules as $module) {
    $module_path = POUT_THEME_DIR . '/' . $module;
    if (file_exists($module_path)) {
        require_once $module_path;
    }
}

/**
 * ページタイプ判定ヘルパー
 */
function pout_get_page_type() {
    if (is_front_page()) {
        return 'corporate';
    } elseif (is_page_template('page-medecheck.php') || is_page('medecheck')) {
        return 'medecheck';
    } elseif (is_page_template('page-resumake.php') || is_page('resumake')) {
        return 'service';
    } elseif (is_page_template('page-contact.php') || is_page('contact')) {
        return 'contact';
    } elseif (is_home() || is_category() || is_tag() || is_archive()) {
        return 'media';
    } elseif (is_singular('post')) {
        return 'article';
    } elseif (is_post_type_archive('tools') || is_singular('tools')) {
        return 'ecosystem';
    }
    return 'default';
}

/**
 * 抜粋の長さ調整
 */
function pout_excerpt_length($length) {
    return 80;
}
add_filter('excerpt_length', 'pout_excerpt_length');

/**
 * 抜粋の末尾
 */
function pout_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'pout_excerpt_more');

/**
 * 投稿の読了時間計算
 */
function pout_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $content = get_post_field('post_content', $post_id);
    $word_count = mb_strlen(strip_tags($content));
    $reading_time = ceil($word_count / 600); // 日本語は600文字/分
    return max(1, $reading_time);
}

/**
 * パンくずリスト生成
 */
function pout_breadcrumb() {
    if (is_front_page()) {
        return;
    }

    $sep = '<span class="breadcrumb-sep">/</span>';
    $home = '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('ホーム', 'pout-theme') . '</a>';

    echo '<nav class="breadcrumb" aria-label="パンくずリスト">';
    echo $home;

    if (is_home()) {
        echo $sep . '<span>' . esc_html__('ブログ', 'pout-theme') . '</span>';
    } elseif (is_category()) {
        echo $sep . '<span>' . esc_html(single_cat_title('', false)) . '</span>';
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            echo $sep . '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
        }
        echo $sep . '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_page()) {
        echo $sep . '<span>' . esc_html(get_the_title()) . '</span>';
    } elseif (is_post_type_archive('tools')) {
        echo $sep . '<span>' . esc_html__('ツール一覧', 'pout-theme') . '</span>';
    } elseif (is_singular('tools')) {
        echo $sep . '<a href="' . esc_url(get_post_type_archive_link('tools')) . '">' . esc_html__('ツール一覧', 'pout-theme') . '</a>';
        echo $sep . '<span>' . esc_html(get_the_title()) . '</span>';
    }

    echo '</nav>';
}

/**
 * SVGアイコン取得ヘルパー
 *
 * @param string $icon アイコン名
 * @return string SVGマークアップ
 */
if (!function_exists('pout_get_svg_icon')) {
    function pout_get_svg_icon($icon) {
        $icons = array(
            'file-text' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14,2 14,8 20,8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10,9 9,9 8,9"></polyline></svg>',
            'briefcase' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>',
            'edit-3' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>',
            'mail' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
            'upload' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17,8 12,3 7,8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>',
            'eye' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>',
            'check-circle' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22,4 12,14.01 9,11.01"></polyline></svg>',
            'arrow-right' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12,5 19,12 12,19"></polyline></svg>',
            'clock' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline></svg>',
            'user' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>',
            'folder' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>',
            'star' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26 12,2"></polygon></svg>',
            'check' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20,6 9,17 4,12"></polyline></svg>',
            'x' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>',
            'chevron-down' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6,9 12,15 18,9"></polyline></svg>',
        );

        /**
         * Filter SVG icons array
         * @param array $icons Available icons
         * @param string $icon Requested icon name
         */
        $icons = apply_filters('pout_svg_icons', $icons, $icon);

        return isset($icons[$icon]) ? $icons[$icon] : '';
    }
}
