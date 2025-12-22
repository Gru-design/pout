<?php
/**
 * Header Template
 *
 * サイトヘッダー、ナビゲーション、モバイルメニュー
 * Pout Consulting / MEDECHECK
 *
 * @package Pout_Theme
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// ページタイプ判定
$is_front_page = is_front_page();
$is_lp_page = is_page_template('page-medecheck.php') || is_page_template('page-resumake.php');
$header_class = ($is_front_page || $is_lp_page) ? 'header-transparent' : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#0F172A">

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-theme="light">
<?php wp_body_open(); ?>

<!-- Skip Link -->
<a class="skip-link screen-reader-text" href="#main-content">
    <?php esc_html_e('コンテンツへスキップ', 'pout-theme'); ?>
</a>

<!-- Site Header -->
<header class="site-header <?php echo esc_attr($header_class); ?>" role="banner">
    <div class="container">
        <div class="header-inner">

            <!-- Site Branding -->
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title" rel="home">
                        Pout
                    </a>
                <?php endif; ?>
            </div>

            <!-- Main Navigation -->
            <nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('メインメニュー', 'pout-theme'); ?>">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'primary-menu',
                        'container'      => false,
                        'depth'          => 2,
                    ));
                } else {
                    // フォールバックメニュー
                    ?>
                    <ul class="primary-menu">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('ホーム', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('私たちについて', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/medecheck/')); ?>">MEDECHECK</a></li>
                        <li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('メディア', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('お問い合わせ', 'pout-theme'); ?></a></li>
                    </ul>
                    <?php
                }
                ?>
            </nav>

            <!-- Header Actions -->
            <div class="header-actions">
                <!-- Dark Mode Toggle -->
                <button class="dark-mode-toggle" type="button" aria-label="<?php esc_attr_e('ダークモード切替', 'pout-theme'); ?>" aria-pressed="false">
                    <span class="dark-mode-toggle-icon sun" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                    </span>
                    <span class="dark-mode-toggle-icon moon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </span>
                </button>

                <!-- Search Toggle -->
                <button class="search-toggle" type="button" aria-label="<?php esc_attr_e('検索を開く', 'pout-theme'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>

                <!-- CTA Button (Desktop) -->
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-header">
                    <?php esc_html_e('お問い合わせ', 'pout-theme'); ?>
                </a>

                <!-- Mobile Menu Toggle -->
                <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu" aria-label="<?php esc_attr_e('メニューを開く', 'pout-theme'); ?>">
                    <span class="hamburger" aria-hidden="true">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

        </div>
    </div>
</header>

<!-- Mobile Menu -->
<nav id="mobile-menu" class="mobile-menu" aria-hidden="true" aria-label="<?php esc_attr_e('モバイルメニュー', 'pout-theme'); ?>">
    <div class="mobile-menu-inner">
        <?php
        if (has_nav_menu('mobile')) {
            wp_nav_menu(array(
                'theme_location' => 'mobile',
                'menu_class'     => 'mobile-menu-list',
                'container'      => false,
            ));
        } else {
            ?>
            <ul class="mobile-menu-list">
                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('ホーム', 'pout-theme'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('私たちについて', 'pout-theme'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/medecheck/')); ?>">MEDECHECK</a></li>
                <li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('メディア', 'pout-theme'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('お問い合わせ', 'pout-theme'); ?></a></li>
            </ul>
            <?php
        }
        ?>
        <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-primary btn-lg btn-mobile-cta">
            <?php esc_html_e('MEDECHECKを試す', 'pout-theme'); ?>
        </a>
    </div>
</nav>

<!-- Search Overlay -->
<div class="search-overlay" aria-hidden="true">
    <button class="search-close" type="button" aria-label="<?php esc_attr_e('検索を閉じる', 'pout-theme'); ?>">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
    <div class="search-overlay-inner">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <label class="screen-reader-text" for="overlay-search-field"><?php esc_html_e('検索:', 'pout-theme'); ?></label>
            <input type="search" id="overlay-search-field" class="search-field" placeholder="<?php esc_attr_e('記事を検索...', 'pout-theme'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
            <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('検索', 'pout-theme'); ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </form>
    </div>
</div>

<!-- Main Content Start -->
<main id="main-content" class="site-main" role="main">
