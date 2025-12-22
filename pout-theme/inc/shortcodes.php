<?php
/**
 * Shortcodes
 *
 * 収益化パーツ・ショートコード
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ボタンショートコード
 *
 * [pout_button url="https://example.com" text="詳しく見る" style="primary" size="lg" target="_blank"]
 */
function pout_button_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url'     => '#',
        'text'    => __('詳しく見る', 'pout-theme'),
        'style'   => 'primary', // primary, outline, ghost
        'size'    => 'md',      // sm, md, lg, xl
        'target'  => '_self',
        'rel'     => '',
        'class'   => '',
        'id'      => '',
    ), $atts, 'pout_button');

    $classes = array('btn', 'btn-' . $atts['style']);
    if ($atts['size'] !== 'md') {
        $classes[] = 'btn-' . $atts['size'];
    }
    if ($atts['class']) {
        $classes[] = $atts['class'];
    }

    $rel = $atts['rel'];
    if ($atts['target'] === '_blank' && strpos($rel, 'noopener') === false) {
        $rel .= ' noopener noreferrer';
    }

    $id_attr = $atts['id'] ? ' id="' . esc_attr($atts['id']) . '"' : '';
    $rel_attr = $rel ? ' rel="' . esc_attr(trim($rel)) . '"' : '';

    return sprintf(
        '<a href="%s" class="%s" target="%s"%s%s>%s</a>',
        esc_url($atts['url']),
        esc_attr(implode(' ', $classes)),
        esc_attr($atts['target']),
        $rel_attr,
        $id_attr,
        esc_html($atts['text'])
    );
}
add_shortcode('pout_button', 'pout_button_shortcode');

/**
 * CTAボックスショートコード
 *
 * [pout_cta title="タイトル" description="説明" button_text="ボタン" button_url="URL" style="default"]
 */
function pout_cta_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title'       => '',
        'description' => '',
        'button_text' => __('詳しく見る', 'pout-theme'),
        'button_url'  => '#',
        'style'       => 'default', // default, highlight, minimal
        'image'       => '',
    ), $atts, 'pout_cta');

    ob_start();
    ?>
    <div class="shortcode-cta shortcode-cta-<?php echo esc_attr($atts['style']); ?>">
        <?php if ($atts['image']) : ?>
        <div class="shortcode-cta-image">
            <img src="<?php echo esc_url($atts['image']); ?>" alt="">
        </div>
        <?php endif; ?>
        <div class="shortcode-cta-content">
            <?php if ($atts['title']) : ?>
            <h3 class="shortcode-cta-title"><?php echo esc_html($atts['title']); ?></h3>
            <?php endif; ?>
            <?php if ($atts['description']) : ?>
            <p class="shortcode-cta-description"><?php echo esc_html($atts['description']); ?></p>
            <?php endif; ?>
            <a href="<?php echo esc_url($atts['button_url']); ?>" class="btn btn-primary">
                <?php echo esc_html($atts['button_text']); ?>
            </a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('pout_cta', 'pout_cta_shortcode');

/**
 * アフィリエイトボックスショートコード
 *
 * [pout_affiliate name="商品名" image="画像URL" price="価格" rating="5" url="アフィリエイトURL"]
 */
