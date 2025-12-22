<?php
/**
 * SEO & Structured Data
 *
 * SEO最適化、メタタグ、構造化データの出力
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * カスタマイザー設定追加
 */
function pout_seo_customizer($wp_customize) {
    // SEOセクション
    $wp_customize->add_section('pout_seo', array(
        'title'    => __('SEO設定', 'pout-theme'),
        'priority' => 30,
    ));

    // Google Analytics
    $wp_customize->add_setting('pout_ga_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pout_ga_id', array(
        'label'       => __('Google Analytics ID', 'pout-theme'),
        'description' => __('例: G-XXXXXXXXXX', 'pout-theme'),
        'section'     => 'pout_seo',
        'type'        => 'text',
    ));

    // Google Tag Manager
    $wp_customize->add_setting('pout_gtm_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pout_gtm_id', array(
        'label'       => __('Google Tag Manager ID', 'pout-theme'),
        'description' => __('例: GTM-XXXXXXX', 'pout-theme'),
        'section'     => 'pout_seo',
        'type'        => 'text',
    ));

    // デフォルトOGP画像
    $wp_customize->add_setting('pout_default_ogp', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'pout_default_ogp', array(
        'label'       => __('デフォルトOGP画像', 'pout-theme'),
        'description' => __('推奨サイズ: 1200x630px', 'pout-theme'),
        'section'     => 'pout_seo',
    )));

    // Twitter アカウント
    $wp_customize->add_setting('pout_twitter_account', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pout_twitter_account', array(
        'label'       => __('Twitter アカウント', 'pout-theme'),
        'description' => __('@を除いて入力', 'pout-theme'),
        'section'     => 'pout_seo',
        'type'        => 'text',
    ));

    // 会社情報セクション
    $wp_customize->add_section('pout_company', array(
        'title'    => __('会社情報', 'pout-theme'),
        'priority' => 31,
    ));

    // 会社名
    $wp_customize->add_setting('pout_company_name', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pout_company_name', array(
        'label'   => __('会社名', 'pout-theme'),
        'section' => 'pout_company',
        'type'    => 'text',
    ));

    // 電話番号
    $wp_customize->add_setting('pout_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pout_phone', array(
        'label'   => __('電話番号', 'pout-theme'),
        'section' => 'pout_company',
        'type'    => 'text',
    ));

    // メールアドレス
    $wp_customize->add_setting('pout_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('pout_email', array(
        'label'   => __('メールアドレス', 'pout-theme'),
        'section' => 'pout_company',
        'type'    => 'email',
    ));

    // 住所
    $wp_customize->add_setting('pout_address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('pout_address', array(
        'label'   => __('住所', 'pout-theme'),
        'section' => 'pout_company',
        'type'    => 'textarea',
    ));

    // SNSセクション
    $wp_customize->add_section('pout_social', array(
        'title'    => __('SNSリンク', 'pout-theme'),
        'priority' => 32,
    ));

    $social_platforms = array(
        'twitter'   => 'Twitter (X)',
        'facebook'  => 'Facebook',
        'linkedin'  => 'LinkedIn',
        'youtube'   => 'YouTube',
        'instagram' => 'Instagram',
    );

    foreach ($social_platforms as $key => $label) {
        $wp_customize->add_setting('pout_' . $key . '_url', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('pout_' . $key . '_url', array(
            'label'   => $label . ' URL',
            'section' => 'pout_social',
            'type'    => 'url',
        ));
    }
}
add_action('customize_register', 'pout_seo_customizer');

/**
 * メタタグ出力
 */
