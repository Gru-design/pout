<?php
/**
 * Header Template
 *
 * 条件分岐ヘッダー - ページタイプに応じたヘッダー表示
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$page_type = pout_get_page_type();
$header_class = 'site-header site-header--' . $page_type;
$is_transparent = in_array($page_type, array('corporate', 'service'), true);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
    <?php esc_html_e('コンテンツへスキップ', 'pout-theme'); ?>
</a>

<header class="<?php echo esc_attr($header_class); ?><?php echo $is_transparent ? ' header-transparent' : ''; ?>" role="banner">
    <div class="header-inner container">
        <!-- ロゴ -->
        <div class="site-branding">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- ナビゲーション -->
        <nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('メインメニュー', 'pout-theme'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
                'container'      => false,
                'fallback_cb'    => false,
                'depth'          => 2,
            ));
            ?>
        </nav>

        <!-- ヘッダーアクション -->
        <div class="header-actions">
            <?php if ($page_type === 'corporate' || $page_type === 'service') : ?>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-header">
                    <?php esc_html_e('お問い合わせ', 'pout-theme'); ?>
                </a>
            <?php elseif ($page_type === 'media' || $page_type === 'article') : ?>
                <button class="search-toggle" aria-label="<?php esc_attr_e('検索', 'pout-theme'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.35-4.35"></path>
                    </svg>
                </button>
            <?php endif; ?>

            <!-- モバイルメニュートグル -->
            <button class="menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
                <span class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <span class="screen-reader-text"><?php esc_html_e('メニュー', 'pout-theme'); ?></span>
            </button>
        </div>
    </div>

    <!-- モバイルメニュー -->
    <div id="mobile-menu" class="mobile-menu" aria-hidden="true">
        <div class="mobile-menu-inner">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'mobile',
                'menu_class'     => 'mobile-menu-list',
                'container'      => false,
                'fallback_cb'    => '__return_false',
            ));
            ?>
            <?php if ($page_type === 'corporate' || $page_type === 'service') : ?>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-mobile-cta">
                    <?php esc_html_e('お問い合わせ', 'pout-theme'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- 検索オーバーレイ -->
    <div class="search-overlay" aria-hidden="true">
        <div class="search-overlay-inner">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <label class="screen-reader-text"><?php esc_html_e('検索:', 'pout-theme'); ?></label>
                <input type="search" class="search-field" placeholder="<?php esc_attr_e('キーワードを入力...', 'pout-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s">
                <button type="submit" class="search-submit">
                    <span class="screen-reader-text"><?php esc_html_e('検索', 'pout-theme'); ?></span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.35-4.35"></path>
                    </svg>
                </button>
            </form>
            <button class="search-close" aria-label="<?php esc_attr_e('閉じる', 'pout-theme'); ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</header>

<main id="main-content" class="site-main" role="main">