function pout_affiliate_shortcode($atts) {
    $atts = shortcode_atts(array(
        'name'        => '',
        'image'       => '',
        'price'       => '',
        'rating'      => '',
        'url'         => '#',
        'button_text' => __('詳細を見る', 'pout-theme'),
        'badge'       => '',
    ), $atts, 'pout_affiliate');

    ob_start();
    ?>
    <div class="affiliate-box">
        <?php if ($atts['badge']) : ?>
        <span class="affiliate-badge"><?php echo esc_html($atts['badge']); ?></span>
        <?php endif; ?>

        <?php if ($atts['image']) : ?>
        <div class="affiliate-image">
            <img src="<?php echo esc_url($atts['image']); ?>" alt="<?php echo esc_attr($atts['name']); ?>">
        </div>
        <?php endif; ?>

        <div class="affiliate-content">
            <?php if ($atts['name']) : ?>
            <h4 class="affiliate-name"><?php echo esc_html($atts['name']); ?></h4>
            <?php endif; ?>

            <?php if ($atts['rating']) : ?>
            <div class="affiliate-rating">
                <?php
                $rating = floatval($atts['rating']);
                for ($i = 1; $i <= 5; $i++) :
                    if ($i <= $rating) :
                        echo '<span class="star star-filled">★</span>';
                    elseif ($i - 0.5 <= $rating) :
                        echo '<span class="star star-half">★</span>';
                    else :
                        echo '<span class="star">☆</span>';
                    endif;
                endfor;
                ?>
                <span class="rating-value"><?php echo esc_html($atts['rating']); ?></span>
            </div>
            <?php endif; ?>

            <?php if ($atts['price']) : ?>
            <div class="affiliate-price"><?php echo esc_html($atts['price']); ?></div>
            <?php endif; ?>

            <a href="<?php echo esc_url($atts['url']); ?>" class="btn btn-primary btn-block" target="_blank" rel="noopener noreferrer sponsored">
                <?php echo esc_html($atts['button_text']); ?>
            </a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('pout_affiliate', 'pout_affiliate_shortcode');

/**
 * 比較表ショートコード
 *
 * [pout_comparison]
 * [pout_comparison_item name="商品A" price="1000円" rating="4.5" features="機能1,機能2" url="URL"]
 * [/pout_comparison]
 */
function pout_comparison_shortcode($atts, $content = null) {
    return '<div class="comparison-table">' . do_shortcode($content) . '</div>';
}
add_shortcode('pout_comparison', 'pout_comparison_shortcode');

function pout_comparison_item_shortcode($atts) {
    $atts = shortcode_atts(array(
        'name'     => '',
        'image'    => '',
        'price'    => '',
        'rating'   => '',
        'features' => '',
        'url'      => '#',
        'featured' => 'false',
    ), $atts, 'pout_comparison_item');

    $featured_class = $atts['featured'] === 'true' ? ' comparison-item-featured' : '';
    $features = array_filter(array_map('trim', explode(',', $atts['features'])));

    ob_start();
    ?>
    <div class="comparison-item<?php echo esc_attr($featured_class); ?>">
        <?php if ($atts['featured'] === 'true') : ?>
        <span class="comparison-badge"><?php esc_html_e('おすすめ', 'pout-theme'); ?></span>
        <?php endif; ?>

        <?php if ($atts['image']) : ?>
        <div class="comparison-image">
            <img src="<?php echo esc_url($atts['image']); ?>" alt="<?php echo esc_attr($atts['name']); ?>">
        </div>
        <?php endif; ?>

        <h4 class="comparison-name"><?php echo esc_html($atts['name']); ?></h4>

        <?php if ($atts['price']) : ?>
        <div class="comparison-price"><?php echo esc_html($atts['price']); ?></div>
        <?php endif; ?>

        <?php if ($atts['rating']) : ?>
        <div class="comparison-rating">
            <?php
            $rating = floatval($atts['rating']);
            for ($i = 1; $i <= 5; $i++) :
                echo $i <= $rating ? '<span class="star-filled">★</span>' : '<span>☆</span>';
            endfor;
            ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($features)) : ?>
        <ul class="comparison-features">
            <?php foreach ($features as $feature) : ?>
            <li><?php echo esc_html($feature); ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <a href="<?php echo esc_url($atts['url']); ?>" class="btn btn-primary btn-block" target="_blank" rel="noopener noreferrer">
            <?php esc_html_e('詳細を見る', 'pout-theme'); ?>
        </a>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('pout_comparison_item', 'pout_comparison_item_shortcode');

/**
 * 吹き出しショートコード
 *
 * [pout_balloon name="名前" image="画像URL" position="left"]テキスト[/pout_balloon]
 */
function pout_balloon_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'name'     => '',
        'image'    => '',
        'position' => 'left', // left, right
    ), $atts, 'pout_balloon');

    ob_start();
    ?>
    <div class="balloon balloon-<?php echo esc_attr($atts['position']); ?>">
        <div class="balloon-avatar">
            <?php if ($atts['image']) : ?>
            <img src="<?php echo esc_url($atts['image']); ?>" alt="<?php echo esc_attr($atts['name']); ?>">
            <?php endif; ?>
            <?php if ($atts['name']) : ?>
            <span class="balloon-name"><?php echo esc_html($atts['name']); ?></span>
            <?php endif; ?>
        </div>
        <div class="balloon-content">
            <?php echo wp_kses_post($content); ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('pout_balloon', 'pout_balloon_shortcode');

