<?php
/**
 * Single Post Template
 *
 * 記事詳細ページ
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// PV カウント
if (function_exists('pout_count_post_views')) {
    pout_count_post_views(get_the_ID());
}
?>

<?php while (have_posts()) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-article'); ?>>
    <!-- 記事ヘッダー -->
    <header class="article-header">
        <div class="container container-narrow">
            <?php pout_breadcrumb(); ?>

            <div class="article-meta">
                <?php
                $categories = get_the_category();
                if ($categories) :
                ?>
                <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="article-category">
                    <?php echo esc_html($categories[0]->name); ?>
                </a>
                <?php endif; ?>
            </div>

            <h1 class="article-title"><?php the_title(); ?></h1>

            <div class="article-info">
                <div class="article-author">
                    <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                    <div class="author-info">
                        <span class="author-name"><?php the_author(); ?></span>
                        <time class="article-date" datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                            <?php if (get_the_date() !== get_the_modified_date()) : ?>
                                <span class="updated-date">
                                    (<?php esc_html_e('更新:', 'pout-theme'); ?> <?php echo get_the_modified_date(); ?>)
                                </span>
                            <?php endif; ?>
                        </time>
                    </div>
                </div>
                <div class="article-stats">
                    <span class="reading-time">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12,6 12,12 16,14"></polyline>
                        </svg>
                        <?php echo esc_html(pout_reading_time()); ?><?php esc_html_e('分で読めます', 'pout-theme'); ?>
                    </span>
                </div>
            </div>
        </div>

        <?php if (has_post_thumbnail()) : ?>
        <div class="article-featured-image">
            <div class="container">
                <?php the_post_thumbnail('pout-hero', array('class' => 'featured-image')); ?>
            </div>
        </div>
        <?php endif; ?>
    </header>

    <div class="article-body">
        <div class="container container-narrow">
            <div class="article-layout">
                <!-- 目次（JS で自動生成） -->
                <nav class="article-toc" id="article-toc" aria-label="<?php esc_attr_e('目次', 'pout-theme'); ?>">
                    <div class="toc-header">
                        <h2 class="toc-title"><?php esc_html_e('目次', 'pout-theme'); ?></h2>
                        <button class="toc-toggle" aria-expanded="true">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 9l6 6 6-6"></path>
                            </svg>
                        </button>
                    </div>
                    <ol class="toc-list" id="toc-list"></ol>
                </nav>

                <!-- 記事コンテンツ -->
                <div class="article-content" id="article-content">
                    <?php the_content(); ?>
                </div>

                <!-- タグ -->
                <?php
                $tags = get_the_tags();
                if ($tags) :
                ?>
                <footer class="article-footer">
                    <div class="article-tags">
                        <span class="tags-label"><?php esc_html_e('タグ:', 'pout-theme'); ?></span>
                        <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">
                            #<?php echo esc_html($tag->name); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </footer>
                <?php endif; ?>

                <!-- シェアボタン -->
                <div class="article-share">
                    <span class="share-label"><?php esc_html_e('この記事をシェア', 'pout-theme'); ?></span>
                    <div class="share-buttons-inline">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" class="share-btn share-twitter" target="_blank" rel="noopener noreferrer">
                            <span>X (Twitter)</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" class="share-btn share-facebook" target="_blank" rel="noopener noreferrer">
                            <span>Facebook</span>
                        </a>
                        <a href="https://b.hatena.ne.jp/entry/<?php echo urlencode(get_permalink()); ?>" class="share-btn share-hatena" target="_blank" rel="noopener noreferrer">
                            <span>はてブ</span>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" class="share-btn share-linkedin" target="_blank" rel="noopener noreferrer">
                            <span>LinkedIn</span>
                        </a>
                        <button class="share-btn share-copy" data-url="<?php echo esc_url(get_permalink()); ?>">
                            <span><?php esc_html_e('URLをコピー', 'pout-theme'); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 著者情報 -->
    <section class="author-box">
        <div class="container container-narrow">
            <div class="author-box-inner">
                <div class="author-avatar">
                    <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                </div>
                <div class="author-details">
                    <span class="author-label"><?php esc_html_e('この記事を書いた人', 'pout-theme'); ?></span>
                    <h3 class="author-name"><?php the_author(); ?></h3>
                    <?php if (get_the_author_meta('description')) : ?>
                    <p class="author-bio"><?php echo esc_html(get_the_author_meta('description')); ?></p>
                    <?php endif; ?>
                    <div class="author-links">
                        <?php if (get_the_author_meta('user_url')) : ?>
                        <a href="<?php echo esc_url(get_the_author_meta('user_url')); ?>" target="_blank" rel="noopener noreferrer">
                            <?php esc_html_e('Webサイト', 'pout-theme'); ?>
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                            <?php esc_html_e('この著者の記事一覧', 'pout-theme'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 関連記事 -->
    <section class="related-posts">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e('関連記事', 'pout-theme'); ?></h2>
            <div class="related-posts-grid">
                <?php
                $categories = get_the_category();
                $category_ids = array();
                foreach ($categories as $category) {
                    $category_ids[] = $category->term_id;
                }

                $related_query = new WP_Query(array(
                    'category__in'   => $category_ids,
                    'post__not_in'   => array(get_the_ID()),
                    'posts_per_page' => 4,
                    'orderby'        => 'rand',
                ));

                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                ?>
                <article class="related-post-card">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="related-post-image">
                            <?php the_post_thumbnail('pout-card'); ?>
                        </div>
                        <?php endif; ?>
                        <div class="related-post-content">
                            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                            <h3 class="related-post-title"><?php the_title(); ?></h3>
                        </div>
                    </a>
                </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                <p class="no-related"><?php esc_html_e('関連記事はありません', 'pout-theme'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 前後の記事ナビゲーション -->
    <nav class="post-navigation" aria-label="<?php esc_attr_e('記事ナビゲーション', 'pout-theme'); ?>">
        <div class="container container-narrow">
            <div class="post-nav-links">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>
                <?php if ($prev_post) : ?>
                <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="post-nav-link post-nav-prev">
                    <span class="nav-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7"></path>
                        </svg>
                        <?php esc_html_e('前の記事', 'pout-theme'); ?>
                    </span>
                    <span class="nav-title"><?php echo esc_html(get_the_title($prev_post)); ?></span>
                </a>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="post-nav-link post-nav-next">
                    <span class="nav-label">
                        <?php esc_html_e('次の記事', 'pout-theme'); ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </span>
                    <span class="nav-title"><?php echo esc_html(get_the_title($next_post)); ?></span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- コメントセクション -->
    <?php if (comments_open() || get_comments_number()) : ?>
    <section class="comments-section">
        <div class="container container-narrow">
            <?php comments_template(); ?>
        </div>
    </section>
    <?php endif; ?>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
