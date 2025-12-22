<?php
/**
 * Index Template
 *
 * フォールバックテンプレート - 他のテンプレートが見つからない場合に使用
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="archive-page">
    <header class="archive-header">
        <div class="container">
            <?php pout_breadcrumb(); ?>
            <h1 class="archive-title">
                <?php
                if (is_search()) {
                    printf(__('「%s」の検索結果', 'pout-theme'), get_search_query());
                } elseif (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title();
                } elseif (is_author()) {
                    the_author();
                } elseif (is_day()) {
                    echo get_the_date();
                } elseif (is_month()) {
                    echo get_the_date('Y年n月');
                } elseif (is_year()) {
                    echo get_the_date('Y年');
                } elseif (is_archive()) {
                    the_archive_title();
                } else {
                    esc_html_e('記事一覧', 'pout-theme');
                }
                ?>
            </h1>
            <?php
            $description = '';
            if (is_category() || is_tag() || is_tax()) {
                $description = term_description();
            } elseif (is_author()) {
                $description = get_the_author_meta('description');
            }
            if ($description) :
            ?>
            <p class="archive-description"><?php echo wp_kses_post($description); ?></p>
            <?php endif; ?>
        </div>
    </header>

    <div class="archive-content">
        <div class="container">
            <div class="archive-layout">
                <div class="archive-main">
                    <?php if (have_posts()) : ?>
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
                                </div>
                            </a>
                        </article>
                        <?php endwhile; ?>
                    </div>

                    <nav class="pagination" aria-label="<?php esc_attr_e('ページナビゲーション', 'pout-theme'); ?>">
                        <?php
                        the_posts_pagination(array(
                            'mid_size'  => 2,
                            'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"></path></svg>',
                            'next_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"></path></svg>',
                        ));
                        ?>
                    </nav>

                    <?php else : ?>

                    <div class="no-posts">
                        <h2><?php esc_html_e('記事が見つかりませんでした', 'pout-theme'); ?></h2>
                        <p><?php esc_html_e('お探しの記事は見つかりませんでした。別のキーワードで検索してみてください。', 'pout-theme'); ?></p>
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" class="search-field" placeholder="<?php esc_attr_e('キーワードを入力...', 'pout-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s">
                            <button type="submit" class="btn btn-primary"><?php esc_html_e('検索', 'pout-theme'); ?></button>
                        </form>
                    </div>

                    <?php endif; ?>
                </div>

                <aside class="archive-sidebar">
                    <?php if (is_active_sidebar('sidebar-1')) : ?>
                        <?php dynamic_sidebar('sidebar-1'); ?>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
