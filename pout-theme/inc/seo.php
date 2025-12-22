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
