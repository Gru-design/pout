<?php
/**
 * Template Name: サービスLP
 *
 * サービスランディングページ - Resumake等のサービス紹介
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<!-- ヒーローセクション -->
<section class="lp-hero">
    <div class="container">
        <div class="lp-hero-content">
            <span class="lp-hero-badge"><?php esc_html_e('NEW SERVICE', 'pout-theme'); ?></span>
            <h1 class="lp-hero-title">
                <?php the_title(); ?>
            </h1>
            <p class="lp-hero-description">
                <?php echo get_the_excerpt() ?: esc_html__('AIが自動で魅力的な職務経歴書を作成。転職活動を強力にサポートします。', 'pout-theme'); ?>
            </p>
            <div class="lp-hero-actions">
                <a href="#signup" class="btn btn-primary btn-xl">
                    <?php esc_html_e('今すぐ無料で始める', 'pout-theme'); ?>
                </a>
                <a href="#features" class="btn btn-ghost btn-xl">
                    <?php esc_html_e('機能を見る', 'pout-theme'); ?>
                </a>
            </div>
            <p class="lp-hero-note">
                <?php esc_html_e('※ クレジットカード不要・即日利用可能', 'pout-theme'); ?>
            </p>
        </div>
        <div class="lp-hero-visual">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('class' => 'lp-hero-image')); ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 課題提起セクション -->
<section class="lp-section lp-problem">
    <div class="container">
        <header class="lp-section-header">
            <h2 class="lp-section-title"><?php esc_html_e('こんなお悩みありませんか？', 'pout-theme'); ?></h2>
        </header>
        <div class="problem-grid">
            <?php
            $problems = array(
                array(
                    'icon'  => 'clock',
                    'title' => '時間がかかる',
                    'text'  => '職務経歴書の作成に何時間もかかってしまう',
                ),
                array(
                    'icon'  => 'edit',
                    'title' => '書き方がわからない',
                    'text'  => '自分のスキルや経験をうまく表現できない',
                ),
                array(
                    'icon'  => 'target',
                    'title' => '採用されない',
                    'text'  => '応募しても書類選考で落とされてしまう',
                ),
                array(
                    'icon'  => 'refresh',
                    'title' => '更新が面倒',
                    'text'  => '応募先ごとにカスタマイズするのが大変',
                ),
            );
            foreach ($problems as $problem) :
            ?>
            <div class="problem-card">
                <span class="problem-icon icon-<?php echo esc_attr($problem['icon']); ?>"></span>
                <h3 class="problem-title"><?php echo esc_html($problem['title']); ?></h3>
                <p class="problem-text"><?php echo esc_html($problem['text']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ソリューションセクション -->
<section class="lp-section lp-solution">
    <div class="container">
        <header class="lp-section-header">
            <span class="lp-section-label"><?php esc_html_e('Solution', 'pout-theme'); ?></span>
            <h2 class="lp-section-title"><?php esc_html_e('すべてAIにお任せください', 'pout-theme'); ?></h2>
            <p class="lp-section-description">
                <?php esc_html_e('Resumakeが職務経歴書作成の悩みをすべて解決します', 'pout-theme'); ?>
            </p>
        </header>
        <div class="solution-visual">
            <div class="solution-before">
                <span class="solution-label"><?php esc_html_e('Before', 'pout-theme'); ?></span>
                <p><?php esc_html_e('作成に3時間以上', 'pout-theme'); ?></p>
            </div>
            <div class="solution-arrow">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </div>
            <div class="solution-after">
                <span class="solution-label"><?php esc_html_e('After', 'pout-theme'); ?></span>
                <p><?php esc_html_e('たった5分で完成', 'pout-theme'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- 機能紹介セクション -->
<section id="features" class="lp-section lp-features">
    <div class="container">
        <header class="lp-section-header">
            <span class="lp-section-label"><?php esc_html_e('Features', 'pout-theme'); ?></span>
            <h2 class="lp-section-title"><?php esc_html_e('主な機能', 'pout-theme'); ?></h2>
        </header>
        <div class="features-list">
            <?php
            $features = array(
                array(
                    'title'       => 'AIによる自動生成',
                    'description' => '経歴情報を入力するだけで、AIが最適な表現で職務経歴書を自動作成します。',
                    'image'       => 'feature-ai.png',
                ),
                array(
                    'title'       => '業界別テンプレート',
                    'description' => 'IT、金融、医療など業界に特化したテンプレートを多数用意。',
                    'image'       => 'feature-template.png',
                ),
                array(
                    'title'       => 'ワンクリック応募',
                    'description' => '作成した職務経歴書を求人サイトに直接送信可能。',
                    'image'       => 'feature-apply.png',
                ),
                array(
                    'title'       => 'ATS対策済み',
                    'description' => '採用管理システム（ATS）に最適化されたフォーマットで通過率UP。',
                    'image'       => 'feature-ats.png',
                ),
            );
            foreach ($features as $index => $feature) :
                $is_reverse = $index % 2 === 1;
            ?>
            <div class="feature-item <?php echo $is_reverse ? 'feature-reverse' : ''; ?>">
                <div class="feature-content">
                    <span class="feature-number"><?php echo sprintf('%02d', $index + 1); ?></span>
                    <h3 class="feature-title"><?php echo esc_html($feature['title']); ?></h3>
                    <p class="feature-description"><?php echo esc_html($feature['description']); ?></p>
                </div>
                <div class="feature-visual">
                    <div class="feature-image-placeholder">
                        <span><?php echo esc_html($feature['title']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 使い方セクション -->
<section class="lp-section lp-steps">
    <div class="container">
        <header class="lp-section-header">
            <span class="lp-section-label"><?php esc_html_e('How it works', 'pout-theme'); ?></span>
            <h2 class="lp-section-title"><?php esc_html_e('3ステップで完成', 'pout-theme'); ?></h2>
        </header>
        <div class="steps-grid">
            <?php
            $steps = array(
                array(
                    'step'  => '01',
                    'title' => '経歴を入力',
                    'text'  => '基本情報と職務経歴を簡単入力。LinkedInからのインポートも可能。',
                ),
                array(
                    'step'  => '02',
                    'title' => 'AIが生成',
                    'text'  => 'AIが入力情報を分析し、魅力的な文章を自動生成します。',
                ),
                array(
                    'step'  => '03',
                    'title' => 'ダウンロード',
                    'text'  => 'PDF、Word形式で即座にダウンロード。すぐに応募開始！',
                ),
            );
            foreach ($steps as $step) :
            ?>
            <div class="step-card">
                <span class="step-number"><?php echo esc_html($step['step']); ?></span>
                <h3 class="step-title"><?php echo esc_html($step['title']); ?></h3>
                <p class="step-text"><?php echo esc_html($step['text']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 料金セクション -->
<section class="lp-section lp-pricing">
    <div class="container">
        <header class="lp-section-header">
            <span class="lp-section-label"><?php esc_html_e('Pricing', 'pout-theme'); ?></span>
            <h2 class="lp-section-title"><?php esc_html_e('シンプルな料金プラン', 'pout-theme'); ?></h2>
        </header>
        <div class="pricing-grid">
            <!-- フリープラン -->
            <div class="pricing-card">
                <div class="pricing-header">
                    <h3 class="pricing-name"><?php esc_html_e('Free', 'pout-theme'); ?></h3>
                    <div class="pricing-price">
                        <span class="price-amount">¥0</span>
                        <span class="price-period">/月</span>
                    </div>
                </div>
                <ul class="pricing-features">
                    <li><?php esc_html_e('職務経歴書 月3件まで', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('基本テンプレート', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('PDF出力', 'pout-theme'); ?></li>
                </ul>
                <a href="#signup" class="btn btn-outline btn-block">
                    <?php esc_html_e('無料で始める', 'pout-theme'); ?>
                </a>
            </div>

            <!-- プロプラン -->
            <div class="pricing-card pricing-featured">
                <span class="pricing-badge"><?php esc_html_e('人気', 'pout-theme'); ?></span>
                <div class="pricing-header">
                    <h3 class="pricing-name"><?php esc_html_e('Pro', 'pout-theme'); ?></h3>
                    <div class="pricing-price">
                        <span class="price-amount">¥980</span>
                        <span class="price-period">/月</span>
                    </div>
                </div>
                <ul class="pricing-features">
                    <li><?php esc_html_e('職務経歴書 無制限', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('全テンプレート利用可', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('PDF/Word出力', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('AIリライト機能', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('優先サポート', 'pout-theme'); ?></li>
                </ul>
                <a href="#signup" class="btn btn-primary btn-block">
                    <?php esc_html_e('Proを始める', 'pout-theme'); ?>
                </a>
            </div>

            <!-- エンタープライズ -->
            <div class="pricing-card">
                <div class="pricing-header">
                    <h3 class="pricing-name"><?php esc_html_e('Enterprise', 'pout-theme'); ?></h3>
                    <div class="pricing-price">
                        <span class="price-amount"><?php esc_html_e('要相談', 'pout-theme'); ?></span>
                    </div>
                </div>
                <ul class="pricing-features">
                    <li><?php esc_html_e('Pro全機能', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('チーム管理機能', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('API連携', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('カスタムテンプレート', 'pout-theme'); ?></li>
                    <li><?php esc_html_e('専任サポート', 'pout-theme'); ?></li>
                </ul>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline btn-block">
                    <?php esc_html_e('お問い合わせ', 'pout-theme'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- お客様の声セクション -->
<section class="lp-section lp-testimonials">
    <div class="container">
        <header class="lp-section-header">
            <span class="lp-section-label"><?php esc_html_e('Testimonials', 'pout-theme'); ?></span>
            <h2 class="lp-section-title"><?php esc_html_e('ご利用者の声', 'pout-theme'); ?></h2>
        </header>
        <div class="testimonials-grid">
            <?php
            $testimonials = array(
                array(
                    'name'    => '田中 太郎',
                    'role'    => 'ITエンジニア・30代',
                    'text'    => 'これまで何時間もかけていた職務経歴書が、わずか10分で完成しました。AIが提案してくれる文章が的確で、自分では思いつかなかった表現も多く、とても助かりました。',
                    'rating'  => 5,
                ),
                array(
                    'name'    => '佐藤 花子',
                    'role'    => '営業職・20代',
                    'text'    => '転職活動中に友人に勧められて使い始めました。テンプレートが豊富で、業界に合わせた書き方ができるのが良いですね。おかげで書類選考の通過率が上がりました！',
                    'rating'  => 5,
                ),
                array(
                    'name'    => '鈴木 一郎',
                    'role'    => 'マーケター・40代',
                    'text'    => 'これまでの経験を上手くまとめられず悩んでいましたが、Resumakeを使って自分のキャリアを客観的に整理できました。面接でも話しやすくなりました。',
                    'rating'  => 4,
                ),
            );
            foreach ($testimonials as $testimonial) :
            ?>
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <span class="star <?php echo $i <= $testimonial['rating'] ? 'star-filled' : ''; ?>">★</span>
                    <?php endfor; ?>
                </div>
                <blockquote class="testimonial-text">
                    <?php echo esc_html($testimonial['text']); ?>
                </blockquote>
                <div class="testimonial-author">
                    <span class="testimonial-name"><?php echo esc_html($testimonial['name']); ?></span>
                    <span class="testimonial-role"><?php echo esc_html($testimonial['role']); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FAQセクション -->
<section class="lp-section lp-faq">
    <div class="container">
        <header class="lp-section-header">
            <span class="lp-section-label"><?php esc_html_e('FAQ', 'pout-theme'); ?></span>
            <h2 class="lp-section-title"><?php esc_html_e('よくあるご質問', 'pout-theme'); ?></h2>
        </header>
        <div class="faq-list">
            <?php
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
            foreach ($faqs as $index => $faq) :
            ?>
            <details class="faq-item">
                <summary class="faq-question">
                    <span><?php echo esc_html($faq['question']); ?></span>
                    <svg class="faq-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6"></path>
                    </svg>
                </summary>
                <div class="faq-answer">
                    <p><?php echo esc_html($faq['answer']); ?></p>
                </div>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 最終CTAセクション -->
<section id="signup" class="lp-section lp-final-cta">
    <div class="container">
        <div class="final-cta-box">
            <h2 class="final-cta-title">
                <?php esc_html_e('今すぐ無料で始めましょう', 'pout-theme'); ?>
            </h2>
            <p class="final-cta-description">
                <?php esc_html_e('5分後には、あなただけの職務経歴書が完成しています。', 'pout-theme'); ?>
            </p>
            <form class="signup-form" action="#" method="post">
                <div class="signup-form-group">
                    <input type="email" name="email" class="signup-input" placeholder="<?php esc_attr_e('メールアドレスを入力', 'pout-theme'); ?>" required>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <?php esc_html_e('無料で始める', 'pout-theme'); ?>
                    </button>
                </div>
                <p class="signup-note">
                    <?php esc_html_e('登録することで、利用規約とプライバシーポリシーに同意したものとみなされます。', 'pout-theme'); ?>
                </p>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>