function pout_output_meta_tags() {
    $meta_description = '';
    $meta_robots = '';
    $canonical_url = '';

    if (is_front_page()) {
        $meta_description = get_bloginfo('description');
        $canonical_url = home_url('/');
    } elseif (is_singular()) {
        $post = get_post();
        $meta_description = $post->post_excerpt ?: wp_trim_words(strip_tags($post->post_content), 120);
        $canonical_url = get_permalink();
    } elseif (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        $meta_description = $term->description ?: sprintf(__('%sの記事一覧', 'pout-theme'), $term->name);
        $canonical_url = get_term_link($term);
        if (get_query_var('paged') > 1) {
            $meta_robots = 'noindex, follow';
        }
    } elseif (is_author()) {
        $author = get_queried_object();
        $meta_description = $author->description ?: sprintf(__('%sの記事一覧', 'pout-theme'), $author->display_name);
        $canonical_url = get_author_posts_url($author->ID);
    } elseif (is_search()) {
        $meta_robots = 'noindex, follow';
    } elseif (is_404()) {
        $meta_robots = 'noindex, follow';
    }

    // メタディスクリプション
    if ($meta_description) {
        $meta_description = esc_attr(wp_trim_words($meta_description, 120));
        echo '<meta name="description" content="' . $meta_description . '">' . "\n";
    }

    // robots
    if ($meta_robots) {
        echo '<meta name="robots" content="' . esc_attr($meta_robots) . '">' . "\n";
    }

    // canonical
    if ($canonical_url && !is_wp_error($canonical_url)) {
        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '">' . "\n";
    }
}
add_action('wp_head', 'pout_output_meta_tags', 1);

/**
 * OGP出力
 */
function pout_output_ogp() {
    $og_title = '';
    $og_description = '';
    $og_image = get_theme_mod('pout_default_ogp', '');
    $og_url = '';
    $og_type = 'website';

    if (is_front_page()) {
        $og_title = get_bloginfo('name');
        $og_description = get_bloginfo('description');
        $og_url = home_url('/');
    } elseif (is_singular()) {
        $post = get_post();
        $og_title = get_the_title();
        $og_description = $post->post_excerpt ?: wp_trim_words(strip_tags($post->post_content), 120);
        $og_url = get_permalink();
        $og_type = is_singular('post') ? 'article' : 'website';

        if (has_post_thumbnail()) {
            $og_image = get_the_post_thumbnail_url(null, 'pout-hero');
        }
    } elseif (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        $og_title = $term->name;
        $og_description = $term->description ?: sprintf(__('%sの記事一覧', 'pout-theme'), $term->name);
        $og_url = get_term_link($term);
    }

    if (!$og_title) {
        $og_title = wp_get_document_title();
    }
    ?>
    <!-- Open Graph -->
    <meta property="og:locale" content="<?php echo esc_attr(get_locale()); ?>">
    <meta property="og:type" content="<?php echo esc_attr($og_type); ?>">
    <meta property="og:title" content="<?php echo esc_attr($og_title); ?>">
    <?php if ($og_description) : ?>
    <meta property="og:description" content="<?php echo esc_attr(wp_trim_words($og_description, 120)); ?>">
    <?php endif; ?>
    <?php if ($og_url) : ?>
    <meta property="og:url" content="<?php echo esc_url($og_url); ?>">
    <?php endif; ?>
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <?php if ($og_image) : ?>
    <meta property="og:image" content="<?php echo esc_url($og_image); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <?php endif; ?>

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <?php
    $twitter_account = get_theme_mod('pout_twitter_account', '');
    if ($twitter_account) :
    ?>
    <meta name="twitter:site" content="@<?php echo esc_attr($twitter_account); ?>">
    <?php endif; ?>
    <meta name="twitter:title" content="<?php echo esc_attr($og_title); ?>">
    <?php if ($og_description) : ?>
    <meta name="twitter:description" content="<?php echo esc_attr(wp_trim_words($og_description, 120)); ?>">
    <?php endif; ?>
    <?php if ($og_image) : ?>
    <meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">
    <?php endif; ?>
    <?php
}
add_action('wp_head', 'pout_output_ogp', 2);

/**
 * 構造化データ出力
 */
