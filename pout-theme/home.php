<?php
/**
 * Home Template
 *
 * メディアTOP - キャリア・転職に関するブログ一覧ページ
 * Pout Consulting / MEDECHECK
 *
 * @package Pout_Theme
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// 現在のページ番号を取得
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$is_first_page = ($paged === 1);
?>

<div class="media-page">
    <!-- ページヘッダー -->
    <header class="media-header">
        <div class="container">
            <div class="media-header-content">
                <span class="media-header-label"><?php esc_html_e('Pout Media', 'pout-theme'); ?></span>
                <h1 class="media-title"><?php esc_html_e('キャリアのヒントが見つかるメディア', 'pout-theme'); ?></h1>
                <p class="media-description">
                    <?php esc_html_e('転職ノウハウ、履歴書・職務経歴書の書き方、面接対策など、キャリアアップに役立つ情報をお届けします。', 'pout-theme'); ?>
                </p>
            </div>
        </div>
        <div class="media-header-bg" aria-hidden="true"></div>
    </header>

    <div class="media-content">
        <div class="container">
            <div class="media-layout">
                <!-- メインコンテンツ -->
                <div class="media-main">
                    <?php if (have_posts()) : ?>

                    <!-- 注目記事（1ページ目のみ） -->
                    <?php if ($is_first_page) : ?>
                        <?php
                        $featured_query = new WP_Query(array(
                            'posts_per_page' => 1,
                            'meta_key'       => '_is_featured',
                            'meta_value'     => '1',
                        ));

                        if ($featured_query->have_posts()) :
                            while ($featured_query->have_posts()) : $featured_query->the_post();
                        ?>
                        <article class="featured-post" itemscope itemtype="https://schema.org/Article">
                            <a href="<?php the_permalink(); ?>" class="featured-post-link">
                                <div class="featured-post-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('pout-hero', array('itemprop' => 'image')); ?>
                                    <?php else : ?>
                                        <div class="featured-image-placeholder">
                                            <span>Pout Media</span>
                                        </div>
                                    <?php endif; ?>
                                    <span class="featured-badge">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon>
                                        </svg>
                                        <?php esc_html_e('注目記事', 'pout-theme'); ?>
                                    </span>
                                </div>
                                <div class="featured-post-content">
                                    <div class="post-meta">
                                        <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)) :
                                        ?>
                                        <span class="post-category" itemprop="articleSection"><?php echo esc_html($categories[0]->name); ?></span>
                                        <?php endif; ?>
                                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished"><?php echo esc_html(get_the_date()); ?></time>
                                        <?php
                                        $reading_time = pout_reading_time();
                                        if ($reading_time) :
                                        ?>
                                        <span class="reading-time">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12,6 12,12 16,14"></polyline>
                                            </svg>
                                            <?php echo esc_html($reading_time); ?><?php esc_html_e('分で読める', 'pout-theme'); ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <h2 class="featured-post-title" itemprop="headline"><?php the_title(); ?></h2>
                                    <p class="featured-post-excerpt" itemprop="description"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 100)); ?></p>
                                    <span class="featured-post-readmore">
                                        <?php esc_html_e('続きを読む', 'pout-theme'); ?>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        </article>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    <?php endif; ?>

                    <!-- 記事一覧ヘッダー -->
                    <div class="posts-section-header">
                        <h2 class="posts-section-title">
                            <?php if ($is_first_page) : ?>
                                <?php esc_html_e('最新記事', 'pout-theme'); ?>
                            <?php else : ?>
                                <?php printf(esc_html__('記事一覧 - %dページ目', 'pout-theme'), $paged); ?>
                            <?php endif; ?>
                        </h2>
                        <div class="posts-view-toggle" role="tablist" aria-label="<?php esc_attr_e('表示切り替え', 'pout-theme'); ?>">
                            <button type="button" class="view-toggle-btn active" data-view="grid" role="tab" aria-selected="true" aria-label="<?php esc_attr_e('グリッド表示', 'pout-theme'); ?>">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </button>
                            <button type="button" class="view-toggle-btn" data-view="list" role="tab" aria-selected="false" aria-label="<?php esc_attr_e('リスト表示', 'pout-theme'); ?>">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- 記事一覧 -->
                    <div class="posts-grid" id="posts-container">
                        <?php
                        $post_count = 0;
                        while (have_posts()) : the_post();
                            $post_count++;
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?> itemscope itemtype="https://schema.org/Article">
                            <a href="<?php the_permalink(); ?>" class="post-card-link">
                                <div class="post-card-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('pout-card', array('itemprop' => 'image')); ?>
                                    <?php else : ?>
                                        <div class="post-card-image-placeholder">
                                            <span>Pout</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="post-card-content">
                                    <div class="post-meta">
                                        <?php
                                        $categories = get_the_category();
                                        if (!empty($categories)) :
                                        ?>
                                        <span class="post-category" itemprop="articleSection"><?php echo esc_html($categories[0]->name); ?></span>
                                        <?php endif; ?>
                                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished"><?php echo esc_html(get_the_date()); ?></time>
                                    </div>
                                    <h3 class="post-card-title" itemprop="headline"><?php the_title(); ?></h3>
                                    <p class="post-card-excerpt" itemprop="description"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 50)); ?></p>
                                    <div class="post-card-footer">
                                        <?php
                                        $reading_time = pout_reading_time();
                                        if ($reading_time) :
                                        ?>
                                        <span class="reading-time">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12,6 12,12 16,14"></polyline>
                                            </svg>
                                            <?php echo esc_html($reading_time); ?><?php esc_html_e('分', 'pout-theme'); ?>
                                        </span>
                                        <?php endif; ?>
                                        <span class="post-card-arrow" aria-hidden="true">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </article>
                        <?php
                        // 3記事ごとにMEDECHECKプロモーションを挿入（1ページ目のみ）
                        if ($is_first_page && $post_count === 3) :
                        ?>
                        <div class="posts-inline-promo">
                            <div class="inline-promo-content">
                                <span class="inline-promo-label"><?php esc_html_e('MEDECHECK', 'pout-theme'); ?></span>
                                <p class="inline-promo-text"><?php esc_html_e('書類選考で悩んでいませんか？プロの目であなたの履歴書・職務経歴書をチェックします。', 'pout-theme'); ?></p>
                                <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-gold btn-sm">
                                    <?php esc_html_e('詳しく見る', 'pout-theme'); ?>
                                </a>
                            </div>
                        </div>
                        <?php
                        endif;
                        endwhile;
                        ?>
                    </div>

                    <!-- ページネーション -->
                    <nav class="pagination" aria-label="<?php esc_attr_e('ページナビゲーション', 'pout-theme'); ?>">
                        <?php
                        the_posts_pagination(array(
                            'mid_size'  => 2,
                            'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 18l-6-6 6-6"></path></svg><span class="screen-reader-text">' . esc_html__('前へ', 'pout-theme') . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . esc_html__('次へ', 'pout-theme') . '</span><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 18l6-6-6-6"></path></svg>',
                        ));
                        ?>
                    </nav>

                    <?php else : ?>

                    <!-- 記事がない場合 -->
                    <div class="no-posts">
                        <div class="no-posts-icon" aria-hidden="true">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14,2 14,8 20,8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10,9 9,9 8,9"></polyline>
                            </svg>
                        </div>
                        <h2 class="no-posts-title"><?php esc_html_e('記事が見つかりませんでした', 'pout-theme'); ?></h2>
                        <p class="no-posts-description"><?php esc_html_e('お探しの記事は見つかりませんでした。別のキーワードで検索するか、カテゴリーから記事をお探しください。', 'pout-theme'); ?></p>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                            <?php esc_html_e('トップページへ戻る', 'pout-theme'); ?>
                        </a>
                    </div>

                    <?php endif; ?>
                </div>

                <!-- サイドバー -->
                <aside class="media-sidebar" role="complementary" aria-label="<?php esc_attr_e('サイドバー', 'pout-theme'); ?>">
                    <!-- 検索 -->
                    <div class="sidebar-widget widget-search">
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <label class="screen-reader-text" for="sidebar-search"><?php esc_html_e('検索:', 'pout-theme'); ?></label>
                            <input type="search" id="sidebar-search" class="search-field" placeholder="<?php esc_attr_e('記事を検索...', 'pout-theme'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
                            <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('検索', 'pout-theme'); ?>">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="M21 21l-4.35-4.35"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- MEDECHECKプロモーション -->
                    <div class="sidebar-widget widget-promo">
                        <div class="sidebar-promo-card">
                            <span class="promo-eyebrow"><?php esc_html_e('AIじゃない。目で、チェック。', 'pout-theme'); ?></span>
                            <h3 class="promo-title"><?php esc_html_e('MEDECHECK', 'pout-theme'); ?></h3>
                            <p class="promo-description"><?php esc_html_e('プロの目で書類添削。履歴書・職務経歴書・ESを徹底チェック。', 'pout-theme'); ?></p>
                            <ul class="promo-features">
                                <li>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                                    <?php esc_html_e('24時間以内納品', 'pout-theme'); ?>
                                </li>
                                <li>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                                    <?php esc_html_e('初回50%OFF', 'pout-theme'); ?>
                                </li>
                            </ul>
                            <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-gold btn-block btn-sm">
                                <?php esc_html_e('詳しく見る', 'pout-theme'); ?>
                            </a>
                        </div>
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

                            if (!empty($categories)) :
                                foreach ($categories as $category) :
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                    <span class="category-name"><?php echo esc_html($category->name); ?></span>
                                    <span class="category-count"><?php echo esc_html($category->count); ?></span>
                                </a>
                            </li>
                            <?php
                                endforeach;
                            else :
                            ?>
                            <li class="no-categories"><?php esc_html_e('カテゴリーがありません', 'pout-theme'); ?></li>
                            <?php endif; ?>
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
                                <span class="popular-rank" aria-label="<?php echo esc_attr(sprintf(__('%d位', 'pout-theme'), $rank)); ?>"><?php echo esc_html($rank); ?></span>
                                <a href="<?php the_permalink(); ?>">
                                    <div class="popular-post-image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        <?php else : ?>
                                            <div class="popular-image-placeholder">
                                                <span>P</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="popular-post-content">
                                        <span class="popular-post-title"><?php the_title(); ?></span>
                                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                                    </div>
                                </a>
                            </li>
                            <?php
                                $rank++;
                                endwhile;
                                wp_reset_postdata();
                            else :
                            ?>
                            <li class="no-popular-posts"><?php esc_html_e('まだ人気記事がありません', 'pout-theme'); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- タグクラウド -->
                    <div class="sidebar-widget widget-tags">
                        <h3 class="widget-title"><?php esc_html_e('タグ', 'pout-theme'); ?></h3>
                        <div class="tag-cloud">
                            <?php
                            $tags = get_tags(array(
                                'orderby' => 'count',
                                'order'   => 'DESC',
                                'number'  => 20,
                            ));

                            if (!empty($tags)) :
                                foreach ($tags as $tag) :
                            ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">
                                <?php echo esc_html($tag->name); ?>
                            </a>
                            <?php
                                endforeach;
                            else :
                            ?>
                            <p class="no-tags"><?php esc_html_e('タグがありません', 'pout-theme'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- ニュースレター登録 -->
                    <div class="sidebar-widget widget-newsletter">
                        <div class="newsletter-card">
                            <h3 class="newsletter-title"><?php esc_html_e('キャリア情報をお届け', 'pout-theme'); ?></h3>
                            <p class="newsletter-description"><?php esc_html_e('最新の転職ノウハウやキャリアアップのコツをメールでお届けします。', 'pout-theme'); ?></p>
                            <form class="newsletter-form" action="#" method="post">
                                <label class="screen-reader-text" for="newsletter-email"><?php esc_html_e('メールアドレス', 'pout-theme'); ?></label>
                                <input type="email" id="newsletter-email" name="email" placeholder="<?php esc_attr_e('メールアドレス', 'pout-theme'); ?>" required>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <?php esc_html_e('登録する', 'pout-theme'); ?>
                                </button>
                            </form>
                            <p class="newsletter-note"><?php esc_html_e('※ 週1回配信・いつでも解除可能', 'pout-theme'); ?></p>
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
