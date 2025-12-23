<?php
/**
 * Front Page Template
 *
 * Pout.Lab - 履歴書・職務経歴書添削の研究所
 * 累計850件以上の添削実績を持つキャリア支援サービス
 *
 * @package Pout_Theme
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<!-- Hero Section - Lab Style -->
<section class="hero hero-lab">
    <div class="hero-background">
        <div class="hero-grid-pattern"></div>
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content container">
        <div class="hero-badge">
            <span class="badge-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </span>
            <span><?php esc_html_e('ココナラ累計850件以上の添削実績', 'pout-theme'); ?></span>
        </div>
        <h1 class="hero-title">
            <span class="hero-title-sub"><?php esc_html_e('履歴書・職務経歴書添削の', 'pout-theme'); ?></span>
            <span class="hero-title-main">
                <?php esc_html_e('研究所', 'pout-theme'); ?>
                <span class="hero-title-lab">Pout<span class="dot">.</span>Lab</span>
            </span>
        </h1>
        <p class="hero-description">
            <?php esc_html_e('850件以上の添削データから導き出した「通過する書類」のメソッド。AIではなく、人の目で一人ひとりの経験と強みを言語化します。', 'pout-theme'); ?>
        </p>
        <div class="hero-actions">
            <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-primary btn-lg">
                <span><?php esc_html_e('添削サービスを見る', 'pout-theme'); ?></span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline-white btn-lg">
                <?php esc_html_e('無料相談する', 'pout-theme'); ?>
            </a>
        </div>
        <div class="hero-trust">
            <div class="trust-item">
                <span class="trust-number">850+</span>
                <span class="trust-label"><?php esc_html_e('添削実績', 'pout-theme'); ?></span>
            </div>
            <div class="trust-divider"></div>
            <div class="trust-item">
                <span class="trust-number">98%</span>
                <span class="trust-label"><?php esc_html_e('満足度', 'pout-theme'); ?></span>
            </div>
            <div class="trust-divider"></div>
            <div class="trust-item">
                <span class="trust-number">24h</span>
                <span class="trust-label"><?php esc_html_e('以内返却', 'pout-theme'); ?></span>
            </div>
        </div>
    </div>
    <div class="hero-scroll-indicator" aria-hidden="true">
        <span>Scroll</span>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14M19 12l-7 7-7-7"></path>
        </svg>
    </div>
</section>

<!-- Lab Philosophy Section -->
<section class="section section-philosophy-lab">
    <div class="container">
        <div class="philosophy-grid">
            <div class="philosophy-main">
                <span class="section-label"><?php esc_html_e('Our Research', 'pout-theme'); ?></span>
                <h2 class="section-title-large">
                    <?php esc_html_e('850件の添削から', 'pout-theme'); ?><br>
                    <?php esc_html_e('見えてきたこと', 'pout-theme'); ?>
                </h2>
                <div class="philosophy-quote-box">
                    <blockquote>
                        <?php esc_html_e('「書類で落ちる人」と「通過する人」の差は、スキルの差ではなく「伝え方」の差だった。', 'pout-theme'); ?>
                    </blockquote>
                </div>
                <p class="philosophy-text">
                    <?php esc_html_e('ココナラで累計850件以上の職務経歴書・履歴書を添削してきた中で、私たちは一つの確信を得ました。どんなに素晴らしい経験も、正しく言語化されなければ採用担当者には伝わらない。', 'pout-theme'); ?>
                </p>
                <p class="philosophy-text">
                    <?php esc_html_e('Pout.Labは、その知見をもとに「通過する書類」のメソッドを体系化。一人ひとりの経験を、採用担当者の心に響く言葉に変換します。', 'pout-theme'); ?>
                </p>
            </div>
            <div class="philosophy-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14,2 14,8 20,8"></polyline>
                            <path d="M9 15l2 2 4-4"></path>
                        </svg>
                    </div>
                    <span class="stat-number">850<span class="stat-unit">件+</span></span>
                    <span class="stat-label"><?php esc_html_e('累計添削数', 'pout-theme'); ?></span>
                    <span class="stat-note"><?php esc_html_e('ココナラ有料サービス', 'pout-theme'); ?></span>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                            <line x1="9" y1="9" x2="9.01" y2="9"></line>
                            <line x1="15" y1="9" x2="15.01" y2="9"></line>
                        </svg>
                    </div>
                    <span class="stat-number">98<span class="stat-unit">%</span></span>
                    <span class="stat-label"><?php esc_html_e('利用者満足度', 'pout-theme'); ?></span>
                    <span class="stat-note"><?php esc_html_e('5段階評価の平均', 'pout-theme'); ?></span>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path>
                        </svg>
                    </div>
                    <span class="stat-number">24<span class="stat-unit">h</span></span>
                    <span class="stat-label"><?php esc_html_e('平均返却時間', 'pout-theme'); ?></span>
                    <span class="stat-note"><?php esc_html_e('スピード対応', 'pout-theme'); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="section section-services-lab">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Services', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('サービス', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('研究所が提供する、書類通過率を上げるためのサービス', 'pout-theme'); ?>
            </p>
        </header>

        <div class="services-grid-lab">
            <!-- MEDECHECK - Main Service -->
            <article class="service-card-lab service-featured">
                <div class="service-badge"><?php esc_html_e('人気No.1', 'pout-theme'); ?></div>
                <div class="service-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14,2 14,8 20,8"></polyline>
                        <path d="M9 15l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="service-title">MEDECHECK</h3>
                <p class="service-subtitle"><?php esc_html_e('職務経歴書・履歴書 添削サービス', 'pout-theme'); ?></p>
                <p class="service-description">
                    <?php esc_html_e('850件以上の添削実績から確立したメソッドで、あなたの書類を「通過する書類」に変えます。AIじゃない。目で、チェック。', 'pout-theme'); ?>
                </p>
                <ul class="service-features">
                    <li><?php esc_html_e('24時間以内の返却', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('詳細な添削コメント', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('修正例の提示', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('追加質問OK', 'pout-theme'); ?></li>
                </ul>
                <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-primary btn-lg btn-block">
                    <?php esc_html_e('詳しく見る', 'pout-theme'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </article>

            <!-- note - Knowledge Store -->
            <article class="service-card-lab">
                <div class="service-icon service-icon-secondary">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        <line x1="8" y1="6" x2="16" y2="6"></line>
                        <line x1="8" y1="10" x2="16" y2="10"></line>
                        <line x1="8" y1="14" x2="12" y2="14"></line>
                    </svg>
                </div>
                <h3 class="service-title"><?php esc_html_e('研究レポート', 'pout-theme'); ?></h3>
                <p class="service-subtitle"><?php esc_html_e('note / コンテンツ販売', 'pout-theme'); ?></p>
                <p class="service-description">
                    <?php esc_html_e('850件の添削で発見した「書類選考に通る人」のパターンを体系化。すぐに使えるテンプレートとノウハウを公開中。', 'pout-theme'); ?>
                </p>
                <a href="https://note.com/pout_lab" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-block">
                    <?php esc_html_e('noteで読む', 'pout-theme'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15,3 21,3 21,9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                </a>
            </article>

            <!-- Career Consulting -->
            <article class="service-card-lab">
                <div class="service-icon service-icon-secondary">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h3 class="service-title"><?php esc_html_e('キャリア相談', 'pout-theme'); ?></h3>
                <p class="service-subtitle"><?php esc_html_e('1on1コンサルティング', 'pout-theme'); ?></p>
                <p class="service-description">
                    <?php esc_html_e('転職戦略、キャリアプラン、市場価値の見極め。書類添削の知見を活かした、実践的なキャリアコンサルティング。', 'pout-theme'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline btn-block">
                    <?php esc_html_e('相談する', 'pout-theme'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </article>
        </div>
    </div>
</section>

<!-- Research Insights Section -->
<section class="section section-insights lp-section-alt">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Research Insights', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('研究所が発見した「通過する書類」の法則', 'pout-theme'); ?></h2>
        </header>

        <div class="insights-grid">
            <div class="insight-card">
                <span class="insight-number">01</span>
                <h3 class="insight-title"><?php esc_html_e('数字で語る', 'pout-theme'); ?></h3>
                <p class="insight-text">
                    <?php esc_html_e('「売上向上に貢献」より「売上30%増」。具体的な数字がある書類は、通過率が2倍以上。', 'pout-theme'); ?>
                </p>
            </div>
            <div class="insight-card">
                <span class="insight-number">02</span>
                <h3 class="insight-title"><?php esc_html_e('結果から書く', 'pout-theme'); ?></h3>
                <p class="insight-text">
                    <?php esc_html_e('「何をしたか」ではなく「何を達成したか」から書く。採用担当者が知りたいのは"成果"。', 'pout-theme'); ?>
                </p>
            </div>
            <div class="insight-card">
                <span class="insight-number">03</span>
                <h3 class="insight-title"><?php esc_html_e('一貫性を持たせる', 'pout-theme'); ?></h3>
                <p class="insight-text">
                    <?php esc_html_e('履歴書と職務経歴書でストーリーが繋がっている書類は、面接に進む確率が高い。', 'pout-theme'); ?>
                </p>
            </div>
        </div>

        <div class="section-footer text-center" style="margin-top: var(--space-10);">
            <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="btn btn-outline">
                <?php esc_html_e('研究レポートを読む', 'pout-theme'); ?>
            </a>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="section">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('How It Works', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('ご利用の流れ', 'pout-theme'); ?></h2>
            <p class="section-description">
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
                <h3 class="step-title"><?php esc_html_e('研究員が添削', 'pout-theme'); ?></h3>
                <p class="step-text"><?php esc_html_e('850件以上の実績を持つ研究員が、一つひとつ丁寧にチェック・添削します。', 'pout-theme'); ?></p>
            </div>
            <div class="step-card">
                <span class="step-number">3</span>
                <h3 class="step-title"><?php esc_html_e('添削完了', 'pout-theme'); ?></h3>
                <p class="step-text"><?php esc_html_e('詳細な添削コメント付きの書類をお届け。修正ポイントが一目でわかります。', 'pout-theme'); ?></p>
            </div>
        </div>

        <div class="section-footer text-center" style="margin-top: var(--space-12);">
            <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-primary btn-lg">
                <?php esc_html_e('添削を依頼する', 'pout-theme'); ?>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section lp-section-alt">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Testimonials', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('ご利用者様の声', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('ココナラで850件以上の方にご利用いただいています', 'pout-theme'); ?>
            </p>
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
<section class="section section-blog">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Research & Articles', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('最新の研究レポート', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('書類選考を突破するための知見を発信しています', 'pout-theme'); ?>
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
                            <div class="post-card-image-placeholder">Pout.Lab</div>
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
                <?php esc_html_e('すべての記事を見る', 'pout-theme'); ?>
            </a>
        </div>
    </div>
</section>

<!-- Affiliate Partner Section -->
<section class="section section-partners lp-section-alt">
    <div class="container">
        <header class="section-header">
            <span class="section-label"><?php esc_html_e('Recommended Services', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('転職を成功させるパートナー', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('Pout.Labが厳選した、信頼できる転職支援サービス', 'pout-theme'); ?>
            </p>
        </header>

        <div class="partners-grid">
            <a href="<?php echo esc_url(home_url('/tools/')); ?>" class="partner-card">
                <span class="partner-category"><?php esc_html_e('転職エージェント', 'pout-theme'); ?></span>
                <h3 class="partner-title"><?php esc_html_e('エージェント比較ガイド', 'pout-theme'); ?></h3>
                <p class="partner-description">
                    <?php esc_html_e('業界・職種別におすすめの転職エージェントを比較。あなたに合ったエージェントが見つかります。', 'pout-theme'); ?>
                </p>
                <span class="partner-cta">
                    <?php esc_html_e('比較を見る', 'pout-theme'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </span>
            </a>

            <a href="<?php echo esc_url(home_url('/tools/')); ?>" class="partner-card">
                <span class="partner-category"><?php esc_html_e('スキルアップ', 'pout-theme'); ?></span>
                <h3 class="partner-title"><?php esc_html_e('学習サービス比較', 'pout-theme'); ?></h3>
                <p class="partner-description">
                    <?php esc_html_e('プログラミング、ビジネススキル、資格取得。キャリアアップに役立つ学習サービスを紹介。', 'pout-theme'); ?>
                </p>
                <span class="partner-cta">
                    <?php esc_html_e('サービスを見る', 'pout-theme'); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section section-cta-lab">
    <div class="container">
        <div class="cta-box-lab">
            <div class="cta-content">
                <span class="cta-badge"><?php esc_html_e('累計850件以上の実績', 'pout-theme'); ?></span>
                <h2 class="cta-title"><?php esc_html_e('あなたの書類、研究所で診断しませんか？', 'pout-theme'); ?></h2>
                <p class="cta-description">
                    <?php esc_html_e('850件以上の添削で培った知見をもとに、あなたの書類を「通過する書類」に変えます。初回相談は無料。', 'pout-theme'); ?>
                </p>
                <div class="cta-actions">
                    <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-primary btn-lg">
                        <?php esc_html_e('添削サービスを見る', 'pout-theme'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline-white btn-lg">
                        <?php esc_html_e('無料相談する', 'pout-theme'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