function pout_output_structured_data() {
    $schema = array();

    // Organization（全ページ共通）
    $organization = array(
        '@type'  => 'Organization',
        '@id'    => home_url('/#organization'),
        'name'   => get_theme_mod('pout_company_name', get_bloginfo('name')),
        'url'    => home_url('/'),
    );

    $logo_id = get_theme_mod('custom_logo');
    if ($logo_id) {
        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
        if ($logo_url) {
            $organization['logo'] = array(
                '@type' => 'ImageObject',
                'url'   => $logo_url,
            );
        }
    }

    $phone = get_theme_mod('pout_phone', '');
    if ($phone) {
        $organization['telephone'] = $phone;
    }

    $email = get_theme_mod('pout_email', '');
    if ($email) {
        $organization['email'] = $email;
    }

    // WebSite
    $website = array(
        '@type'           => 'WebSite',
        '@id'             => home_url('/#website'),
        'url'             => home_url('/'),
        'name'            => get_bloginfo('name'),
        'description'     => get_bloginfo('description'),
        'publisher'       => array('@id' => home_url('/#organization')),
        'potentialAction' => array(
            '@type'       => 'SearchAction',
            'target'      => array(
                '@type'        => 'EntryPoint',
                'urlTemplate'  => home_url('/?s={search_term_string}'),
            ),
            'query-input' => 'required name=search_term_string',
        ),
    );

    if (is_front_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@graph'   => array($organization, $website),
        );
    } elseif (is_singular('post')) {
        $post = get_post();
        $author = get_userdata($post->post_author);

        $article = array(
            '@type'            => 'Article',
            '@id'              => get_permalink() . '#article',
            'headline'         => get_the_title(),
            'description'      => $post->post_excerpt ?: wp_trim_words(strip_tags($post->post_content), 120),
            'datePublished'    => get_the_date('c'),
            'dateModified'     => get_the_modified_date('c'),
            'author'           => array(
                '@type' => 'Person',
                'name'  => $author->display_name,
                'url'   => get_author_posts_url($author->ID),
            ),
            'publisher'        => array('@id' => home_url('/#organization')),
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id'   => get_permalink(),
            ),
        );

        if (has_post_thumbnail()) {
            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_data = wp_get_attachment_image_src($thumbnail_id, 'pout-hero');
            if ($thumbnail_data) {
                $article['image'] = array(
                    '@type'  => 'ImageObject',
                    'url'    => $thumbnail_data[0],
                    'width'  => $thumbnail_data[1],
                    'height' => $thumbnail_data[2],
                );
            }
        }

        $schema = array(
            '@context' => 'https://schema.org',
            '@graph'   => array($organization, $website, $article),
        );
    } elseif (is_page()) {
        $webpage = array(
            '@type'       => 'WebPage',
            '@id'         => get_permalink() . '#webpage',
            'url'         => get_permalink(),
            'name'        => get_the_title(),
            'isPartOf'    => array('@id' => home_url('/#website')),
            'about'       => array('@id' => home_url('/#organization')),
        );

        $schema = array(
            '@context' => 'https://schema.org',
            '@graph'   => array($organization, $website, $webpage),
        );
    }

    if (!empty($schema)) {
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n</script>\n";
    }
}
add_action('wp_head', 'pout_output_structured_data', 5);

/**
 * パンくずリスト構造化データ
 */
function pout_breadcrumb_structured_data() {
    if (is_front_page()) {
        return;
    }

    $items = array();
    $position = 1;

    // ホーム
    $items[] = array(
        '@type'    => 'ListItem',
        'position' => $position++,
        'name'     => __('ホーム', 'pout-theme'),
        'item'     => home_url('/'),
    );

    if (is_category()) {
        $category = get_queried_object();
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => $category->name,
        );
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $items[] = array(
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $categories[0]->name,
                'item'     => get_category_link($categories[0]->term_id),
            );
        }
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
        );
    } elseif (is_page()) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
        );
    }

    $schema = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    );

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    echo "\n</script>\n";
}
add_action('wp_footer', 'pout_breadcrumb_structured_data');

/**
 * Google Analytics / GTM
 */
function pout_output_analytics() {
    $ga_id = get_theme_mod('pout_ga_id', '');
    $gtm_id = get_theme_mod('pout_gtm_id', '');

    // Google Analytics 4
    if ($ga_id) :
    ?>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga_id); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo esc_js($ga_id); ?>');
    </script>
    <?php
    endif;

    // Google Tag Manager
    if ($gtm_id) :
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo esc_js($gtm_id); ?>');</script>
    <?php
    endif;
}
add_action('wp_head', 'pout_output_analytics', 1);

/**
 * GTM noscript fallback
 */
function pout_output_gtm_noscript() {
    $gtm_id = get_theme_mod('pout_gtm_id', '');
    if ($gtm_id) :
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr($gtm_id); ?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php
    endif;
}
add_action('wp_body_open', 'pout_output_gtm_noscript');

/**
 * FAQ構造化データ出力
 */
