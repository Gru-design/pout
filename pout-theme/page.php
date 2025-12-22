<?php
/**
 * Page Template
 *
 * 固定ページのデフォルトテンプレート
 * Pout Consulting / MEDECHECK
 *
 * @package Pout_Theme
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<article id="page-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
    <!-- ページヘッダー -->
    <header class="page-header">
        <div class="container">
            <?php if (function_exists('pout_breadcrumb')) : ?>
                <?php pout_breadcrumb(); ?>
            <?php endif; ?>
            <h1 class="page-title"><?php the_title(); ?></h1>
        </div>
        <div class="page-header-bg" aria-hidden="true"></div>
    </header>

    <!-- ページコンテンツ -->
    <div class="page-body">
        <div class="container container-narrow">
            <?php while (have_posts()) : the_post(); ?>
                <div class="page-content-inner">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="page-featured-image">
                            <?php the_post_thumbnail('pout-hero', array('class' => 'featured-image')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="page-text">
                        <?php the_content(); ?>
                    </div>

                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('ページ:', 'pout-theme'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>
            <?php endwhile; ?>

            <?php if (comments_open() || get_comments_number()) : ?>
                <section class="page-comments">
                    <?php comments_template(); ?>
                </section>
            <?php endif; ?>
        </div>
    </div>
</article>

<?php get_footer(); ?>
