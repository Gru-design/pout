<?php
/**
 * CTA Auto Insert
 *
 * CTAの自動挿入機能
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * カスタマイザーにCTA設定追加
 */
function pout_cta_customizer($wp_customize) {
    // CTAセクション
    $wp_customize->add_section('pout_cta_settings', array(
        'title'    => __('CTA設定', 'pout-theme'),
        'priority' => 40,
    ));

    // 記事内CTA有効化
    $wp_customize->add_setting('pout_cta_in_content_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('pout_cta_in_content_enable', array(
        'label'   => __('記事内CTAを有効化', 'pout-theme'),
        'section' => 'pout_cta_settings',
        'type'    => 'checkbox',
    ));

    // CTA挿入位置（見出し番号）
    $wp_customize->add_setting('pout_cta_position', array(
        'default'           => 2,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('pout_cta_position', array(
        'label'       => __('CTA挿入位置', 'pout-theme'),
        'description' => __('何番目のH2見出しの前にCTAを挿入するか', 'pout-theme'),
        'section'     => 'pout_cta_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 10,
        ),
    ));

    // CTAタイプ
    $wp_customize->add_setting('pout_cta_type', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pout_cta_type', array(
        'label'   => __('CTAタイプ', 'pout-theme'),
        'section' => 'pout_cta_settings',
        'type'    => 'select',
        'choices' => array(
            'default'   => __('デフォルト', 'pout-theme'),
            'minimal'   => __('ミニマル', 'pout-theme'),
            'highlight' => __('ハイライト', 'pout-theme'),
            'banner'    => __('バナー', 'pout-theme'),
        ),
    ));

    // CTAタイトル
    $wp_customize->add_setting('pout_cta_title', array(
        'default'           => __('無料で始めましょう', 'pout-theme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pout_cta_title', array(
        'label'   => __('CTAタイトル', 'pout-theme'),
        'section' => 'pout_cta_settings',
        'type'    => 'text',
    ));

    // CTA説明文
    $wp_customize->add_setting('pout_cta_description', array(
        'default'           => __('今すぐ無料でお試しください。クレジットカードは不要です。', 'pout-theme'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('pout_cta_description', array(
        'label'   => __('CTA説明文', 'pout-theme'),
        'section' => 'pout_cta_settings',
        'type'    => 'textarea',
    ));

    // CTAボタンテキスト
    $wp_customize->add_setting('pout_cta_button_text', array(
        'default'           => __('無料で始める', 'pout-theme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pout_cta_button_text', array(
        'label'   => __('ボタンテキスト', 'pout-theme'),
        'section' => 'pout_cta_settings',
        'type'    => 'text',
    ));

    // CTAボタンURL
    $wp_customize->add_setting('pout_cta_button_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('pout_cta_button_url', array(
        'label'   => __('ボタンURL', 'pout-theme'),
        'section' => 'pout_cta_settings',
        'type'    => 'url',
    ));

    // CTA画像
    $wp_customize->add_setting('pout_cta_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'pout_cta_image', array(
        'label'   => __('CTA画像', 'pout-theme'),
        'section' => 'pout_cta_settings',
    )));

    // 記事末尾CTA有効化
    $wp_customize->add_setting('pout_cta_after_content_enable', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('pout_cta_after_content_enable', array(
        'label'   => __('記事末尾CTAを有効化', 'pout-theme'),
        'section' => 'pout_cta_settings',
        'type'    => 'checkbox',
    ));

    // 除外カテゴリ
    $wp_customize->add_setting('pout_cta_exclude_categories', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pout_cta_exclude_categories', array(
        'label'       => __('除外カテゴリID', 'pout-theme'),
        'description' => __('カンマ区切りで指定（例: 1,5,12）', 'pout-theme'),
        'section'     => 'pout_cta_settings',
        'type'        => 'text',
    ));
}
add_action('customize_register', 'pout_cta_customizer');

/**
 * CTAボックスHTML生成
 */
function pout_get_cta_box($type = 'default') {
    $title = get_theme_mod('pout_cta_title', __('無料で始めましょう', 'pout-theme'));
    $description = get_theme_mod('pout_cta_description', __('今すぐ無料でお試しください。クレジットカードは不要です。', 'pout-theme'));
    $button_text = get_theme_mod('pout_cta_button_text', __('無料で始める', 'pout-theme'));
    $button_url = get_theme_mod('pout_cta_button_url', home_url('/contact/'));
    $image = get_theme_mod('pout_cta_image', '');

    if (!$button_url) {
        return '';
    }

    ob_start();
    ?>
    <div class="auto-cta auto-cta-<?php echo esc_attr($type); ?>">
        <?php if ($image && $type !== 'minimal') : ?>
        <div class="auto-cta-image">
            <img src="<?php echo esc_url($image); ?>" alt="">
        </div>
        <?php endif; ?>
        <div class="auto-cta-content">
            <?php if ($title) : ?>
            <h3 class="auto-cta-title"><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            <?php if ($description && $type !== 'minimal') : ?>
            <p class="auto-cta-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
            <a href="<?php echo esc_url($button_url); ?>" class="btn btn-primary btn-lg">
                <?php echo esc_html($button_text); ?>
            </a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * 記事内CTA自動挿入
 */
function pout_insert_cta_in_content($content) {
    // 投稿ページ以外は除外
    if (!is_singular('post')) {
        return $content;
    }

    // 有効化チェック
    if (!get_theme_mod('pout_cta_in_content_enable', true)) {
        return $content;
    }

    // 除外カテゴリチェック
    $exclude_cats = get_theme_mod('pout_cta_exclude_categories', '');
    if ($exclude_cats) {
        $exclude_ids = array_map('intval', explode(',', $exclude_cats));
        if (has_category($exclude_ids)) {
            return $content;
        }
    }

    // CTA挿入位置
    $position = get_theme_mod('pout_cta_position', 2);
    $type = get_theme_mod('pout_cta_type', 'default');

    // H2見出しを検索
    $pattern = '/<h2[^>]*>/i';
    preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);

    if (empty($matches[0])) {
        return $content;
    }

    // 指定位置にCTAを挿入
    $h2_count = count($matches[0]);
    $insert_index = min($position, $h2_count) - 1;

    if (isset($matches[0][$insert_index])) {
        $insert_position = $matches[0][$insert_index][1];
        $cta_html = pout_get_cta_box($type);
        $content = substr_replace($content, $cta_html, $insert_position, 0);
    }

    return $content;
}
add_filter('the_content', 'pout_insert_cta_in_content', 20);

/**
 * 記事末尾CTA自動挿入
 */
function pout_insert_cta_after_content($content) {
    // 投稿ページ以外は除外
    if (!is_singular('post')) {
        return $content;
    }

    // 有効化チェック
    if (!get_theme_mod('pout_cta_after_content_enable', true)) {
        return $content;
    }

    // 除外カテゴリチェック
    $exclude_cats = get_theme_mod('pout_cta_exclude_categories', '');
    if ($exclude_cats) {
        $exclude_ids = array_map('intval', explode(',', $exclude_cats));
        if (has_category($exclude_ids)) {
            return $content;
        }
    }

    $type = get_theme_mod('pout_cta_type', 'default');
    $cta_html = pout_get_cta_box($type);

    return $content . $cta_html;
}
add_filter('the_content', 'pout_insert_cta_after_content', 30);

/**
 * CTA用スタイル
 */
function pout_cta_styles() {
    ?>
    <style>
    .auto-cta {
        display: flex;
        gap: 2rem;
        padding: 2rem;
        margin: 2rem 0;
        background: var(--color-bg-alt);
        border-radius: var(--radius-lg);
        align-items: center;
    }

    .auto-cta-default {
        border: 2px solid var(--color-primary);
    }

    .auto-cta-highlight {
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
        color: #fff;
    }

    .auto-cta-highlight .auto-cta-title {
        color: #fff;
    }

    .auto-cta-highlight .auto-cta-description {
        opacity: 0.9;
    }

    .auto-cta-highlight .btn {
        background: #fff;
        color: var(--color-primary);
    }

    .auto-cta-minimal {
        background: transparent;
        border: 1px solid var(--color-border);
        padding: 1.5rem;
        text-align: center;
        flex-direction: column;
    }

    .auto-cta-banner {
        padding: 1.5rem 2rem;
        text-align: center;
        flex-direction: column;
    }

    .auto-cta-image {
        flex-shrink: 0;
    }

    .auto-cta-image img {
        max-width: 150px;
        height: auto;
        border-radius: var(--radius-md);
    }

    .auto-cta-content {
        flex: 1;
    }

    .auto-cta-title {
        font-size: var(--text-xl);
        margin-bottom: 0.5rem;
    }

    .auto-cta-description {
        margin-bottom: 1rem;
        color: var(--color-text-light);
    }

    @media (max-width: 768px) {
        .auto-cta {
            flex-direction: column;
            text-align: center;
        }

        .auto-cta-image img {
            max-width: 120px;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'pout_cta_styles');

/**
 * 投稿編集画面にCTA無効化オプション追加
 */
function pout_add_cta_meta_box() {
    add_meta_box(
        'pout_cta_settings',
        __('CTA設定', 'pout-theme'),
        'pout_cta_meta_box_callback',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'pout_add_cta_meta_box');

function pout_cta_meta_box_callback($post) {
    wp_nonce_field('pout_cta_meta_box', 'pout_cta_meta_box_nonce');
    $disable_cta = get_post_meta($post->ID, '_pout_disable_cta', true);
    ?>
    <p>
        <label>
            <input type="checkbox" name="pout_disable_cta" value="1" <?php checked($disable_cta, '1'); ?>>
            <?php esc_html_e('この記事のCTAを無効化', 'pout-theme'); ?>
        </label>
    </p>
    <?php
}

function pout_save_cta_meta_box($post_id) {
    if (!isset($_POST['pout_cta_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['pout_cta_meta_box_nonce'], 'pout_cta_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $disable_cta = isset($_POST['pout_disable_cta']) ? '1' : '';
    update_post_meta($post_id, '_pout_disable_cta', $disable_cta);
}
add_action('save_post', 'pout_save_cta_meta_box');

/**
 * 個別記事のCTA無効化チェック
 */
function pout_check_post_cta_disabled($content) {
    if (is_singular('post')) {
        $disable_cta = get_post_meta(get_the_ID(), '_pout_disable_cta', true);
        if ($disable_cta === '1') {
            // CTAフィルターを除去
            remove_filter('the_content', 'pout_insert_cta_in_content', 20);
            remove_filter('the_content', 'pout_insert_cta_after_content', 30);
        }
    }
    return $content;
}
add_filter('the_content', 'pout_check_post_cta_disabled', 1);
