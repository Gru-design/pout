<?php
/**
 * Template Name: MEDECHECK LP
 *
 * MEDECHECK - プロの目による書類添削サービスLP
 * "AIじゃない。目で、チェック。"
 *
 * @package Pout_Theme
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<!-- MEDECHECK LP Hero -->
<section class="medecheck-hero">
    <div class="container">
        <div class="medecheck-hero-inner">
            <div class="medecheck-hero-content">
                <span class="medecheck-hero-badge">
                    <span class="badge-icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </span>
                    <?php esc_html_e('プロの目でチェック', 'pout-theme'); ?>
                </span>
                <h1 class="medecheck-hero-title">
                    <span class="title-catchphrase">AIじゃない。</span>
                    <span class="title-main">目で、<strong>チェック。</strong></span>
                </h1>
                <p class="medecheck-hero-description">
                    <?php esc_html_e('15年以上の採用・人事経験を持つプロフェッショナルが、あなたの履歴書・職務経歴書・エントリーシートを徹底添削。AIには見抜けない「伝わる表現」へ。', 'pout-theme'); ?>
                </p>
                <div class="medecheck-hero-stats">
                    <div class="hero-stat">
                        <span class="stat-number">3,000<small>+</small></span>
                        <span class="stat-label"><?php esc_html_e('添削実績', 'pout-theme'); ?></span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number">98<small>%</small></span>
                        <span class="stat-label"><?php esc_html_e('満足度', 'pout-theme'); ?></span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number">24<small>h</small></span>
                        <span class="stat-label"><?php esc_html_e('平均返却', 'pout-theme'); ?></span>
                    </div>
                </div>
                <div class="medecheck-hero-actions">
                    <a href="#pricing" class="btn btn-gold btn-xl">
                        <?php esc_html_e('料金プランを見る', 'pout-theme'); ?>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="#how-it-works" class="btn btn-outline-light btn-xl">
                        <?php esc_html_e('ご利用の流れ', 'pout-theme'); ?>
                    </a>
                </div>
                <p class="medecheck-hero-note">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22,4 12,14.01 9,11.01"></polyline>
                    </svg>
                    <?php esc_html_e('初回限定50%OFF | 最短即日納品対応', 'pout-theme'); ?>
                </p>
            </div>
            <div class="medecheck-hero-visual">
                <div class="hero-visual-card">
                    <div class="visual-card-header">
                        <span class="visual-card-dots" aria-hidden="true">
                            <span></span><span></span><span></span>
                        </span>
                        <span class="visual-card-title"><?php esc_html_e('添削レポート', 'pout-theme'); ?></span>
                    </div>
                    <div class="visual-card-body">
                        <div class="review-item review-highlight">
                            <span class="review-mark" aria-hidden="true">!</span>
                            <span class="review-text"><?php esc_html_e('「〜しました」の繰り返しを改善', 'pout-theme'); ?></span>
                        </div>
                        <div class="review-item review-suggestion">
                            <span class="review-mark" aria-hidden="true">+</span>
                            <span class="review-text"><?php esc_html_e('具体的な数値を追加すると説得力UP', 'pout-theme'); ?></span>
                        </div>
                        <div class="review-item review-positive">
                            <span class="review-mark" aria-hidden="true">✓</span>
                            <span class="review-text"><?php esc_html_e('志望動機の構成が明確で好印象', 'pout-theme'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="medecheck-hero-bg" aria-hidden="true">
        <div class="hero-bg-gradient"></div>
        <div class="hero-bg-pattern"></div>
    </div>
</section>

<!-- なぜ人の目が必要なのか -->
<section class="medecheck-section medecheck-why">
    <div class="container">
        <header class="section-header section-header-center">
            <span class="section-label"><?php esc_html_e('Why Human Review?', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('なぜ「人の目」が必要なのか', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('AIは文法をチェックできます。でも、「この人と働きたい」と思わせる表現は、人にしか分かりません。', 'pout-theme'); ?>
            </p>
        </header>
        <div class="why-comparison">
            <div class="why-card why-card-ai">
                <div class="why-card-header">
                    <span class="why-card-icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <circle cx="15.5" cy="8.5" r="1.5"></circle>
                            <path d="M9 15h6"></path>
                        </svg>
                    </span>
                    <h3 class="why-card-title"><?php esc_html_e('AI添削', 'pout-theme'); ?></h3>
                </div>
                <ul class="why-card-list">
                    <li class="why-item why-item-neutral">
                        <span class="why-icon" aria-hidden="true">○</span>
                        <?php esc_html_e('文法・誤字脱字のチェック', 'pout-theme'); ?>
                    </li>
                    <li class="why-item why-item-neutral">
                        <span class="why-icon" aria-hidden="true">○</span>
                        <?php esc_html_e('定型的な言い換え提案', 'pout-theme'); ?>
                    </li>
                    <li class="why-item why-item-negative">
                        <span class="why-icon" aria-hidden="true">×</span>
                        <?php esc_html_e('文脈に合った表現の判断', 'pout-theme'); ?>
                    </li>
                    <li class="why-item why-item-negative">
                        <span class="why-icon" aria-hidden="true">×</span>
                        <?php esc_html_e('業界特有のニュアンス理解', 'pout-theme'); ?>
                    </li>
                    <li class="why-item why-item-negative">
                        <span class="why-icon" aria-hidden="true">×</span>
                        <?php esc_html_e('採用担当者の視点でのアドバイス', 'pout-theme'); ?>
                    </li>
                </ul>
            </div>
            <div class="why-card why-card-human why-card-featured">
                <span class="why-card-badge"><?php esc_html_e('MEDECHECK', 'pout-theme'); ?></span>
                <div class="why-card-header">
                    <span class="why-card-icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </span>
                    <h3 class="why-card-title"><?php esc_html_e('プロの目', 'pout-theme'); ?></h3>
                </div>
                <ul class="why-card-list">
                    <li class="why-item why-item-positive">
                        <span class="why-icon" aria-hidden="true">◎</span>
                        <?php esc_html_e('文法・誤字脱字のチェック', 'pout-theme'); ?>
                    </li>
                    <li class="why-item why-item-positive">
                        <span class="why-icon" aria-hidden="true">◎</span>
                        <?php esc_html_e('あなたの強みを引き出す表現提案', 'pout-theme'); ?>
                    </li>
                    <li class="why-item why-item-positive">
                        <span class="why-icon" aria-hidden="true">◎</span>
                        <?php esc_html_e('業界・職種に合わせたアドバイス', 'pout-theme'); ?>
                    </li>
                    <li class="why-item why-item-positive">
                        <span class="why-icon" aria-hidden="true">◎</span>
                        <?php esc_html_e('採用担当者が求めるポイント解説', 'pout-theme'); ?>
                    </li>
                    <li class="why-item why-item-positive">
                        <span class="why-icon" aria-hidden="true">◎</span>
                        <?php esc_html_e('面接対策に繋がる書類づくり', 'pout-theme'); ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- サービス内容 -->
<section class="medecheck-section medecheck-services">
    <div class="container">
        <header class="section-header section-header-center">
            <span class="section-label"><?php esc_html_e('Services', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('添削サービス一覧', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('就職・転職活動に必要なすべての書類を、プロの目でチェックします。', 'pout-theme'); ?>
            </p>
        </header>
        <div class="services-grid">
            <?php
            $services = array(
                array(
                    'icon'        => 'file-text',
                    'title'       => '履歴書添削',
                    'description' => '基本情報の書き方から、志望動機・自己PRまで。第一印象を決める履歴書を完璧に仕上げます。',
                    'features'    => array('フォーマット最適化', '写真アドバイス', '志望動機強化'),
                    'price'       => '¥3,980〜',
                ),
                array(
                    'icon'        => 'briefcase',
                    'title'       => '職務経歴書添削',
                    'description' => 'あなたの経験・スキルを最大限にアピール。採用担当者の心を掴む職務経歴書を作成します。',
                    'features'    => array('実績の数値化', '強み明確化', '業界別最適化'),
                    'price'       => '¥4,980〜',
                ),
                array(
                    'icon'        => 'edit-3',
                    'title'       => 'エントリーシート添削',
                    'description' => '新卒採用で重要なES。設問の意図を読み解き、あなたらしさが伝わる回答へ導きます。',
                    'features'    => array('設問分析', '構成アドバイス', '企業研究サポート'),
                    'price'       => '¥2,980〜',
                ),
                array(
                    'icon'        => 'mail',
                    'title'       => 'カバーレター添削',
                    'description' => '外資系企業向けのカバーレターもお任せください。英文添削も対応しています。',
                    'features'    => array('日本語/英語対応', 'フォーマット指導', '熱意の伝え方'),
                    'price'       => '¥3,980〜',
                ),
            );
            foreach ($services as $service) :
            ?>
            <article class="service-card">
                <div class="service-card-icon" aria-hidden="true">
                    <?php echo pout_get_svg_icon($service['icon']); ?>
                </div>
                <h3 class="service-card-title"><?php echo esc_html($service['title']); ?></h3>
                <p class="service-card-description"><?php echo esc_html($service['description']); ?></p>
                <ul class="service-card-features">
                    <?php foreach ($service['features'] as $feature) : ?>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <polyline points="20,6 9,17 4,12"></polyline>
                        </svg>
                        <?php echo esc_html($feature); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="service-card-footer">
                    <span class="service-card-price"><?php echo esc_html($service['price']); ?></span>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <div class="services-cta">
            <a href="#pricing" class="btn btn-primary btn-lg">
                <?php esc_html_e('詳しい料金を見る', 'pout-theme'); ?>
            </a>
        </div>
    </div>
</section>

<!-- ご利用の流れ -->
<section id="how-it-works" class="medecheck-section medecheck-steps">
    <div class="container">
        <header class="section-header section-header-center">
            <span class="section-label"><?php esc_html_e('How it works', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('ご利用の流れ', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('シンプルな3ステップで、プロの添削が受けられます。', 'pout-theme'); ?>
            </p>
        </header>
        <div class="steps-timeline">
            <?php
            $steps = array(
                array(
                    'step'        => '01',
                    'title'       => '書類をアップロード',
                    'description' => 'お申し込み後、添削してほしい書類（PDF・Word・画像）をアップロード。志望業界や企業があれば、あわせてお伝えください。',
                    'icon'        => 'upload',
                ),
                array(
                    'step'        => '02',
                    'title'       => 'プロが徹底添削',
                    'description' => '経験豊富なキャリアアドバイザーが、採用担当者の視点であなたの書類を丁寧にチェック。改善点と具体的なアドバイスをまとめます。',
                    'icon'        => 'eye',
                ),
                array(
                    'step'        => '03',
                    'title'       => '添削結果をお届け',
                    'description' => '24時間以内（平均）に添削レポートをお届け。修正例と解説付きで、すぐに書類をブラッシュアップできます。',
                    'icon'        => 'check-circle',
                ),
            );
            foreach ($steps as $index => $step) :
            ?>
            <div class="step-item">
                <div class="step-marker">
                    <span class="step-number"><?php echo esc_html($step['step']); ?></span>
                    <span class="step-icon" aria-hidden="true">
                        <?php echo pout_get_svg_icon($step['icon']); ?>
                    </span>
                </div>
                <div class="step-content">
                    <h3 class="step-title"><?php echo esc_html($step['title']); ?></h3>
                    <p class="step-description"><?php echo esc_html($step['description']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="steps-note">
            <p>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <?php esc_html_e('お急ぎの方は「特急プラン」をご利用ください。最短6時間で納品いたします。', 'pout-theme'); ?>
            </p>
        </div>
    </div>
</section>

<!-- 添削者紹介 -->
<section class="medecheck-section medecheck-reviewers">
    <div class="container">
        <header class="section-header section-header-center">
            <span class="section-label"><?php esc_html_e('Our Reviewers', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('経験豊富なプロが担当', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('採用の現場を知り尽くしたキャリアのプロフェッショナルが、あなたの書類を添削します。', 'pout-theme'); ?>
            </p>
        </header>
        <div class="reviewers-grid">
            <?php
            $reviewers = array(
                array(
                    'name'       => '山田 美咲',
                    'title'      => 'シニアキャリアアドバイザー',
                    'experience' => '人事・採用経験15年',
                    'specialty'  => 'IT・Web業界',
                    'message'    => '書類選考を通過するコツは、「自分の言葉」で語ること。テンプレートに頼らない、あなたらしい表現を一緒に見つけましょう。',
                ),
                array(
                    'name'       => '佐藤 健一',
                    'title'      => 'キャリアコンサルタント（国家資格）',
                    'experience' => '転職支援実績2,000名以上',
                    'specialty'  => '金融・コンサル業界',
                    'message'    => '転職回数が多い、ブランクがある…そんな不安も、書き方次第で強みに変えられます。',
                ),
                array(
                    'name'       => '田中 裕子',
                    'title'      => '新卒採用スペシャリスト',
                    'experience'  => '大手企業採用担当10年',
                    'specialty'  => '新卒ES・面接対策',
                    'message'    => 'ESで見ているのは「完璧な文章」ではありません。あなたの人柄が伝わる書類を一緒に作りましょう。',
                ),
            );
            foreach ($reviewers as $reviewer) :
            ?>
            <article class="reviewer-card">
                <div class="reviewer-avatar">
                    <span class="avatar-placeholder" aria-hidden="true">
                        <?php echo esc_html(mb_substr($reviewer['name'], 0, 1)); ?>
                    </span>
                </div>
                <div class="reviewer-info">
                    <h3 class="reviewer-name"><?php echo esc_html($reviewer['name']); ?></h3>
                    <p class="reviewer-title"><?php echo esc_html($reviewer['title']); ?></p>
                    <div class="reviewer-meta">
                        <span class="reviewer-experience"><?php echo esc_html($reviewer['experience']); ?></span>
                        <span class="reviewer-specialty"><?php echo esc_html($reviewer['specialty']); ?></span>
                    </div>
                </div>
                <blockquote class="reviewer-message">
                    <p><?php echo esc_html($reviewer['message']); ?></p>
                </blockquote>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- お客様の声 -->
<section class="medecheck-section medecheck-testimonials">
    <div class="container">
        <header class="section-header section-header-center">
            <span class="section-label"><?php esc_html_e('Testimonials', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('ご利用者の声', 'pout-theme'); ?></h2>
        </header>
        <div class="testimonials-slider">
            <?php
            $testimonials = array(
                array(
                    'name'      => 'K.T さん',
                    'attribute' => '20代・エンジニア転職',
                    'rating'    => 5,
                    'title'     => '書類選考通過率が2倍に',
                    'text'      => '自分では気づかなかった「強み」を見つけてもらえました。具体的な数字を入れるアドバイスが特に役立ち、書類選考の通過率が格段に上がりました。',
                    'result'    => '内定獲得',
                ),
                array(
                    'name'      => 'M.S さん',
                    'attribute' => '30代・キャリアチェンジ',
                    'rating'    => 5,
                    'title'     => '未経験転職でも自信を持てた',
                    'text'      => '異業種への転職で、どう経験をアピールすればいいか悩んでいました。前職の経験を新しい業界でどう活かせるか、丁寧に言語化してもらえて感謝しています。',
                    'result'    => '年収UP転職成功',
                ),
                array(
                    'name'      => 'A.Y さん',
                    'attribute' => '新卒・就活生',
                    'rating'    => 5,
                    'title'     => 'ES通過率100%達成',
                    'text'      => '何度書き直してもESが通らず落ち込んでいました。添削後は、面接官に「ESが印象的だった」と言われるように。志望企業すべてのES審査を通過できました！',
                    'result'    => '第一志望内定',
                ),
            );
            foreach ($testimonials as $testimonial) :
            ?>
            <article class="testimonial-card testimonial-card-detailed">
                <div class="testimonial-header">
                    <div class="testimonial-rating" aria-label="<?php echo esc_attr(sprintf(__('評価: %d点', 'pout-theme'), $testimonial['rating'])); ?>">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <span class="star <?php echo $i <= $testimonial['rating'] ? 'star-filled' : ''; ?>" aria-hidden="true">★</span>
                        <?php endfor; ?>
                    </div>
                    <span class="testimonial-result"><?php echo esc_html($testimonial['result']); ?></span>
                </div>
                <h3 class="testimonial-title"><?php echo esc_html($testimonial['title']); ?></h3>
                <blockquote class="testimonial-text">
                    <p><?php echo esc_html($testimonial['text']); ?></p>
                </blockquote>
                <footer class="testimonial-footer">
                    <span class="testimonial-name"><?php echo esc_html($testimonial['name']); ?></span>
                    <span class="testimonial-attribute"><?php echo esc_html($testimonial['attribute']); ?></span>
                </footer>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 料金プラン -->
<section id="pricing" class="medecheck-section medecheck-pricing">
    <div class="container">
        <header class="section-header section-header-center">
            <span class="section-label"><?php esc_html_e('Pricing', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('料金プラン', 'pout-theme'); ?></h2>
            <p class="section-description">
                <?php esc_html_e('すべてのプランで、プロによる丁寧な添削とアドバイスを提供します。', 'pout-theme'); ?>
            </p>
        </header>
        <div class="pricing-grid">
            <!-- ライトプラン -->
            <article class="pricing-card">
                <div class="pricing-header">
                    <h3 class="pricing-name"><?php esc_html_e('ライト', 'pout-theme'); ?></h3>
                    <p class="pricing-description"><?php esc_html_e('まずは試してみたい方に', 'pout-theme'); ?></p>
                    <div class="pricing-price">
                        <span class="price-amount">¥2,980</span>
                        <span class="price-unit">/1書類</span>
                    </div>
                </div>
                <ul class="pricing-features">
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('添削レポート', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('修正例の提示', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('48時間以内納品', 'pout-theme'); ?>
                    </li>
                    <li class="pricing-feature-disabled">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        <?php esc_html_e('再添削', 'pout-theme'); ?>
                    </li>
                    <li class="pricing-feature-disabled">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        <?php esc_html_e('質問対応', 'pout-theme'); ?>
                    </li>
                </ul>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>?plan=light" class="btn btn-outline btn-block">
                    <?php esc_html_e('申し込む', 'pout-theme'); ?>
                </a>
            </article>

            <!-- スタンダードプラン -->
            <article class="pricing-card pricing-card-featured">
                <span class="pricing-badge"><?php esc_html_e('人気No.1', 'pout-theme'); ?></span>
                <div class="pricing-header">
                    <h3 class="pricing-name"><?php esc_html_e('スタンダード', 'pout-theme'); ?></h3>
                    <p class="pricing-description"><?php esc_html_e('しっかり添削してほしい方に', 'pout-theme'); ?></p>
                    <div class="pricing-price">
                        <span class="price-original">¥5,980</span>
                        <span class="price-amount">¥4,980</span>
                        <span class="price-unit">/1書類</span>
                    </div>
                </div>
                <ul class="pricing-features">
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('添削レポート', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('修正例の提示', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('24時間以内納品', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('再添削1回無料', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('質問対応（1往復）', 'pout-theme'); ?>
                    </li>
                </ul>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>?plan=standard" class="btn btn-gold btn-block">
                    <?php esc_html_e('申し込む', 'pout-theme'); ?>
                </a>
            </article>

            <!-- プレミアムプラン -->
            <article class="pricing-card">
                <div class="pricing-header">
                    <h3 class="pricing-name"><?php esc_html_e('プレミアム', 'pout-theme'); ?></h3>
                    <p class="pricing-description"><?php esc_html_e('徹底的にサポートしてほしい方に', 'pout-theme'); ?></p>
                    <div class="pricing-price">
                        <span class="price-amount">¥9,800</span>
                        <span class="price-unit">/1書類</span>
                    </div>
                </div>
                <ul class="pricing-features">
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('添削レポート', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('修正例の提示', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('最短6時間納品', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('再添削3回まで無料', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('質問対応（無制限）', 'pout-theme'); ?>
                    </li>
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                        <?php esc_html_e('面接対策アドバイス付き', 'pout-theme'); ?>
                    </li>
                </ul>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>?plan=premium" class="btn btn-outline btn-block">
                    <?php esc_html_e('申し込む', 'pout-theme'); ?>
                </a>
            </article>
        </div>

        <!-- セットプラン -->
        <div class="pricing-bundle">
            <div class="pricing-bundle-inner">
                <div class="pricing-bundle-content">
                    <span class="pricing-bundle-badge"><?php esc_html_e('お得なセット', 'pout-theme'); ?></span>
                    <h3 class="pricing-bundle-title"><?php esc_html_e('転職フルサポートパック', 'pout-theme'); ?></h3>
                    <p class="pricing-bundle-description">
                        <?php esc_html_e('履歴書 + 職務経歴書 + カバーレターの3点セット。転職活動に必要な書類をまとめて添削。', 'pout-theme'); ?>
                    </p>
                </div>
                <div class="pricing-bundle-price">
                    <span class="price-original">¥12,940</span>
                    <span class="price-amount">¥9,800</span>
                    <span class="price-discount"><?php esc_html_e('24%OFF', 'pout-theme'); ?></span>
                </div>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>?plan=bundle" class="btn btn-primary">
                    <?php esc_html_e('セットで申し込む', 'pout-theme'); ?>
                </a>
            </div>
        </div>

        <p class="pricing-note">
            <?php esc_html_e('※ 初回ご利用の方は全プラン50%OFFでご利用いただけます。お支払いはクレジットカード・銀行振込に対応。', 'pout-theme'); ?>
        </p>
    </div>
</section>

<!-- FAQ -->
<section class="medecheck-section medecheck-faq">
    <div class="container">
        <header class="section-header section-header-center">
            <span class="section-label"><?php esc_html_e('FAQ', 'pout-theme'); ?></span>
            <h2 class="section-title"><?php esc_html_e('よくあるご質問', 'pout-theme'); ?></h2>
        </header>
        <div class="faq-list">
            <?php
            $faqs = array(
                array(
                    'question' => '添削にはどのくらい時間がかかりますか？',
                    'answer'   => 'スタンダードプランで24時間以内、ライトプランで48時間以内に納品いたします。プレミアムプランでは最短6時間での特急対応も可能です。お急ぎの場合はお申し込み時にご相談ください。',
                ),
                array(
                    'question' => 'どんな形式のファイルに対応していますか？',
                    'answer'   => 'PDF、Word（.doc, .docx）、画像（JPG, PNG）に対応しています。手書きの書類も画像でお送りいただければ添削可能です。',
                ),
                array(
                    'question' => '添削後に質問することはできますか？',
                    'answer'   => 'スタンダードプランでは1往復、プレミアムプランでは無制限で質問対応いたします。ライトプランには質問対応は含まれませんが、追加料金で対応可能です。',
                ),
                array(
                    'question' => '新卒のESと転職の職務経歴書、両方対応していますか？',
                    'answer'   => 'はい、両方対応しています。新卒採用向けのエントリーシート、履歴書から、転職活動向けの職務経歴書、カバーレターまで幅広く添削いたします。',
                ),
                array(
                    'question' => '英語の書類も添削できますか？',
                    'answer'   => 'はい、英文レジュメ・カバーレターの添削も対応しています。外資系企業への応募に適した表現・フォーマットでアドバイスいたします。',
                ),
                array(
                    'question' => 'キャンセル・返金はできますか？',
                    'answer'   => '添削作業開始前であれば全額返金いたします。添削開始後のキャンセルはお受けできませんが、添削内容にご満足いただけない場合は無料で再添削いたします。',
                ),
            );
            foreach ($faqs as $faq) :
            ?>
            <details class="faq-item">
                <summary class="faq-question">
                    <span><?php echo esc_html($faq['question']); ?></span>
                    <svg class="faq-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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

<!-- 最終CTA -->
<section class="medecheck-section medecheck-final-cta">
    <div class="container">
        <div class="final-cta-box">
            <div class="final-cta-content">
                <span class="final-cta-label"><?php esc_html_e('AIじゃない。目で、チェック。', 'pout-theme'); ?></span>
                <h2 class="final-cta-title">
                    <?php esc_html_e('あなたの書類、プロの目で見てみませんか？', 'pout-theme'); ?>
                </h2>
                <p class="final-cta-description">
                    <?php esc_html_e('書類選考で落ちる原因は、意外と小さなところにあるかもしれません。一度、プロの視点でチェックしてみませんか？', 'pout-theme'); ?>
                </p>
                <div class="final-cta-features">
                    <span class="cta-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22,4 12,14.01 9,11.01"></polyline>
                        </svg>
                        <?php esc_html_e('初回50%OFF', 'pout-theme'); ?>
                    </span>
                    <span class="cta-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22,4 12,14.01 9,11.01"></polyline>
                        </svg>
                        <?php esc_html_e('最短即日納品', 'pout-theme'); ?>
                    </span>
                    <span class="cta-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22,4 12,14.01 9,11.01"></polyline>
                        </svg>
                        <?php esc_html_e('満足保証', 'pout-theme'); ?>
                    </span>
                </div>
                <div class="final-cta-actions">
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>?service=medecheck" class="btn btn-gold btn-xl">
                        <?php esc_html_e('今すぐ添削を依頼する', 'pout-theme'); ?>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <p class="final-cta-note">
                    <?php esc_html_e('ご不明点があれば、お気軽にお問い合わせください。', 'pout-theme'); ?>
                </p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
