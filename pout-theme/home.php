<?php
/**
 * Home Template
 *
 * メディアTOP - ブログ一覧ページ
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="media-page">
    <!-- ページヘッダー -->
    <header class="media-header">
        <div class="container">
            <h1 class="media-title"><?php esc_html_e('ブログ', 'pout-theme'); ?></h1>
            <p class="media-description">
                <?php esc_html_e('最新のテクノロジートレンドやノウハウをお届けします', 'pout-theme'); ?>
            </p>
        </div>
    </header>

    <div class="media-content">
        <div class="container">
            <div class="media-layout">
                <!-- メインコンテンツ -->
                <div class="media-main">
                    <?php if (have_posts()) : ?>

                    <!-- 最新記事（大きく表示） -->
                    <?php if (!is_paged()) : ?>
                        <?php
                        $featured_query = new WP_Query(array(
                            'posts_per_page' => 1,
                            'meta_key'       => '_is_featured',
                            'meta_value'     => '1',
                        ));

                        if ($featured_query->have_posts()) :
                            while ($featured_query->have_posts()) : $featured_query->the_post();
                        ?>
                        <article class="featured-post">
                            <a href="<?php the_permalink(); ?>" class="featured-post-link">
                                <?php if (has_post_thumbnail()) : ?>
                                <div class="featured-post-image">
                                    <?php the_post_thumbnail('pout-hero'); ?>
                                    <span class="featured-badge"><?php esc_html_e('注目', 'pout-theme'); ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="featured-post-content">
                                    <div class="post-meta">
                                        <?php
                                        $categories = get_the_category();
                                        if ($categories) :
                                        ?>
                                        <span class="post-category"><?php echo esc_html($categories[0]->name); ?></span>
                                        <?php endif; ?>
                                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                                        <span class="reading-time">
                                            <?php echo esc_html(pout_reading_time()); ?><?php esc_html_e('分で読める', 'pout-theme'); ?>
                                        </span>
                                    </div>
                                    <h2 class="featured-post-title"><?php the_title(); ?></h2>
                                    <p class="featured-post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 80); ?></p>
                                </div>
                            </a>
                        </article>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    <?php endif; ?>

                    <!-- 記事一覧 -->
                    <div class="posts-grid">
                        <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                            <a href="<?php the_permalink(); ?>" class="post-card-link">
                                <?php if (has_post_thumbnail()) : ?>
                                <div class="post-card-image">
                                    <?php the_post_thumbnail('pout-card'); ?>
                                </div>
                                <?php else : ?>
                                <div class="post-card-image post-card-image-placeholder">
                                    <span><?php bloginfo('name'); ?></span>
                                </div>
                                <?php endif; ?>

                                <div class="post-card-content">
                                    <div class="post-meta">
                                        <?php
                                        $categories = get_the_category();
                                        if ($categories) :
                                        ?>
                                        <span class="post-category"><?php echo esc_html($categories[0]->name); ?></span>
                                        <?php endif; ?>
                                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                                    </div>
                                    <h2 class="post-card-title"><?php the_title(); ?></h2>
                                    <p class="post-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 40); ?></p>
                                    <div class="post-card-footer">
                                        <span class="reading-time">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12,6 12,12 16,14"></polyline>
                                            </svg>
                                            <?php echo esc_html(pout_reading_time()); ?><?php esc_html_e('分', 'pout-theme'); ?>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </article>
                        <?php endwhile; ?>
                    </div>

                    <!-- ページネーション -->
                    <nav class="pagination" aria-label="<?php esc_attr_e('ページナビゲーション', 'pout-theme'); ?>">
                        <?php
                        the_posts_pagination(array(
                            'mid_size'  => 2,
                            'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"></path></svg><span class="screen-reader-text">' . __('前へ', 'pout-theme') . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . __('次へ', 'pout-theme') . '</span><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"></path></svg>',
                        ));
                        ?>
                    </nav>

                    <?php else : ?>

                    <div class="no-posts">
                        <p><?php esc_html_e('記事が見つかりませんでした。', 'pout-theme'); ?></p>
                    </div>

                    <?php endif; ?>
                </div>

                <!-- サイドバー -->
                <aside class="media-sidebar">
                    <!-- 検索 -->
                    <div class="sidebar-widget widget-search">
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <label class="screen-reader-text"><?php esc_html_e('検索:', 'pout-theme'); ?></label>
                            <input type="search" class="search-field" placeholder="<?php esc_attr_e('記事を検索...', 'pout-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s">
                            <button type="submit" class="search-submit">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="M21 21l-4.35-4.35"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- カテゴリー -->
                    <div class="sidebar-widget widget-categories">
                        <h3 class="widget-title"><?php esc_html_e('カテゴリー', 'pout-theme'); ?></h3>
                        <ul class="category-list">
                            <?php
                            $categories = get_categories(array(
                                'orderby'    => 'count',
                                'order'      => 'DESC',
                                'hide_empty' => true,
                                'number'     => 10,
                            ));
                            foreach ($categories as $category) :
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <span class="category-count"><?php echo esc_html($category->count); ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- 人気記事 -->
                    <div class="sidebar-widget widget-popular">
                        <h3 class="widget-title"><?php esc_html_e('人気記事', 'pout-theme'); ?></h3>
                        <ul class="popular-posts">
                            <?php
                            $popular_query = new WP_Query(array(
                                'posts_per_page' => 5,
                                'meta_key'       => 'post_views_count',
                                'orderby'        => 'meta_value_num',
                                'order'          => 'DESC',
                            ));

                            if ($popular_query->have_posts()) :
                                $rank = 1;
                                while ($popular_query->have_posts()) : $popular_query->the_post();
                            ?>
                            <li class="popular-post">
                                <span class="popular-rank"><?php echo esc_html($rank); ?></span>
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                    <div class="popular-post-image">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class="popular-post-content">
                                        <span class="popular-post-title"><?php the_title(); ?></span>
                                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                                    </div>
                                </a>
                            </li>
                            <?php
                                $rank++;
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </ul>
                    </div>

                    <!-- タグクラウド -->
                    <div class="sidebar-widget widget-tags">
                        <h3 class="widget-title"><?php esc_html_e('タグ', 'pout-theme'); ?></h3>
                        <div class="tag-cloud">
                            <?php
                            wp_tag_cloud(array(
                                'smallest' => 12,
                                'largest'  => 12,
                                'unit'     => 'px',
                                'number'   => 20,
                                'format'   => 'flat',
                            ));
                            ?>
                        </div>
                    </div>

                    <?php if (is_active_sidebar('sidebar-1')) : ?>
                        <?php dynamic_sidebar('sidebar-1'); ?>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
