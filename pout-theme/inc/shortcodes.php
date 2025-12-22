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

/**
 * ========================================
 * スカーシティマーケティング（カウントダウン）
 * ========================================
 */

/**
 * カウントダウンタイマーショートコード
 *
 * [pout_countdown date="2025-12-31 23:59:59" title="キャンペーン終了まで" expired_text="キャンペーンは終了しました" style="default"]
 */
function pout_countdown_shortcode($atts) {
    static $countdown_id = 0;
    $countdown_id++;

    $atts = shortcode_atts(array(
        'date'         => '',
        'title'        => __('終了まで', 'pout-theme'),
        'expired_text' => __('このキャンペーンは終了しました', 'pout-theme'),
        'style'        => 'default', // default, minimal, urgent
        'timezone'     => 'Asia/Tokyo',
    ), $atts, 'pout_countdown');

    if (empty($atts['date'])) {
        return '';
    }

    $target_date = strtotime($atts['date']);
    if (!$target_date) {
        return '';
    }

    // JavaScript用にISO形式で渡す
    $iso_date = date('c', $target_date);

    ob_start();
    ?>
    <div class="countdown-timer countdown-timer--<?php echo esc_attr($atts['style']); ?>"
         id="countdown-<?php echo esc_attr($countdown_id); ?>"
         data-target="<?php echo esc_attr($iso_date); ?>"
         data-expired-text="<?php echo esc_attr($atts['expired_text']); ?>">
        <?php if ($atts['title']) : ?>
        <div class="countdown-title"><?php echo esc_html($atts['title']); ?></div>
        <?php endif; ?>
        <div class="countdown-display">
            <div class="countdown-unit">
                <span class="countdown-value" data-unit="days">--</span>
                <span class="countdown-label"><?php esc_html_e('日', 'pout-theme'); ?></span>
            </div>
            <div class="countdown-separator">:</div>
            <div class="countdown-unit">
                <span class="countdown-value" data-unit="hours">--</span>
                <span class="countdown-label"><?php esc_html_e('時間', 'pout-theme'); ?></span>
            </div>
            <div class="countdown-separator">:</div>
            <div class="countdown-unit">
                <span class="countdown-value" data-unit="minutes">--</span>
                <span class="countdown-label"><?php esc_html_e('分', 'pout-theme'); ?></span>
            </div>
            <div class="countdown-separator">:</div>
            <div class="countdown-unit">
                <span class="countdown-value" data-unit="seconds">--</span>
                <span class="countdown-label"><?php esc_html_e('秒', 'pout-theme'); ?></span>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('pout_countdown', 'pout_countdown_shortcode');

/**
 * 期間限定バッジショートコード
 *
 * [pout_limited_badge text="期間限定" end_date="2025-12-31"]
 */
function pout_limited_badge_shortcode($atts) {
    $atts = shortcode_atts(array(
        'text'      => __('期間限定', 'pout-theme'),
        'end_date'  => '',
        'style'     => 'default', // default, urgent, premium
    ), $atts, 'pout_limited_badge');

    // 終了日が設定されていて、過ぎている場合は表示しない
    if ($atts['end_date']) {
        $end_time = strtotime($atts['end_date']);
        if ($end_time && time() > $end_time) {
            return '';
        }
    }

    return sprintf(
        '<span class="limited-badge limited-badge--%s">%s</span>',
        esc_attr($atts['style']),
        esc_html($atts['text'])
    );
}
add_shortcode('pout_limited_badge', 'pout_limited_badge_shortcode');

/**
 * 残り在庫表示ショートコード
 *
 * [pout_stock current="3" total="10" text="残りわずか"]
 */
function pout_stock_shortcode($atts) {
    $atts = shortcode_atts(array(
        'current' => 0,
        'total'   => 10,
        'text'    => '',
        'style'   => 'default', // default, bar
    ), $atts, 'pout_stock');

    $current = intval($atts['current']);
    $total = intval($atts['total']);
    $percentage = $total > 0 ? (($total - $current) / $total) * 100 : 0;

    // 在庫なしの場合
    if ($current <= 0) {
        return '<div class="stock-indicator stock-indicator--sold-out">' . __('売り切れ', 'pout-theme') . '</div>';
    }

    $text = $atts['text'];
    if (!$text) {
        if ($current <= 3) {
            $text = sprintf(__('残り%d個', 'pout-theme'), $current);
        } else {
            $text = sprintf(__('在庫あり（%d個）', 'pout-theme'), $current);
        }
    }

    $urgency_class = '';
    if ($current <= 3) {
        $urgency_class = ' stock-indicator--urgent';
    } elseif ($current <= 10) {
        $urgency_class = ' stock-indicator--limited';
    }

    ob_start();
    ?>
    <div class="stock-indicator stock-indicator--<?php echo esc_attr($atts['style']); ?><?php echo esc_attr($urgency_class); ?>">
        <?php if ($atts['style'] === 'bar') : ?>
        <div class="stock-bar">
            <div class="stock-bar-fill" style="width: <?php echo esc_attr($percentage); ?>%"></div>
        </div>
        <?php endif; ?>
        <span class="stock-text"><?php echo esc_html($text); ?></span>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('pout_stock', 'pout_stock_shortcode');

/**
 * カウントダウン/スカーシティ用スタイル
 */
function pout_scarcity_styles() {
    ?>
    <style>
    /* カウントダウンタイマー */
    .countdown-timer {
        text-align: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: #fff;
        border-radius: 0.75rem;
        margin: 1.5rem 0;
    }
    .countdown-timer--minimal {
        background: #f8fafc;
        color: #1e293b;
        border: 1px solid #e2e8f0;
    }
    .countdown-timer--urgent {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        animation: pulse-urgent 2s infinite;
    }
    @keyframes pulse-urgent {
        0%, 100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
        50% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
    }
    .countdown-title {
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        opacity: 0.9;
    }
    .countdown-display {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }
    .countdown-unit {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 3.5rem;
    }
    .countdown-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        font-variant-numeric: tabular-nums;
    }
    .countdown-label {
        font-size: 0.75rem;
        opacity: 0.8;
        margin-top: 0.25rem;
    }
    .countdown-separator {
        font-size: 1.5rem;
        font-weight: 700;
        opacity: 0.5;
    }
    .countdown-expired {
        font-size: 1rem;
        padding: 1rem;
        opacity: 0.8;
    }

    /* 期間限定バッジ */
    .limited-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 9999px;
        background: #f59e0b;
        color: #fff;
    }
    .limited-badge--urgent {
        background: #dc2626;
        animation: flash 1s infinite;
    }
    @keyframes flash {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .limited-badge--premium {
        background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    }

    /* 在庫表示 */
    .stock-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        background: #f1f5f9;
        border-radius: 0.5rem;
        margin: 0.5rem 0;
    }
    .stock-indicator--limited {
        background: #fef3c7;
        color: #92400e;
    }
    .stock-indicator--urgent {
        background: #fee2e2;
        color: #991b1b;
    }
    .stock-indicator--sold-out {
        background: #e2e8f0;
        color: #64748b;
        text-decoration: line-through;
    }
    .stock-bar {
        width: 100px;
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }
    .stock-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #dc2626 0%, #f59e0b 50%, #22c55e 100%);
        transition: width 0.3s ease;
    }

    /* ダークモード */
    [data-theme="dark"] .countdown-timer--minimal {
        background: #1e293b;
        color: #f1f5f9;
        border-color: #334155;
    }
    [data-theme="dark"] .stock-indicator {
        background: #334155;
        color: #e2e8f0;
    }
    [data-theme="dark"] .stock-indicator--limited {
        background: #422006;
        color: #fcd34d;
    }
    [data-theme="dark"] .stock-indicator--urgent {
        background: #450a0a;
        color: #fca5a5;
    }

    @media (max-width: 480px) {
        .countdown-value {
            font-size: 1.5rem;
        }
        .countdown-unit {
            min-width: 2.5rem;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'pout_scarcity_styles');

/**
 * カウントダウンJavaScript
 */
function pout_countdown_script() {
    ?>
    <script>
    (function() {
        function initCountdowns() {
            const countdowns = document.querySelectorAll('.countdown-timer[data-target]');

            countdowns.forEach(function(el) {
                const target = new Date(el.dataset.target).getTime();
                const expiredText = el.dataset.expiredText || 'Expired';

                function update() {
                    const now = Date.now();
                    const diff = target - now;

                    if (diff <= 0) {
                        el.innerHTML = '<div class="countdown-expired">' + expiredText + '</div>';
                        return;
                    }

                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    const daysEl = el.querySelector('[data-unit="days"]');
                    const hoursEl = el.querySelector('[data-unit="hours"]');
                    const minutesEl = el.querySelector('[data-unit="minutes"]');
                    const secondsEl = el.querySelector('[data-unit="seconds"]');

                    if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
                    if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
                    if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
                    if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');

                    requestAnimationFrame(function() {
                        setTimeout(update, 1000);
                    });
                }

                update();
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCountdowns);
        } else {
            initCountdowns();
        }
    })();
    </script>
    <?php
}
add_action('wp_footer', 'pout_countdown_script');
