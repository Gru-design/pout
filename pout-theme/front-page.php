<?php
/**
 * Front Page Template
 *
 * コーポレートTOP - 企業サイトのトップページ
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<!-- ヒーローセクション -->
<section class="hero hero-corporate">
    <div class="hero-background">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('pout-hero', array('class' => 'hero-image')); ?>
        <?php endif; ?>
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content container">
        <h1 class="hero-title">
            <?php echo esc_html(get_theme_mod('pout_hero_title', 'ビジネスを加速する')); ?>
            <span class="hero-title-accent">
                <?php echo esc_html(get_theme_mod('pout_hero_title_accent', 'テクノロジーソリューション')); ?>
            </span>
        </h1>
        <p class="hero-description">
            <?php echo esc_html(get_theme_mod('pout_hero_description', '私たちは最先端のテクノロジーで、お客様のビジネス課題を解決します。')); ?>
        </p>
        <div class="hero-actions">
            <a href="<?php echo esc_url(get_theme_mod('pout_hero_cta_url', home_url('/contact/'))); ?>" class="btn btn-primary btn-lg">
                <?php echo esc_html(get_theme_mod('pout_hero_cta_text', 'お問い合わせ')); ?>
            </a>
            <a href="<?php echo esc_url(get_theme_mod('pout_hero_secondary_url', '#services')); ?>" class="btn btn-outline btn-lg">
                <?php echo esc_html(get_theme_mod('pout_hero_secondary_text', 'サービスを見る')); ?>
            </a>
        </div>
    </div>
    <div class="hero-scroll-indicator">
        <span><?php esc_html_e('Scroll', 'pout-theme'); ?></span>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14M19 12l-7 7-7-7"></path>
        </svg>
    </div>
</section>

<!-- サービス紹介セクション -->
<section id="services" class="section section-services">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Services', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('サービス', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('お客様の課題に合わせた最適なソリューションを提供します', 'pout-theme'); ?>
            </p>
        </header>

        <div class="services-grid">
            <?php
            $services = array(
                array(
                    'icon'        => 'code',
                    'title'       => 'Webサービス開発',
                    'description' => 'スケーラブルで高品質なWebアプリケーションを開発',
                ),
                array(
                    'icon'        => 'smartphone',
                    'title'       => 'モバイルアプリ開発',
                    'description' => 'iOS/Androidネイティブ・クロスプラットフォーム対応',
                ),
                array(
                    'icon'        => 'cloud',
                    'title'       => 'クラウドインフラ',
                    'description' => 'AWS/GCP/Azureを活用した堅牢なインフラ構築',
                ),
                array(
                    'icon'        => 'brain',
                    'title'       => 'AI/ML導入支援',
                    'description' => '機械学習・AIを活用した業務効率化をサポート',
                ),
            );

            foreach ($services as $index => $service) :
            ?>
            <article class="service-card" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($index * 100); ?>">
                <div class="service-icon">
                    <span class="icon icon-<?php echo esc_attr($service['icon']); ?>"></span>
                </div>
                <h3 class="service-title"><?php echo esc_html($service['title']); ?></h3>
                <p class="service-description"><?php echo esc_html($service['description']); ?></p>
                <a href="#" class="service-link">
                    <?php esc_html_e('詳しく見る', 'pout-theme'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 実績・数字セクション -->
<section class="section section-stats">
    <div class="container">
        <div class="stats-grid">
            <?php
            $stats = array(
                array('number' => '500+', 'label' => 'プロジェクト実績'),
                array('number' => '98%', 'label' => '顧客満足度'),
                array('number' => '50+', 'label' => '専門エンジニア'),
                array('number' => '10年', 'label' => '業界経験'),
            );

            foreach ($stats as $stat) :
            ?>
            <div class="stat-item">
                <span class="stat-number" data-count="<?php echo esc_attr($stat['number']); ?>">
                    <?php echo esc_html($stat['number']); ?>
                </span>
                <span class="stat-label"><?php echo esc_html($stat['label']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 事例セクション -->
<section class="section section-cases">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Case Studies', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('導入事例', 'pout-theme'); ?></h2>
        </header>

        <div class="cases-slider">
            <?php
            $cases_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'category_name'  => 'case-study',
            ));

            if ($cases_query->have_posts()) :
                while ($cases_query->have_posts()) : $cases_query->the_post();
            ?>
            <article class="case-card">
                <?php if (has_post_thumbnail()) : ?>
                <div class="case-image">
                    <?php the_post_thumbnail('pout-card'); ?>
                </div>
                <?php endif; ?>
                <div class="case-content">
                    <h3 class="case-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p class="case-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 40); ?></p>
                </div>
            </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
            <p class="no-cases"><?php esc_html_e('事例が見つかりませんでした', 'pout-theme'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ブログセクション -->
<section class="section section-blog">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Blog', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('最新記事', 'pout-theme'); ?></h2>
        </header>

        <div class="blog-grid">
            <?php
            $blog_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
            ));

            if ($blog_query->have_posts()) :
                while ($blog_query->have_posts()) : $blog_query->the_post();
            ?>
            <article class="blog-card">
                <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" class="blog-image">
                    <?php the_post_thumbnail('pout-card'); ?>
                </a>
                <?php endif; ?>
                <div class="blog-content">
                    <div class="blog-meta">
                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                        <?php
                        $categories = get_the_category();
                        if ($categories) :
                        ?>
                        <span class="blog-category"><?php echo esc_html($categories[0]->name); ?></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="blog-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
            </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <div class="section-footer">
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-outline">
                <?php esc_html_e('記事一覧を見る', 'pout-theme'); ?>
            </a>
        </div>
    </div>
</section>

<!-- CTAセクション -->
<section class="section section-cta">
    <div class="container">
        <div class="cta-box">
            <h2 class="cta-title"><?php esc_html_e('プロジェクトのご相談はこちら', 'pout-theme'); ?></h2>
            <p class="cta-description">
                <?php esc_html_e('お気軽にお問い合わせください。専門スタッフが丁寧にご対応いたします。', 'pout-theme'); ?>
            </p>
            <div class="cta-actions">
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('無料相談する', 'pout-theme'); ?>
                </a>
                <a href="tel:<?php echo esc_attr(get_theme_mod('pout_phone', '')); ?>" class="btn btn-outline btn-lg">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path>
                    </svg>
                    <?php echo esc_html(get_theme_mod('pout_phone', '03-XXXX-XXXX')); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