/**
 * 注意ボックスショートコード
 *
 * [pout_notice type="info" title="タイトル"]内容[/pout_notice]
 */
function pout_notice_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'type'  => 'info', // info, success, warning, error
        'title' => '',
    ), $atts, 'pout_notice');

    $icons = array(
        'info'    => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4M12 8h.01"></path></svg>',
        'success' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><polyline points="22,4 12,14.01 9,11.01"></polyline></svg>',
        'warning' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>',
        'error'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>',
    );

    ob_start();
    ?>
    <div class="notice-box notice-<?php echo esc_attr($atts['type']); ?>">
        <div class="notice-icon">
            <?php echo $icons[$atts['type']] ?? $icons['info']; ?>
        </div>
        <div class="notice-content">
            <?php if ($atts['title']) : ?>
            <strong class="notice-title"><?php echo esc_html($atts['title']); ?></strong>
            <?php endif; ?>
            <div class="notice-text"><?php echo wp_kses_post($content); ?></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('pout_notice', 'pout_notice_shortcode');

/**
 * アコーディオンショートコード
 *
 * [pout_accordion]
 * [pout_accordion_item title="質問1"]回答1[/pout_accordion_item]
 * [/pout_accordion]
 */
function pout_accordion_shortcode($atts, $content = null) {
    return '<div class="accordion">' . do_shortcode($content) . '</div>';
}
add_shortcode('pout_accordion', 'pout_accordion_shortcode');

function pout_accordion_item_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'title' => '',
        'open'  => 'false',
    ), $atts, 'pout_accordion_item');

    $open_attr = $atts['open'] === 'true' ? ' open' : '';

    ob_start();
    ?>
    <details class="accordion-item"<?php echo $open_attr; ?>>
        <summary class="accordion-header">
            <span><?php echo esc_html($atts['title']); ?></span>
            <svg class="accordion-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6"></path>
            </svg>
        </summary>
        <div class="accordion-content">
            <?php echo wp_kses_post($content); ?>
        </div>
    </details>
    <?php
    return ob_get_clean();
}
add_shortcode('pout_accordion_item', 'pout_accordion_item_shortcode');

/**
 * プロフィールカードショートコード
 *
 * [pout_profile name="名前" title="肩書き" image="画像URL" bio="自己紹介"]
 */
