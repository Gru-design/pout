<?php
/**
 * Front Page Template
 *
 * コーポレートTOP - Pout Consulting
 * キャリア支援・書類添削サービス MEDECHECK
 *
 * @package Pout_Theme
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<!-- Hero Section -->
<section class="hero hero-corporate">
    <div class="hero-background">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('pout-hero', array('class' => 'hero-image')); ?>
        <?php endif; ?>
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content container">
        <span class="hero-tagline"><?php esc_html_e('Career Consulting', 'pout-theme'); ?></span>
        <h1 class="hero-title">
            <?php esc_html_e('あなたのキャリアを', 'pout-theme'); ?>
            <span class="hero-title-accent"><?php esc_html_e('次のステージへ', 'pout-theme'); ?></span>
        </h1>
        <p class="hero-description">
            <?php esc_html_e('Poutは、プロのキャリアアドバイザーによる書類添削サービス「MEDECHECK」を提供しています。AIじゃない。目で、チェック。人の目で、あなたの魅力を引き出します。', 'pout-theme'); ?>
        </p>
        <div class="hero-actions">
            <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('MEDECHECKを見る', 'pout-theme'); ?>
            </a>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline-white btn-lg">
                <?php esc_html_e('無料相談する', 'pout-theme'); ?>
            </a>
        </div>
    </div>
    <div class="hero-scroll-indicator" aria-hidden="true">
        <span>Scroll</span>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14M19 12l-7 7-7-7"></path>
        </svg>
    </div>
</section>

<!-- Philosophy Section -->
<section class="section section-philosophy">
    <div class="container">
        <div class="philosophy-content">
            <div class="philosophy-text">
                <span class="section-label"><?php esc_html_e('Our Philosophy', 'pout-theme'); ?></span>
                <h2 class="section-title"><?php esc_html_e('私たちが大切にしていること', 'pout-theme'); ?></h2>
                <p>
                    <?php esc_html_e('職務経歴書は、あなたのキャリアを語る「名刺」です。AIによる自動生成が溢れる今だからこそ、私たちは「人の目」にこだわります。', 'pout-theme'); ?>
                </p>
                <p>
                    <?php esc_html_e('一人ひとりの経験、想い、強みは十人十色。テンプレートでは伝わらない「あなたらしさ」を、経験豊富なキャリアアドバイザーが丁寧に引き出し、言葉にします。', 'pout-theme'); ?>
                </p>
            </div>
            <div class="philosophy-quote">
                <blockquote>
                    <?php esc_html_e('AIじゃない。目で、チェック。', 'pout-theme'); ?>
                </blockquote>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="section section-services">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Services', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('サービス', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('キャリアのあらゆるステージでサポートします', 'pout-theme'); ?>
            </p>
        </header>

        <div class="services-grid">
            <!-- MEDECHECK - Featured -->
            <article class="service-card service-card-featured">
                <div class="service-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14,2 14,8 20,8"></polyline>
                        <path d="M9 15l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="service-title">MEDECHECK</h3>
                <p class="service-description">
                    <?php esc_html_e('職務経歴書・履歴書の添削サービス。プロの目で、あなたの魅力を最大限に引き出します。', 'pout-theme'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="service-link">
                    <?php esc_html_e('詳しく見る', 'pout-theme'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </article>

            <!-- Career Consulting -->
            <article class="service-card">
                <div class="service-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h3 class="service-title"><?php esc_html_e('キャリア相談', 'pout-theme'); ?></h3>
                <p class="service-description">
                    <?php esc_html_e('転職・キャリアチェンジに関する個別相談。あなたの強みと市場価値を一緒に見つけます。', 'pout-theme'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/consulting/')); ?>" class="service-link">
                    <?php esc_html_e('詳しく見る', 'pout-theme'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </article>

            <!-- Interview Coaching -->
            <article class="service-card">
                <div class="service-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <h3 class="service-title"><?php esc_html_e('面接対策', 'pout-theme'); ?></h3>
                <p class="service-description">
                    <?php esc_html_e('模擬面接で本番に備える。よくある質問への回答準備から、話し方のコツまでサポート。', 'pout-theme'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/interview/')); ?>" class="service-link">
                    <?php esc_html_e('詳しく見る', 'pout-theme'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </article>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section section-stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number" data-count="3,000">3,000+</span>
                <span class="stat-label"><?php esc_html_e('添削実績', 'pout-theme'); ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-count="98">98%</span>
                <span class="stat-label"><?php esc_html_e('満足度', 'pout-theme'); ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-count="24">24h</span>
                <span class="stat-label"><?php esc_html_e('平均返却時間', 'pout-theme'); ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-count="15">15年+</span>
                <span class="stat-label"><?php esc_html_e('業界経験', 'pout-theme'); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="section lp-section-alt">
    <div class="container">
        <header class="lp-section-header">
            <span class="lp-section-label"><?php esc_html_e('How It Works', 'pout-theme'); ?></span>
            <h2 class="lp-section-title"><?php esc_html_e('ご利用の流れ', 'pout-theme'); ?></h2>
            <p class="lp-section-description">
                <?php esc_html_e('かんたん3ステップで添削完了', 'pout-theme'); ?>
            </p>
        </header>

        <div class="steps-grid">
            <div class="step-card">
                <span class="step-number">1</span>
                <h3 class="step-title"><?php esc_html_e('書類をアップロード', 'pout-theme'); ?></h3>
                <p class="step-text"><?php esc_html_e('職務経歴書・履歴書をお送りください。Word、PDF、テキスト形式に対応。', 'pout-theme'); ?></p>
            </div>
            <div class="step-card">
                <span class="step-number">2</span>
                <h3 class="step-title"><?php esc_html_e('プロが添削', 'pout-theme'); ?></h3>
                <p class="step-text"><?php esc_html_e('経験豊富なキャリアアドバイザーが、一つひとつ丁寧にチェック・添削します。', 'pout-theme'); ?></p>
            </div>
            <div class="step-card">
                <span class="step-number">3</span>
                <h3 class="step-title"><?php esc_html_e('添削完了', 'pout-theme'); ?></h3>
                <p class="step-text"><?php esc_html_e('添削コメント付きの書類をお届け。修正ポイントが一目でわかります。', 'pout-theme'); ?></p>
            </div>
        </div>

        <div class="section-footer text-center" style="margin-top: var(--space-12);">
            <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('MEDECHECKを詳しく見る', 'pout-theme'); ?>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Testimonials', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('ご利用者様の声', 'pout-theme'); ?></h2>
        </header>

        <div class="testimonials-grid">
            <article class="testimonial-card">
                <div class="testimonial-rating" aria-label="5 out of 5 stars">
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                </div>
                <p class="testimonial-text">
                    <?php esc_html_e('自分では気づかなかった強みを引き出してもらえました。添削後の書類で書類選考の通過率が大幅にアップしました。', 'pout-theme'); ?>
                </p>
                <footer class="testimonial-author">
                    <span class="testimonial-name"><?php esc_html_e('T.S.様', 'pout-theme'); ?></span>
                    <span class="testimonial-role"><?php esc_html_e('30代・ITエンジニア', 'pout-theme'); ?></span>
                </footer>
            </article>

            <article class="testimonial-card">
                <div class="testimonial-rating" aria-label="5 out of 5 stars">
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                </div>
                <p class="testimonial-text">
                    <?php esc_html_e('AIの添削も試しましたが、やはり人間ならではの細やかなアドバイスが違います。「なぜそう書くべきか」が理解できました。', 'pout-theme'); ?>
                </p>
                <footer class="testimonial-author">
                    <span class="testimonial-name"><?php esc_html_e('M.K.様', 'pout-theme'); ?></span>
                    <span class="testimonial-role"><?php esc_html_e('20代・マーケティング', 'pout-theme'); ?></span>
                </footer>
            </article>

            <article class="testimonial-card">
                <div class="testimonial-rating" aria-label="5 out of 5 stars">
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                    <span class="star star-filled" aria-hidden="true">&#9733;</span>
                </div>
                <p class="testimonial-text">
                    <?php esc_html_e('返却が速くて助かりました。丁寧なコメントで、次回以降の自己作成にも活かせる内容でした。', 'pout-theme'); ?>
                </p>
                <footer class="testimonial-author">
                    <span class="testimonial-name"><?php esc_html_e('Y.A.様', 'pout-theme'); ?></span>
                    <span class="testimonial-role"><?php esc_html_e('40代・管理職', 'pout-theme'); ?></span>
                </footer>
            </article>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="section section-blog lp-section-alt">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Media', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('最新記事', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('キャリアアップに役立つ情報を発信しています', 'pout-theme'); ?>
            </p>
        </header>

        <div class="posts-grid">
            <?php
            $blog_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
            ));

            if ($blog_query->have_posts()) :
                while ($blog_query->have_posts()) :
                    $blog_query->the_post();
            ?>
            <article class="post-card">
                <a href="<?php the_permalink(); ?>" class="post-card-link">
                    <div class="post-card-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('pout-card', array('loading' => 'lazy')); ?>
                        <?php else : ?>
                            <div class="post-card-image-placeholder">Pout</div>
                        <?php endif; ?>
                    </div>
                    <div class="post-card-content">
                        <div class="post-meta">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) :
                            ?>
                            <span class="post-category"><?php echo esc_html($categories[0]->name); ?></span>
                            <?php endif; ?>
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                        </div>
                        <h3 class="post-card-title"><?php the_title(); ?></h3>
                        <p class="post-card-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 40, '...')); ?></p>
                    </div>
                </a>
            </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
            <p class="text-center"><?php esc_html_e('記事が見つかりませんでした', 'pout-theme'); ?></p>
            <?php endif; ?>
        </div>

        <div class="section-footer text-center" style="margin-top: var(--space-10);">
            <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="btn btn-outline">
                <?php esc_html_e('記事一覧を見る', 'pout-theme'); ?>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section section-cta">
    <div class="container">
        <div class="cta-box">
            <h2 class="cta-title"><?php esc_html_e('あなたの書類、プロにチェックしてもらいませんか？', 'pout-theme'); ?></h2>
            <p class="cta-description">
                <?php esc_html_e('MEDECHECKなら、経験豊富なキャリアアドバイザーが丁寧に添削。初回限定で無料相談も実施中です。', 'pout-theme'); ?>
            </p>
            <div class="cta-actions">
                <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('MEDECHECKを試す', 'pout-theme'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline-gold btn-lg">
                    <?php esc_html_e('無料相談する', 'pout-theme'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