function pout_output_faq_schema() {
    // サービスLPページ（page-resumake）でのみ出力
    if (!is_page_template('page-resumake.php')) {
        return;
    }

    $faqs = array(
        array(
            'question' => '本当に無料で使えますか？',
            'answer'   => 'はい、Freeプランは完全無料でご利用いただけます。クレジットカードの登録も不要です。月3件までの職務経歴書作成が可能です。',
        ),
        array(
            'question' => '作成したデータは安全ですか？',
            'answer'   => 'すべてのデータは暗号化して保存されます。また、第三者への提供は一切行いません。詳しくはプライバシーポリシーをご確認ください。',
        ),
        array(
            'question' => '解約はいつでもできますか？',
            'answer'   => 'はい、いつでも解約可能です。次回請求日前に解約すれば、追加料金は発生しません。解約後もFreeプランとしてご利用いただけます。',
        ),
        array(
            'question' => 'スマートフォンでも使えますか？',
            'answer'   => 'はい、スマートフォン・タブレットでも快適にご利用いただけます。通勤中や空き時間に職務経歴書を作成・編集できます。',
        ),
    );

    $faq_items = array();
    foreach ($faqs as $faq) {
        $faq_items[] = array(
            '@type'          => 'Question',
            'name'           => $faq['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => $faq['answer'],
            ),
        );
    }

    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $faq_items,
    );

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}
add_action('wp_head', 'pout_output_faq_schema', 6);

/**
 * HowTo構造化データ出力（サービスLP用）
 */
function pout_output_howto_schema() {
    if (!is_page_template('page-resumake.php')) {
        return;
    }

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'HowTo',
        'name'        => '職務経歴書の作成方法',
        'description' => 'Resumakeを使って3ステップで職務経歴書を作成する方法',
        'totalTime'   => 'PT5M',
        'step'        => array(
            array(
                '@type'    => 'HowToStep',
                'name'     => '経歴を入力',
                'text'     => '基本情報と職務経歴を簡単入力。LinkedInからのインポートも可能。',
                'position' => 1,
            ),
            array(
                '@type'    => 'HowToStep',
                'name'     => 'AIが生成',
                'text'     => 'AIが入力情報を分析し、魅力的な文章を自動生成します。',
                'position' => 2,
            ),
            array(
                '@type'    => 'HowToStep',
                'name'     => 'ダウンロード',
                'text'     => 'PDF、Word形式で即座にダウンロード。すぐに応募開始！',
                'position' => 3,
            ),
        ),
    );

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}
add_action('wp_head', 'pout_output_howto_schema', 7);

/**
 * ===========================================
 * E-E-A-T著者プロフィール強化
 * ===========================================
 */

/**
 * 著者プロフィール用カスタムフィールドを追加
 */
function pout_add_author_fields($user) {
    ?>
    <h3><?php esc_html_e('E-E-A-T著者情報', 'pout-theme'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="pout_job_title"><?php esc_html_e('役職・肩書き', 'pout-theme'); ?></label></th>
            <td>
                <input type="text" name="pout_job_title" id="pout_job_title"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'pout_job_title', true)); ?>"
                       class="regular-text">
                <p class="description"><?php esc_html_e('例: シニアエンジニア、編集長、マーケティング責任者', 'pout-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="pout_expertise"><?php esc_html_e('専門分野', 'pout-theme'); ?></label></th>
            <td>
                <input type="text" name="pout_expertise" id="pout_expertise"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'pout_expertise', true)); ?>"
                       class="regular-text">
                <p class="description"><?php esc_html_e('カンマ区切りで入力 例: SEO, コンテンツマーケティング, Web開発', 'pout-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="pout_credentials"><?php esc_html_e('資格・認定', 'pout-theme'); ?></label></th>
            <td>
                <textarea name="pout_credentials" id="pout_credentials" rows="3" class="large-text"><?php
                    echo esc_textarea(get_user_meta($user->ID, 'pout_credentials', true));
                ?></textarea>
                <p class="description"><?php esc_html_e('1行に1つずつ入力 例: Google アナリティクス認定資格', 'pout-theme'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="pout_experience_years"><?php esc_html_e('経験年数', 'pout-theme'); ?></label></th>
            <td>
                <input type="number" name="pout_experience_years" id="pout_experience_years"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'pout_experience_years', true)); ?>"
                       class="small-text" min="0" max="50">
                <span><?php esc_html_e('年', 'pout-theme'); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="pout_organization"><?php esc_html_e('所属組織', 'pout-theme'); ?></label></th>
            <td>
                <input type="text" name="pout_organization" id="pout_organization"
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'pout_organization', true)); ?>"
                       class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="pout_linkedin"><?php esc_html_e('LinkedIn URL', 'pout-theme'); ?></label></th>
            <td>
                <input type="url" name="pout_linkedin" id="pout_linkedin"
                       value="<?php echo esc_url(get_user_meta($user->ID, 'pout_linkedin', true)); ?>"
                       class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="pout_twitter"><?php esc_html_e('X (Twitter) URL', 'pout-theme'); ?></label></th>
            <td>
                <input type="url" name="pout_twitter" id="pout_twitter"
                       value="<?php echo esc_url(get_user_meta($user->ID, 'pout_twitter', true)); ?>"
                       class="regular-text">
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'pout_add_author_fields');
add_action('edit_user_profile', 'pout_add_author_fields');