function pout_profile_shortcode($atts) {
    $atts = shortcode_atts(array(
        'name'     => '',
        'title'    => '',
        'image'    => '',
        'bio'      => '',
        'twitter'  => '',
        'linkedin' => '',
        'website'  => '',
    ), $atts, 'pout_profile');

    ob_start();
    ?>
    <div class="profile-card">
        <?php if ($atts['image']) : ?>
        <div class="profile-image">
            <img src="<?php echo esc_url($atts['image']); ?>" alt="<?php echo esc_attr($atts['name']); ?>">
        </div>
        <?php endif; ?>
        <div class="profile-info">
            <?php if ($atts['name']) : ?>
            <h4 class="profile-name"><?php echo esc_html($atts['name']); ?></h4>
            <?php endif; ?>
            <?php if ($atts['title']) : ?>
            <span class="profile-title"><?php echo esc_html($atts['title']); ?></span>
            <?php endif; ?>
            <?php if ($atts['bio']) : ?>
            <p class="profile-bio"><?php echo esc_html($atts['bio']); ?></p>
            <?php endif; ?>
            <?php if ($atts['twitter'] || $atts['linkedin'] || $atts['website']) : ?>
            <div class="profile-links">
                <?php if ($atts['twitter']) : ?>
                <a href="<?php echo esc_url($atts['twitter']); ?>" target="_blank" rel="noopener noreferrer">Twitter</a>
                <?php endif; ?>
                <?php if ($atts['linkedin']) : ?>
                <a href="<?php echo esc_url($atts['linkedin']); ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                <?php endif; ?>
                <?php if ($atts['website']) : ?>
                <a href="<?php echo esc_url($atts['website']); ?>" target="_blank" rel="noopener noreferrer">Website</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('pout_profile', 'pout_profile_shortcode');

/**
 * 投稿一覧ショートコード
 *
 * [pout_posts category="カテゴリスラッグ" count="3" columns="3"]
 */
function pout_posts_shortcode($atts) {
    $atts = shortcode_atts(array(
        'category' => '',
        'tag'      => '',
        'count'    => 3,
        'columns'  => 3,
        'orderby'  => 'date',
        'order'    => 'DESC',
    ), $atts, 'pout_posts');

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => intval($atts['count']),
        'orderby'        => $atts['orderby'],
        'order'          => $atts['order'],
    );

    if ($atts['category']) {
        $args['category_name'] = $atts['category'];
    }

    if ($atts['tag']) {
        $args['tag'] = $atts['tag'];
    }

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return '<p>' . __('記事が見つかりませんでした。', 'pout-theme') . '</p>';
    }

    ob_start();
    ?>
    <div class="shortcode-posts shortcode-posts-col-<?php echo esc_attr($atts['columns']); ?>">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
        <article class="shortcode-post-card">
            <a href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) : ?>
                <div class="shortcode-post-image">
                    <?php the_post_thumbnail('pout-card'); ?>
                </div>
                <?php endif; ?>
                <div class="shortcode-post-content">
                    <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                    <h4 class="shortcode-post-title"><?php the_title(); ?></h4>
                </div>
            </a>
        </article>
        <?php endwhile; ?>
    </div>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('pout_posts', 'pout_posts_shortcode');

/**
 * ショートコード用スタイル追加
 */
