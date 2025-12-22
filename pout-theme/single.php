<?php
/**
 * Single Post Template
 *
 * 記事詳細ページ
 * Pout Consulting / MEDECHECK
 *
 * @package Pout_Theme
 * @version 2.0.0
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

<!-- 読み進め進捗バー -->
<div class="reading-progress-bar" id="reading-progress" aria-hidden="true">
    <div class="reading-progress-fill"></div>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-article'); ?> itemscope itemtype="https://schema.org/Article">
    <!-- 記事ヘッダー -->
    <header class="article-header">
        <div class="container container-narrow">
            <?php if (function_exists('pout_breadcrumb')) : ?>
                <?php pout_breadcrumb(); ?>
            <?php endif; ?>

            <div class="article-meta">
                <?php
                $categories = get_the_category();
                if (!empty($categories)) :
                ?>
                <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="article-category" itemprop="articleSection">
                    <?php echo esc_html($categories[0]->name); ?>
                </a>
                <?php endif; ?>
            </div>

            <h1 class="article-title" itemprop="headline"><?php the_title(); ?></h1>

            <div class="article-info">
                <div class="article-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                    <?php echo get_avatar(get_the_author_meta('ID'), 44, '', get_the_author(), array('class' => 'author-avatar-img')); ?>
                    <div class="author-info">
                        <span class="author-name" itemprop="name"><?php the_author(); ?></span>
                        <div class="article-dates">
                            <time class="article-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <?php echo esc_html(get_the_date()); ?>
                            </time>
                            <?php if (get_the_date() !== get_the_modified_date()) : ?>
                            <time class="updated-date" datetime="<?php echo esc_attr(get_the_modified_date('c')); ?>" itemprop="dateModified">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M23 4v6h-6"></path>
                                    <path d="M1 20v-6h6"></path>
                                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                </svg>
                                <?php echo esc_html(get_the_modified_date()); ?>
                            </time>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="article-stats">
                    <?php
                    $reading_time = function_exists('pout_reading_time') ? pout_reading_time() : '5';
                    ?>
                    <span class="reading-time">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12,6 12,12 16,14"></polyline>
                        </svg>
                        <?php echo esc_html($reading_time); ?><?php esc_html_e('分で読めます', 'pout-theme'); ?>
                    </span>
                    <?php
                    $views = get_post_meta(get_the_ID(), 'post_views_count', true);
                    if ($views) :
                    ?>
                    <span class="view-count">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <?php echo esc_html(number_format((int)$views)); ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (has_post_thumbnail()) : ?>
        <div class="article-featured-image">
            <div class="container">
                <?php the_post_thumbnail('pout-hero', array(
                    'class'    => 'featured-image',
                    'itemprop' => 'image',
                )); ?>
            </div>
        </div>
        <?php endif; ?>
    </header>

    <div class="article-body">
        <div class="container container-narrow">
            <div class="article-layout">
                <!-- 目次 -->
                <nav class="article-toc" id="article-toc" aria-label="<?php esc_attr_e('目次', 'pout-theme'); ?>">
                    <div class="toc-header">
                        <h2 class="toc-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <line x1="8" y1="6" x2="21" y2="6"></line>
                                <line x1="8" y1="12" x2="21" y2="12"></line>
                                <line x1="8" y1="18" x2="21" y2="18"></line>
                                <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                <line x1="3" y1="18" x2="3.01" y2="18"></line>
                            </svg>
                            <?php esc_html_e('目次', 'pout-theme'); ?>
                        </h2>
                        <button type="button" class="toc-toggle" aria-expanded="true" aria-label="<?php esc_attr_e('目次を開閉', 'pout-theme'); ?>">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M6 9l6 6 6-6"></path>
                            </svg>
                        </button>
                    </div>
                    <ol class="toc-list" id="toc-list"></ol>
                </nav>

                <!-- 記事コンテンツ -->
                <div class="article-content" id="article-content" itemprop="articleBody">
                    <?php the_content(); ?>
                </div>

                <!-- タグ -->
                <?php
                $tags = get_the_tags();
                if (!empty($tags)) :
                ?>
                <footer class="article-footer">
                    <div class="article-tags" itemprop="keywords">
                        <span class="tags-label">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                <line x1="7" y1="7" x2="7.01" y2="7"></line>
                            </svg>
                            <?php esc_html_e('タグ', 'pout-theme'); ?>
                        </span>
                        <div class="tags-list">
                            <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link" rel="tag">
                                <?php echo esc_html($tag->name); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </footer>
                <?php endif; ?>

                <!-- シェアボタン -->
                <div class="article-share">
                    <span class="share-label"><?php esc_html_e('この記事をシェア', 'pout-theme'); ?></span>
                    <div class="share-buttons-inline">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo esc_url(rawurlencode(get_permalink())); ?>&text=<?php echo esc_url(rawurlencode(get_the_title())); ?>" class="share-btn share-twitter" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('Xでシェア', 'pout-theme'); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            <span>X</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(rawurlencode(get_permalink())); ?>" class="share-btn share-facebook" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('Facebookでシェア', 'pout-theme'); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span>Facebook</span>
                        </a>
                        <a href="https://b.hatena.ne.jp/entry/<?php echo esc_url(rawurlencode(get_permalink())); ?>" class="share-btn share-hatena" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('はてなブックマークに追加', 'pout-theme'); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M20.47 21.71H3.53A1.53 1.53 0 012 20.18V3.82A1.53 1.53 0 013.53 2.29h16.94A1.53 1.53 0 0122 3.82v16.36a1.53 1.53 0 01-1.53 1.53zM8.46 17.08h2.71v-5.45h2.66c2.62 0 3.92-1.35 3.92-3.27 0-1.92-1.3-3.27-3.92-3.27H8.46v12zm2.71-10.12h2.17c1.1 0 1.66.49 1.66 1.38s-.56 1.38-1.66 1.38h-2.17zm6.13 8.04a1.53 1.53 0 110 3.06 1.53 1.53 0 010-3.06z"/>
                            </svg>
                            <span><?php esc_html_e('はてブ', 'pout-theme'); ?></span>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_url(rawurlencode(get_permalink())); ?>" class="share-btn share-linkedin" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('LinkedInでシェア', 'pout-theme'); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            <span>LinkedIn</span>
                        </a>
                        <button type="button" class="share-btn share-copy" data-url="<?php echo esc_url(get_permalink()); ?>" aria-label="<?php esc_attr_e('URLをコピー', 'pout-theme'); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                            <span><?php esc_html_e('コピー', 'pout-theme'); ?></span>
                        </button>
                    </div>
                </div>

                <!-- MEDECHECK プロモーション -->
                <div class="article-cta">
                    <div class="article-cta-inner">
                        <div class="article-cta-content">
                            <span class="cta-label"><?php esc_html_e('AIじゃない。目で、チェック。', 'pout-theme'); ?></span>
                            <h3 class="cta-title"><?php esc_html_e('書類選考でお悩みの方へ', 'pout-theme'); ?></h3>
                            <p class="cta-description"><?php esc_html_e('プロのキャリアアドバイザーが、あなたの履歴書・職務経歴書を徹底添削。書類通過率を上げるお手伝いをします。', 'pout-theme'); ?></p>
                            <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-gold">
                                <?php esc_html_e('MEDECHECKを詳しく見る', 'pout-theme'); ?>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="article-cta-visual" aria-hidden="true">
                            <div class="cta-visual-icon">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 著者情報 -->
    <section class="author-box" aria-labelledby="author-box-title">
        <div class="container container-narrow">
            <div class="author-box-inner">
                <div class="author-avatar">
                    <?php echo get_avatar(get_the_author_meta('ID'), 96, '', get_the_author(), array('class' => 'author-avatar-img')); ?>
                </div>
                <div class="author-details">
                    <span class="author-label" id="author-box-title"><?php esc_html_e('この記事を書いた人', 'pout-theme'); ?></span>
                    <h3 class="author-name"><?php the_author(); ?></h3>
                    <?php if (get_the_author_meta('description')) : ?>
                    <p class="author-bio"><?php echo esc_html(get_the_author_meta('description')); ?></p>
                    <?php endif; ?>
                    <div class="author-links">
                        <?php if (get_the_author_meta('user_url')) : ?>
                        <a href="<?php echo esc_url(get_the_author_meta('user_url')); ?>" class="author-link" target="_blank" rel="noopener noreferrer">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            </svg>
                            <?php esc_html_e('Webサイト', 'pout-theme'); ?>
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="author-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14,2 14,8 20,8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                            </svg>
                            <?php esc_html_e('この著者の記事一覧', 'pout-theme'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 関連記事 -->
    <?php
    $categories = get_the_category();
    $category_ids = array();
    if (!empty($categories)) {
        foreach ($categories as $category) {
            $category_ids[] = $category->term_id;
        }
    }

    $related_query = new WP_Query(array(
        'category__in'   => $category_ids,
        'post__not_in'   => array(get_the_ID()),
        'posts_per_page' => 4,
        'orderby'        => 'rand',
    ));

    if ($related_query->have_posts()) :
    ?>
    <section class="related-posts" aria-labelledby="related-posts-title">
        <div class="container">
            <header class="related-posts-header">
                <h2 class="section-title" id="related-posts-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                    </svg>
                    <?php esc_html_e('関連記事', 'pout-theme'); ?>
                </h2>
            </header>
            <div class="related-posts-grid">
                <?php
                while ($related_query->have_posts()) : $related_query->the_post();
                ?>
                <article class="related-post-card" itemscope itemtype="https://schema.org/Article">
                    <a href="<?php the_permalink(); ?>">
                        <div class="related-post-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('pout-card', array('itemprop' => 'image')); ?>
                            <?php else : ?>
                                <div class="related-image-placeholder">
                                    <span>Pout</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="related-post-content">
                            <?php
                            $rel_categories = get_the_category();
                            if (!empty($rel_categories)) :
                            ?>
                            <span class="related-post-category"><?php echo esc_html($rel_categories[0]->name); ?></span>
                            <?php endif; ?>
                            <h3 class="related-post-title" itemprop="headline"><?php the_title(); ?></h3>
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished"><?php echo esc_html(get_the_date()); ?></time>
                        </div>
                    </a>
                </article>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php
    wp_reset_postdata();
    endif;
    ?>

    <!-- 前後の記事ナビゲーション -->
    <?php
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    if ($prev_post || $next_post) :
    ?>
    <nav class="post-navigation" aria-label="<?php esc_attr_e('記事ナビゲーション', 'pout-theme'); ?>">
        <div class="container container-narrow">
            <div class="post-nav-links">
                <?php if ($prev_post) : ?>
                <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="post-nav-link post-nav-prev">
                    <span class="nav-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M19 12H5M12 19l-7-7 7-7"></path>
                        </svg>
                        <?php esc_html_e('前の記事', 'pout-theme'); ?>
                    </span>
                    <span class="nav-title"><?php echo esc_html(get_the_title($prev_post)); ?></span>
                </a>
                <?php else : ?>
                <span class="post-nav-link post-nav-placeholder"></span>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="post-nav-link post-nav-next">
                    <span class="nav-label">
                        <?php esc_html_e('次の記事', 'pout-theme'); ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </span>
                    <span class="nav-title"><?php echo esc_html(get_the_title($next_post)); ?></span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <!-- コメントセクション -->
    <?php if (comments_open() || get_comments_number()) : ?>
    <section class="comments-section" aria-labelledby="comments-title">
        <div class="container container-narrow">
            <?php comments_template(); ?>
        </div>
    </section>
    <?php endif; ?>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
