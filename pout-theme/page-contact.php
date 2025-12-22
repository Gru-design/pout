<?php
/**
 * Template Name: お問い合わせ
 *
 * セキュアなお問い合わせページ
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// フォーム送信処理の結果を取得
$form_result = isset($_GET['contact']) ? sanitize_text_field($_GET['contact']) : '';
?>

<article class="page-contact">
    <!-- ページヘッダー -->
    <header class="page-header">
        <div class="container">
            <?php pout_breadcrumb(); ?>
            <h1 class="page-title"><?php the_title(); ?></h1>
            <p class="page-description">
                <?php esc_html_e('お気軽にお問い合わせください。通常2営業日以内にご返信いたします。', 'pout-theme'); ?>
            </p>
        </div>
    </header>

    <div class="contact-content">
        <div class="container">
            <div class="contact-grid">
                <!-- お問い合わせフォーム -->
                <div class="contact-form-wrapper">
                    <?php if ($form_result === 'success') : ?>
                    <div class="alert alert-success">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                            <polyline points="22,4 12,14.01 9,11.01"></polyline>
                        </svg>
                        <div>
                            <strong><?php esc_html_e('送信完了', 'pout-theme'); ?></strong>
                            <p><?php esc_html_e('お問い合わせを受け付けました。担当者より折り返しご連絡いたします。', 'pout-theme'); ?></p>
                        </div>
                    </div>
                    <?php elseif ($form_result === 'error') : ?>
                    <div class="alert alert-error">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        <div>
                            <strong><?php esc_html_e('エラーが発生しました', 'pout-theme'); ?></strong>
                            <p><?php esc_html_e('申し訳ございません。時間をおいて再度お試しください。', 'pout-theme'); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <form id="contact-form" class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
                        <?php wp_nonce_field('pout_contact_form', 'pout_contact_nonce'); ?>
                        <input type="hidden" name="action" value="pout_contact_submit">

                        <!-- ハニーポット（スパム対策） -->
                        <div class="hp-field" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact-name" class="form-label required">
                                    <?php esc_html_e('お名前', 'pout-theme'); ?>
                                </label>
                                <input type="text" id="contact-name" name="contact_name" class="form-input" required
                                       placeholder="<?php esc_attr_e('山田 太郎', 'pout-theme'); ?>"
                                       maxlength="100">
                                <span class="form-error" role="alert"></span>
                            </div>

                            <div class="form-group">
                                <label for="contact-company" class="form-label">
                                    <?php esc_html_e('会社名', 'pout-theme'); ?>
                                </label>
                                <input type="text" id="contact-company" name="contact_company" class="form-input"
                                       placeholder="<?php esc_attr_e('株式会社〇〇', 'pout-theme'); ?>"
                                       maxlength="100">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact-email" class="form-label required">
                                    <?php esc_html_e('メールアドレス', 'pout-theme'); ?>
                                </label>
                                <input type="email" id="contact-email" name="contact_email" class="form-input" required
                                       placeholder="example@example.com"
                                       maxlength="255">
                                <span class="form-error" role="alert"></span>
                            </div>

                            <div class="form-group">
                                <label for="contact-phone" class="form-label">
                                    <?php esc_html_e('電話番号', 'pout-theme'); ?>
                                </label>
                                <input type="tel" id="contact-phone" name="contact_phone" class="form-input"
                                       placeholder="03-1234-5678"
                                       pattern="[0-9\-]+"
                                       maxlength="20">
                                <span class="form-error" role="alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact-category" class="form-label required">
                                <?php esc_html_e('お問い合わせ種別', 'pout-theme'); ?>
                            </label>
                            <select id="contact-category" name="contact_category" class="form-select" required>
                                <option value=""><?php esc_html_e('選択してください', 'pout-theme'); ?></option>
                                <option value="service"><?php esc_html_e('サービスについて', 'pout-theme'); ?></option>
                                <option value="quote"><?php esc_html_e('お見積り依頼', 'pout-theme'); ?></option>
                                <option value="partnership"><?php esc_html_e('協業・提携について', 'pout-theme'); ?></option>
                                <option value="recruit"><?php esc_html_e('採用について', 'pout-theme'); ?></option>
                                <option value="media"><?php esc_html_e('取材・メディア掲載', 'pout-theme'); ?></option>
                                <option value="other"><?php esc_html_e('その他', 'pout-theme'); ?></option>
                            </select>
                            <span class="form-error" role="alert"></span>
                        </div>

                        <div class="form-group">
                            <label for="contact-message" class="form-label required">
                                <?php esc_html_e('お問い合わせ内容', 'pout-theme'); ?>
                            </label>
                            <textarea id="contact-message" name="contact_message" class="form-textarea" required
                                      rows="6"
                                      placeholder="<?php esc_attr_e('お問い合わせ内容をご記入ください', 'pout-theme'); ?>"
                                      maxlength="5000"></textarea>
                            <div class="form-textarea-counter">
                                <span class="char-count">0</span> / 5000
                            </div>
                            <span class="form-error" role="alert"></span>
                        </div>

                        <div class="form-group form-group-checkbox">
                            <label class="form-checkbox">
                                <input type="checkbox" name="contact_privacy" required>
                                <span class="checkbox-mark"></span>
                                <span class="checkbox-label">
                                    <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" target="_blank" rel="noopener">
                                        <?php esc_html_e('プライバシーポリシー', 'pout-theme'); ?>
                                    </a>
                                    <?php esc_html_e('に同意する', 'pout-theme'); ?>
                                </span>
                            </label>
                            <span class="form-error" role="alert"></span>
                        </div>

                        <div class="form-submit">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" id="contact-submit">
                                <span class="btn-text"><?php esc_html_e('送信する', 'pout-theme'); ?></span>
                                <span class="btn-loading" aria-hidden="true">
                                    <svg class="spinner" width="20" height="20" viewBox="0 0 24 24">
                                        <circle class="spinner-circle" cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="3"></circle>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- サイドバー情報 -->
                <aside class="contact-sidebar">
                    <div class="contact-info-card">
                        <h2 class="contact-info-title"><?php esc_html_e('お問い合わせ先', 'pout-theme'); ?></h2>

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div class="contact-info-content">
                                <span class="contact-info-label"><?php esc_html_e('メール', 'pout-theme'); ?></span>
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('pout_email', 'info@example.com')); ?>">
                                    <?php echo esc_html(get_theme_mod('pout_email', 'info@example.com')); ?>
                                </a>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path>
                                </svg>
                            </div>
                            <div class="contact-info-content">
                                <span class="contact-info-label"><?php esc_html_e('電話', 'pout-theme'); ?></span>
                                <a href="tel:<?php echo esc_attr(get_theme_mod('pout_phone', '03-0000-0000')); ?>">
                                    <?php echo esc_html(get_theme_mod('pout_phone', '03-0000-0000')); ?>
                                </a>
                                <span class="contact-info-note"><?php esc_html_e('平日 10:00〜18:00', 'pout-theme'); ?></span>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="contact-info-content">
                                <span class="contact-info-label"><?php esc_html_e('所在地', 'pout-theme'); ?></span>
                                <address>
                                    <?php echo nl2br(esc_html(get_theme_mod('pout_address', "〒100-0001\n東京都千代田区千代田1-1"))); ?>
                                </address>
                            </div>
                        </div>
                    </div>

                    <!-- よくある質問へのリンク -->
                    <div class="contact-faq-link">
                        <h3><?php esc_html_e('お問い合わせの前に', 'pout-theme'); ?></h3>
                        <p><?php esc_html_e('よくあるご質問をご確認ください。', 'pout-theme'); ?></p>
                        <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="btn btn-outline">
                            <?php esc_html_e('よくある質問を見る', 'pout-theme'); ?>
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</article>

<?php get_footer(); ?>