function pout_shortcodes_styles() {
    ?>
    <style>
    /* Shortcode Styles */
    .shortcode-cta {
        padding: 2rem;
        background: var(--color-bg-alt);
        border-radius: var(--radius-lg);
        margin: 2rem 0;
    }
    .shortcode-cta-highlight {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
        color: #fff;
    }
    .shortcode-cta-title {
        margin-bottom: 0.5rem;
    }
    .shortcode-cta-description {
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .affiliate-box {
        position: relative;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin: 1.5rem 0;
    }
    .affiliate-badge {
        position: absolute;
        top: -0.75rem;
        left: 1rem;
        padding: 0.25rem 0.75rem;
        background: var(--color-accent);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: var(--radius-full);
    }
    .affiliate-image { margin-bottom: 1rem; text-align: center; }
    .affiliate-image img { max-width: 200px; height: auto; }
    .affiliate-name { margin-bottom: 0.5rem; }
    .affiliate-rating { margin-bottom: 0.5rem; color: #f59e0b; }
    .affiliate-price { font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; }

    .comparison-table {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }
    .comparison-item {
        position: relative;
        padding: 1.5rem;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        text-align: center;
    }
    .comparison-item-featured {
        border-color: var(--color-primary);
        box-shadow: var(--shadow-lg);
    }
    .comparison-badge {
        position: absolute;
        top: -0.75rem;
        left: 50%;
        transform: translateX(-50%);
        padding: 0.25rem 1rem;
        background: var(--color-primary);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: var(--radius-full);
    }
    .comparison-features {
        list-style: none;
        padding: 0;
        margin: 1rem 0;
        text-align: left;
    }
    .comparison-features li::before {
        content: '✓';
        color: var(--color-success);
        margin-right: 0.5rem;
    }

    .balloon {
        display: flex;
        gap: 1rem;
        margin: 1.5rem 0;
    }
    .balloon-right {
        flex-direction: row-reverse;
    }
    .balloon-avatar {
        flex-shrink: 0;
        text-align: center;
    }
    .balloon-avatar img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
    }
    .balloon-name {
        display: block;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    .balloon-content {
        position: relative;
        padding: 1rem 1.5rem;
        background: var(--color-bg-alt);
        border-radius: var(--radius-lg);
    }
    .balloon-content::before {
        content: '';
        position: absolute;
        top: 1rem;
        border: 8px solid transparent;
    }
    .balloon-left .balloon-content::before {
        left: -16px;
        border-right-color: var(--color-bg-alt);
    }
    .balloon-right .balloon-content::before {
        right: -16px;
        border-left-color: var(--color-bg-alt);
    }

    .notice-box {
        display: flex;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-md);
        margin: 1.5rem 0;
    }
    .notice-info { background: rgba(59, 130, 246, 0.1); color: #1e40af; }
    .notice-success { background: rgba(16, 185, 129, 0.1); color: #065f46; }
    .notice-warning { background: rgba(245, 158, 11, 0.1); color: #92400e; }
    .notice-error { background: rgba(239, 68, 68, 0.1); color: #991b1b; }
    .notice-icon { flex-shrink: 0; }
    .notice-title { display: block; margin-bottom: 0.25rem; }

    .accordion-item {
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        margin-bottom: 0.5rem;
    }
    .accordion-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        cursor: pointer;
        font-weight: 500;
    }
    .accordion-icon {
        transition: transform 0.2s ease;
    }
    .accordion-item[open] .accordion-icon {
        transform: rotate(180deg);
    }
    .accordion-content {
        padding: 0 1.5rem 1rem;
    }

    .profile-card {
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem;
        background: var(--color-bg-alt);
        border-radius: var(--radius-lg);
        margin: 1.5rem 0;
    }
    .profile-image img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
    .profile-name { margin-bottom: 0.25rem; }
    .profile-title {
        display: block;
        font-size: 0.875rem;
        color: var(--color-text-muted);
        margin-bottom: 0.5rem;
    }
    .profile-bio {
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }
    .profile-links a {
        margin-right: 1rem;
        font-size: 0.875rem;
    }

    .shortcode-posts {
        display: grid;
        gap: 1.5rem;
        margin: 1.5rem 0;
    }
    .shortcode-posts-col-2 { grid-template-columns: repeat(2, 1fr); }
    .shortcode-posts-col-3 { grid-template-columns: repeat(3, 1fr); }
    .shortcode-posts-col-4 { grid-template-columns: repeat(4, 1fr); }
    .shortcode-post-card {
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow);
    }
    .shortcode-post-card a { color: inherit; }
    .shortcode-post-image img { width: 100%; aspect-ratio: 16/9; object-fit: cover; }
    .shortcode-post-content { padding: 1rem; }
    .shortcode-post-content time { font-size: 0.75rem; color: var(--color-text-muted); }
    .shortcode-post-title { font-size: 1rem; margin: 0.25rem 0 0; }

    @media (max-width: 768px) {
        .comparison-table { grid-template-columns: 1fr; }
        .shortcode-posts-col-2,
        .shortcode-posts-col-3,
        .shortcode-posts-col-4 { grid-template-columns: 1fr; }
        .balloon { flex-direction: column; }
        .balloon-right { flex-direction: column; }
        .balloon-content::before { display: none; }
        .profile-card { flex-direction: column; text-align: center; }
    }
    </style>
    <?php
}
add_action('wp_head', 'pout_shortcodes_styles');
