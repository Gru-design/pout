<?php
/**
 * Archive Tools Template
 *
 * エコシステム（ツール）一覧ページ
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="tools-archive">
    <!-- ページヘッダー -->
    <header class="tools-header">
        <div class="container">
            <?php pout_breadcrumb(); ?>
            <h1 class="tools-title"><?php esc_html_e('エコシステム', 'pout-theme'); ?></h1>
            <p class="tools-description">
                <?php esc_html_e('私たちが提供するツール・サービス群をご紹介します', 'pout-theme'); ?>
            </p>
        </div>
    </header>

    <!-- ツール一覧 -->
    <section class="tools-content">
        <div class="container">
            <?php if (have_posts()) : ?>

            <!-- フィルター -->
            <div class="tools-filter">
                <button class="filter-btn active" data-filter="all">
                    <?php esc_html_e('すべて', 'pout-theme'); ?>
                </button>
                <?php
                $tool_categories = get_terms(array(
                    'taxonomy'   => 'tool_category',
                    'hide_empty' => true,
                ));
                if ($tool_categories && !is_wp_error($tool_categories)) :
                    foreach ($tool_categories as $category) :
                ?>
                <button class="filter-btn" data-filter="<?php echo esc_attr($category->slug); ?>">
                    <?php echo esc_html($category->name); ?>
                </button>
                <?php
                    endforeach;
                endif;
                ?>
            </div>

            <!-- ツールグリッド -->
            <div class="tools-grid">
                <?php while (have_posts()) : the_post();
                    $tool_url = get_post_meta(get_the_ID(), 'tool_url', true);
                    $tool_status = get_post_meta(get_the_ID(), 'tool_status', true);
                    $tool_categories = get_the_terms(get_the_ID(), 'tool_category');
                    $category_classes = '';
                    if ($tool_categories && !is_wp_error($tool_categories)) {
                        foreach ($tool_categories as $cat) {
                            $category_classes .= ' tool-category-' . $cat->slug;
                        }
                    }
                ?>
                <article id="tool-<?php the_ID(); ?>" class="tool-card<?php echo esc_attr($category_classes); ?>">
                    <div class="tool-card-inner">
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="tool-card-image">
                            <?php the_post_thumbnail('pout-card'); ?>
                            <?php if ($tool_status) : ?>
                            <span class="tool-status tool-status-<?php echo esc_attr($tool_status); ?>">
                                <?php
                                $status_labels = array(
                                    'active'      => __('公開中', 'pout-theme'),
                                    'beta'        => __('ベータ版', 'pout-theme'),
                                    'coming_soon' => __('Coming Soon', 'pout-theme'),
                                    'deprecated'  => __('終了予定', 'pout-theme'),
                                );
                                echo esc_html($status_labels[$tool_status] ?? $tool_status);
                                ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <div class="tool-card-content">
                            <?php if ($tool_categories && !is_wp_error($tool_categories)) : ?>
                            <div class="tool-categories">
                                <?php foreach ($tool_categories as $cat) : ?>
                                <span class="tool-category-tag"><?php echo esc_html($cat->name); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                            <h2 class="tool-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <p class="tool-card-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 60); ?>
                            </p>

                            <div class="tool-card-actions">
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm">
                                    <?php esc_html_e('詳しく見る', 'pout-theme'); ?>
                                </a>
                                <?php if ($tool_url && $tool_status !== 'coming_soon') : ?>
                                <a href="<?php echo esc_url($tool_url); ?>" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer">
                                    <?php esc_html_e('使ってみる', 'pout-theme'); ?>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"></path>
                                    </svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <!-- ページネーション -->
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

            <div class="no-tools">
                <p><?php esc_html_e('ツールが見つかりませんでした。', 'pout-theme'); ?></p>
            </div>

            <?php endif; ?>
        </div>
    </section>

    <!-- 連携・パートナーシップCTA -->
    <section class="tools-cta">
        <div class="container">
            <div class="tools-cta-box">
                <div class="tools-cta-content">
                    <h2 class="tools-cta-title"><?php esc_html_e('連携・パートナーシップのご相談', 'pout-theme'); ?></h2>
                    <p class="tools-cta-description">
                        <?php esc_html_e('API連携やビジネス提携についてお気軽にご相談ください。', 'pout-theme'); ?>
                    </p>
                </div>
                <div class="tools-cta-action">
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-lg">
                        <?php esc_html_e('お問い合わせ', 'pout-theme'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