/**
 * 著者プロフィールフィールドを保存
 */
function pout_save_author_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    $fields = array(
        'pout_job_title',
        'pout_expertise',
        'pout_credentials',
        'pout_experience_years',
        'pout_organization',
        'pout_linkedin',
        'pout_twitter',
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            if ($field === 'pout_linkedin' || $field === 'pout_twitter') {
                update_user_meta($user_id, $field, esc_url_raw($_POST[$field]));
            } elseif ($field === 'pout_credentials') {
                update_user_meta($user_id, $field, sanitize_textarea_field($_POST[$field]));
            } elseif ($field === 'pout_experience_years') {
                update_user_meta($user_id, $field, absint($_POST[$field]));
            } else {
                update_user_meta($user_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
add_action('personal_options_update', 'pout_save_author_fields');
add_action('edit_user_profile_update', 'pout_save_author_fields');

/**
 * 著者構造化データ（E-E-A-T対応 Person Schema）
 */
function pout_output_author_schema() {
    if (!is_singular('post')) {
        return;
    }

    $post = get_post();
    $author_id = $post->post_author;
    $author = get_userdata($author_id);

    if (!$author) {
        return;
    }

    $job_title = get_user_meta($author_id, 'pout_job_title', true);
    $expertise = get_user_meta($author_id, 'pout_expertise', true);
    $credentials = get_user_meta($author_id, 'pout_credentials', true);
    $experience_years = get_user_meta($author_id, 'pout_experience_years', true);
    $organization = get_user_meta($author_id, 'pout_organization', true);
    $linkedin = get_user_meta($author_id, 'pout_linkedin', true);
    $twitter = get_user_meta($author_id, 'pout_twitter', true);

    $person_schema = array(
        '@context' => 'https://schema.org',
        '@type'    => 'Person',
        '@id'      => get_author_posts_url($author_id) . '#author',
        'name'     => $author->display_name,
        'url'      => get_author_posts_url($author_id),
    );

    // 役職
    if ($job_title) {
        $person_schema['jobTitle'] = $job_title;
    }

    // 専門分野
    if ($expertise) {
        $expertise_array = array_map('trim', explode(',', $expertise));
        $person_schema['knowsAbout'] = $expertise_array;
    }

    // 資格・認定
    if ($credentials) {
        $credentials_array = array_filter(array_map('trim', explode("\n", $credentials)));
        if (!empty($credentials_array)) {
            $person_schema['hasCredential'] = array_map(function($cred) {
                return array(
                    '@type'          => 'EducationalOccupationalCredential',
                    'credentialCategory' => 'certification',
                    'name'           => $cred,
                );
            }, $credentials_array);
        }
    }

    // 所属組織
    if ($organization) {
        $person_schema['worksFor'] = array(
            '@type' => 'Organization',
            'name'  => $organization,
        );
    }

    // プロフィール画像（Gravatar）
    $avatar_url = get_avatar_url($author_id, array('size' => 256));
    if ($avatar_url) {
        $person_schema['image'] = $avatar_url;
    }

    // 説明文（biography）
    if ($author->description) {
        $person_schema['description'] = wp_trim_words($author->description, 100);
    }

    // SNSリンク
    $same_as = array();
    if ($linkedin) {
        $same_as[] = $linkedin;
    }
    if ($twitter) {
        $same_as[] = $twitter;
    }
    if ($author->user_url) {
        $same_as[] = $author->user_url;
    }
    if (!empty($same_as)) {
        $person_schema['sameAs'] = $same_as;
    }

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($person_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}
add_action('wp_head', 'pout_output_author_schema', 8);

/**
 * ===========================================
 * Speakable構造化データ（AI検索/音声検索対応）
 * ===========================================
 */

/**
 * Speakable構造化データを出力
 * Google AI Overview や音声検索で読み上げ対象になる
 */
function pout_output_speakable_schema() {
    if (!is_singular('post')) {
        return;
    }

    $post = get_post();

    // 記事の要約を取得（抜粋 or 最初の段落）
    $summary = $post->post_excerpt;
    if (!$summary) {
        // 最初の段落を抽出
        preg_match('/<p[^>]*>(.*?)<\/p>/s', apply_filters('the_content', $post->post_content), $matches);
        $summary = isset($matches[1]) ? wp_strip_all_tags($matches[1]) : '';
    }

    if (!$summary) {
        return;
    }

    $schema = array(
        '@context'  => 'https://schema.org',
        '@type'     => 'WebPage',
        'name'      => get_the_title(),
        'speakable' => array(
            '@type'    => 'SpeakableSpecification',
            'cssSelector' => array(
                '.article-title',
                '.article-summary',
                '.definition-box',
                '.key-takeaway',
                'article > p:first-of-type',
            ),
        ),
        'url'       => get_permalink(),
    );

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}
add_action('wp_head', 'pout_output_speakable_schema', 9);

/**
 * ===========================================
 * Featured Snippet最適化ショートコード
 * ===========================================
 */

/**
 * 定義ボックスショートコード
 * [definition term="用語" ]定義の説明[/definition]
 */
function pout_definition_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'term' => '',
    ), $atts, 'definition');

    if (!$atts['term'] || !$content) {
        return '';
    }

    $output = '<div class="definition-box" itemscope itemtype="https://schema.org/DefinedTerm">';
    $output .= '<div class="definition-term" itemprop="name"><strong>' . esc_html($atts['term']) . 'とは？</strong></div>';
    $output .= '<div class="definition-text" itemprop="description">' . wp_kses_post($content) . '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('definition', 'pout_definition_shortcode');

/**
 * キーポイント/要約ショートコード
 * [key_takeaway title="この記事のポイント"]・ポイント1・ポイント2[/key_takeaway]
 */
function pout_key_takeaway_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'title' => 'この記事のポイント',
        'type'  => 'summary', // summary, checklist, steps
    ), $atts, 'key_takeaway');

    if (!$content) {
        return '';
    }

    $icon = '💡';
    if ($atts['type'] === 'checklist') {
        $icon = '✅';
    } elseif ($atts['type'] === 'steps') {
        $icon = '📋';
    }

    $output = '<div class="key-takeaway key-takeaway--' . esc_attr($atts['type']) . '">';
    $output .= '<div class="key-takeaway-header">';
    $output .= '<span class="key-takeaway-icon">' . $icon . '</span>';
    $output .= '<span class="key-takeaway-title">' . esc_html($atts['title']) . '</span>';
    $output .= '</div>';
    $output .= '<div class="key-takeaway-content">' . wp_kses_post(wpautop($content)) . '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('key_takeaway', 'pout_key_takeaway_shortcode');

/**
 * 記事サマリーショートコード
 * [article_summary]3行程度の要約[/article_summary]
 */
function pout_article_summary_shortcode($atts, $content = null) {
    if (!$content) {
        return '';
    }

    $output = '<div class="article-summary" role="doc-abstract">';
    $output .= '<div class="article-summary-label">📝 記事の概要</div>';
    $output .= '<div class="article-summary-text">' . wp_kses_post($content) . '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('article_summary', 'pout_article_summary_shortcode');

/**
 * 比較テーブルショートコード（Featured Snippet対応）
 * [comparison_table]
 * 項目|オプションA|オプションB
 * 価格|1000円|2000円
 * [/comparison_table]
 */
function pout_comparison_table_shortcode($atts, $content = null) {
    if (!$content) {
        return '';
    }

    $rows = array_filter(array_map('trim', explode("\n", trim($content))));
    if (count($rows) < 2) {
        return '';
    }

    $output = '<div class="comparison-table-wrapper">';
    $output .= '<table class="comparison-table">';

    $is_header = true;
    foreach ($rows as $row) {
        $cells = array_map('trim', explode('|', $row));
        $tag = $is_header ? 'th' : 'td';
        $row_class = $is_header ? 'comparison-header' : 'comparison-row';

        $output .= '<tr class="' . $row_class . '">';
        foreach ($cells as $cell) {
            $output .= '<' . $tag . '>' . esc_html($cell) . '</' . $tag . '>';
        }
        $output .= '</tr>';

        $is_header = false;
    }

    $output .= '</table>';
    $output .= '</div>';

    return $output;
}
add_shortcode('comparison_table', 'pout_comparison_table_shortcode');

/**
 * Featured Snippet用スタイル出力
 */
function pout_featured_snippet_styles() {
    ?>
    <style>
    /* 定義ボックス */
    .definition-box {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-left: 4px solid #0ea5e9;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }
    .definition-term {
        color: #0369a1;
        font-size: 1.125rem;
        margin-bottom: 0.75rem;
    }
    .definition-text {
        color: #334155;
        line-height: 1.8;
    }
    .definition-text p:last-child {
        margin-bottom: 0;
    }

    /* キーポイント */
    .key-takeaway {
        background: #fefce8;
        border: 1px solid #fde047;
        border-radius: 0.5rem;
        padding: 1.25rem;
        margin: 1.5rem 0;
    }
    .key-takeaway--checklist {
        background: #f0fdf4;
        border-color: #86efac;
    }
    .key-takeaway--steps {
        background: #faf5ff;
        border-color: #d8b4fe;
    }
    .key-takeaway-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0.75rem;
        color: #1e293b;
    }
    .key-takeaway-icon {
        font-size: 1.25rem;
    }
    .key-takeaway-content {
        color: #475569;
        line-height: 1.8;
    }
    .key-takeaway-content p:last-child {
        margin-bottom: 0;
    }
    .key-takeaway-content ul,
    .key-takeaway-content ol {
        margin: 0;
        padding-left: 1.25rem;
    }

    /* 記事サマリー */
    .article-summary {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 1.25rem;
        margin: 1.5rem 0;
    }
    .article-summary-label {
        font-weight: 700;
        color: #475569;
        margin-bottom: 0.5rem;
    }
    .article-summary-text {
        color: #64748b;
        font-size: 0.9375rem;
        line-height: 1.7;
    }

    /* 比較テーブル */
    .comparison-table-wrapper {
        overflow-x: auto;
        margin: 1.5rem 0;
    }
    .comparison-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9375rem;
    }
    .comparison-table th,
    .comparison-table td {
        padding: 0.75rem 1rem;
        text-align: left;
        border: 1px solid #e2e8f0;
    }
    .comparison-table th {
        background: #f1f5f9;
        font-weight: 700;
        color: #1e293b;
    }
    .comparison-table td {
        background: #fff;
    }
    .comparison-table tr:hover td {
        background: #f8fafc;
    }

    /* ダークモード対応 */
    [data-theme="dark"] .definition-box {
        background: linear-gradient(135deg, #0c4a6e 0%, #164e63 100%);
        border-left-color: #38bdf8;
    }
    [data-theme="dark"] .definition-term {
        color: #7dd3fc;
    }
    [data-theme="dark"] .definition-text {
        color: #e2e8f0;
    }
    [data-theme="dark"] .key-takeaway {
        background: #422006;
        border-color: #a16207;
    }
    [data-theme="dark"] .key-takeaway--checklist {
        background: #052e16;
        border-color: #166534;
    }
    [data-theme="dark"] .key-takeaway--steps {
        background: #2e1065;
        border-color: #7c3aed;
    }
    [data-theme="dark"] .key-takeaway-header {
        color: #f1f5f9;
    }
    [data-theme="dark"] .key-takeaway-content {
        color: #cbd5e1;
    }
    [data-theme="dark"] .article-summary {
        background: #1e293b;
        border-color: #334155;
    }
    [data-theme="dark"] .article-summary-label {
        color: #94a3b8;
    }
    [data-theme="dark"] .article-summary-text {
        color: #cbd5e1;
    }
    [data-theme="dark"] .comparison-table th {
        background: #334155;
        color: #f1f5f9;
    }
    [data-theme="dark"] .comparison-table td {
        background: #1e293b;
        color: #e2e8f0;
        border-color: #334155;
    }
    [data-theme="dark"] .comparison-table tr:hover td {
        background: #334155;
    }
    </style>
    <?php
}
add_action('wp_head', 'pout_featured_snippet_styles', 99);
