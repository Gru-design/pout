<?php
/**
 * Template Name: お問い合わせ
 *
 * セキュアなお問い合わせページ
 * Pout Consulting / MEDECHECK
 *
 * @package Pout_Theme
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// フォーム送信処理の結果を取得
$form_result = isset($_GET['contact']) ? sanitize_text_field($_GET['contact']) : '';

// URLパラメータからサービス・プランを取得
$service_param = isset($_GET['service']) ? sanitize_text_field($_GET['service']) : '';
$plan_param = isset($_GET['plan']) ? sanitize_text_field($_GET['plan']) : '';

// プリセレクト用のカテゴリを決定
$preselect_category = '';
if ($service_param === 'medecheck' || !empty($plan_param)) {
    $preselect_category = 'medecheck';
}

// プラン名の日本語変換
$plan_names = array(
    'light'    => 'ライトプラン',
    'standard' => 'スタンダードプラン',
    'premium'  => 'プレミアムプラン',
    'bundle'   => '転職フルサポートパック',
);
$plan_display = isset($plan_names[$plan_param]) ? $plan_names[$plan_param] : '';
?>

<article class="page-contact">
    <!-- ページヘッダー -->
    <header class="page-header page-header-contact">
        <div class="container">
            <?php if (function_exists('pout_breadcrumb')) : ?>
                <?php pout_breadcrumb(); ?>
            <?php endif; ?>
            <h1 class="page-title"><?php the_title(); ?></h1>
            <p class="page-description">
                <?php if ($service_param === 'medecheck' || !empty($plan_param)) : ?>
                    <?php esc_html_e('MEDECHECKサービスへのお申し込み・お問い合わせはこちらから。', 'pout-theme'); ?>
                <?php else : ?>
                    <?php esc_html_e('お気軽にお問い合わせください。通常2営業日以内にご返信いたします。', 'pout-theme'); ?>
                <?php endif; ?>
            </p>
        </div>
        <div class="page-header-bg" aria-hidden="true"></div>
    </header>

    <div class="contact-content">
        <div class="container">
            <div class="contact-grid">
                <!-- お問い合わせフォーム -->
                <div class="contact-form-wrapper">
                    <?php if ($form_result === 'success') : ?>
                    <div class="alert alert-success" role="alert">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                            <polyline points="22,4 12,14.01 9,11.01"></polyline>
                        </svg>
                        <div>
                            <strong><?php esc_html_e('送信完了', 'pout-theme'); ?></strong>
                            <p><?php esc_html_e('お問い合わせを受け付けました。担当者より折り返しご連絡いたします。', 'pout-theme'); ?></p>
                        </div>
                    </div>
                    <?php elseif ($form_result === 'error') : ?>
                    <div class="alert alert-error" role="alert">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
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

                    <?php if (!empty($plan_display)) : ?>
                    <div class="contact-plan-notice">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <span>
                            <?php echo esc_html(sprintf(__('MEDECHECK %s のお申し込み', 'pout-theme'), $plan_display)); ?>
                        </span>
                    </div>
                    <?php endif; ?>

                    <form id="contact-form" class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" novalidate>
                        <?php wp_nonce_field('pout_contact_form', 'pout_contact_nonce'); ?>
                        <input type="hidden" name="action" value="pout_contact_submit">
                        <?php if (!empty($plan_param)) : ?>
                        <input type="hidden" name="contact_plan" value="<?php echo esc_attr($plan_param); ?>">
                        <?php endif; ?>

                        <!-- ハニーポット（スパム対策） -->
                        <div class="hp-field" aria-hidden="true" style="position:absolute;left:-9999px;">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        <fieldset class="form-fieldset">
                            <legend class="form-legend">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <?php esc_html_e('お客様情報', 'pout-theme'); ?>
                            </legend>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact-name" class="form-label required">
                                        <?php esc_html_e('お名前', 'pout-theme'); ?>
                                    </label>
                                    <input type="text" id="contact-name" name="contact_name" class="form-input" required
                                           placeholder="<?php esc_attr_e('山田 太郎', 'pout-theme'); ?>"
                                           maxlength="100"
                                           autocomplete="name">
                                    <span class="form-error" role="alert" aria-live="polite"></span>
                                </div>

                                <div class="form-group">
                                    <label for="contact-company" class="form-label">
                                        <?php esc_html_e('会社名', 'pout-theme'); ?>
                                        <span class="form-label-optional"><?php esc_html_e('（任意）', 'pout-theme'); ?></span>
                                    </label>
                                    <input type="text" id="contact-company" name="contact_company" class="form-input"
                                           placeholder="<?php esc_attr_e('株式会社〇〇', 'pout-theme'); ?>"
                                           maxlength="100"
                                           autocomplete="organization">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact-email" class="form-label required">
                                        <?php esc_html_e('メールアドレス', 'pout-theme'); ?>
                                    </label>
                                    <input type="email" id="contact-email" name="contact_email" class="form-input" required
                                           placeholder="example@example.com"
                                           maxlength="255"
                                           autocomplete="email">
                                    <span class="form-error" role="alert" aria-live="polite"></span>
                                </div>

                                <div class="form-group">
                                    <label for="contact-phone" class="form-label">
                                        <?php esc_html_e('電話番号', 'pout-theme'); ?>
                                        <span class="form-label-optional"><?php esc_html_e('（任意）', 'pout-theme'); ?></span>
                                    </label>
                                    <input type="tel" id="contact-phone" name="contact_phone" class="form-input"
                                           placeholder="03-1234-5678"
                                           pattern="[0-9\-]+"
                                           maxlength="20"
                                           autocomplete="tel">
                                    <span class="form-error" role="alert" aria-live="polite"></span>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="form-fieldset">
                            <legend class="form-legend">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <?php esc_html_e('お問い合わせ内容', 'pout-theme'); ?>
                            </legend>

                            <div class="form-group">
                                <label for="contact-category" class="form-label required">
                                    <?php esc_html_e('お問い合わせ種別', 'pout-theme'); ?>
                                </label>
                                <select id="contact-category" name="contact_category" class="form-select" required>
                                    <option value=""><?php esc_html_e('選択してください', 'pout-theme'); ?></option>
                                    <option value="medecheck" <?php selected($preselect_category, 'medecheck'); ?>><?php esc_html_e('MEDECHECK（書類添削サービス）', 'pout-theme'); ?></option>
                                    <option value="service"><?php esc_html_e('その他サービスについて', 'pout-theme'); ?></option>
                                    <option value="quote"><?php esc_html_e('お見積り依頼', 'pout-theme'); ?></option>
                                    <option value="partnership"><?php esc_html_e('協業・提携について', 'pout-theme'); ?></option>
                                    <option value="recruit"><?php esc_html_e('採用について', 'pout-theme'); ?></option>
                                    <option value="media"><?php esc_html_e('取材・メディア掲載', 'pout-theme'); ?></option>
                                    <option value="other"><?php esc_html_e('その他', 'pout-theme'); ?></option>
                                </select>
                                <span class="form-error" role="alert" aria-live="polite"></span>
                            </div>

                            <!-- MEDECHECK用追加フィールド -->
                            <div class="form-group form-group-conditional" id="medecheck-fields" style="display: none;">
                                <label for="contact-document-type" class="form-label">
                                    <?php esc_html_e('添削を希望する書類', 'pout-theme'); ?>
                                </label>
                                <div class="form-checkbox-group">
                                    <label class="form-checkbox">
                                        <input type="checkbox" name="contact_document_types[]" value="resume">
                                        <span class="checkbox-mark"></span>
                                        <span class="checkbox-label"><?php esc_html_e('履歴書', 'pout-theme'); ?></span>
                                    </label>
                                    <label class="form-checkbox">
                                        <input type="checkbox" name="contact_document_types[]" value="cv">
                                        <span class="checkbox-mark"></span>
                                        <span class="checkbox-label"><?php esc_html_e('職務経歴書', 'pout-theme'); ?></span>
                                    </label>
                                    <label class="form-checkbox">
                                        <input type="checkbox" name="contact_document_types[]" value="es">
                                        <span class="checkbox-mark"></span>
                                        <span class="checkbox-label"><?php esc_html_e('エントリーシート', 'pout-theme'); ?></span>
                                    </label>
                                    <label class="form-checkbox">
                                        <input type="checkbox" name="contact_document_types[]" value="cover">
                                        <span class="checkbox-mark"></span>
                                        <span class="checkbox-label"><?php esc_html_e('カバーレター', 'pout-theme'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contact-message" class="form-label required">
                                    <?php esc_html_e('お問い合わせ内容', 'pout-theme'); ?>
                                </label>
                                <textarea id="contact-message" name="contact_message" class="form-textarea" required
                                          rows="6"
                                          placeholder="<?php echo esc_attr($preselect_category === 'medecheck' ? __('ご希望のプラン、添削希望の書類数、お急ぎ度などをご記入ください', 'pout-theme') : __('お問い合わせ内容をご記入ください', 'pout-theme')); ?>"
                                          maxlength="5000"></textarea>
                                <div class="form-textarea-footer">
                                    <span class="form-textarea-counter">
                                        <span class="char-count">0</span> / 5,000
                                    </span>
                                </div>
                                <span class="form-error" role="alert" aria-live="polite"></span>
                            </div>
                        </fieldset>

                        <div class="form-group form-group-checkbox">
                            <label class="form-checkbox form-checkbox-required">
                                <input type="checkbox" name="contact_privacy" required>
                                <span class="checkbox-mark"></span>
                                <span class="checkbox-label">
                                    <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" target="_blank" rel="noopener noreferrer">
                                        <?php esc_html_e('プライバシーポリシー', 'pout-theme'); ?>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15,3 21,3 21,9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                    </a>
                                    <?php esc_html_e('に同意する', 'pout-theme'); ?>
                                </span>
                            </label>
                            <span class="form-error" role="alert" aria-live="polite"></span>
                        </div>

                        <div class="form-submit">
                            <button type="submit" class="btn btn-gold btn-lg btn-block" id="contact-submit">
                                <span class="btn-text">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <line x1="22" y1="2" x2="11" y2="13"></line>
                                        <polygon points="22,2 15,22 11,13 2,9"></polygon>
                                    </svg>
                                    <?php esc_html_e('送信する', 'pout-theme'); ?>
                                </span>
                                <span class="btn-loading" aria-hidden="true">
                                    <svg class="spinner" width="20" height="20" viewBox="0 0 24 24">
                                        <circle class="spinner-circle" cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="3"></circle>
                                    </svg>
                                    <?php esc_html_e('送信中...', 'pout-theme'); ?>
                                </span>
                            </button>
                            <p class="form-submit-note">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <?php esc_html_e('SSL暗号化通信で安全に送信されます', 'pout-theme'); ?>
                            </p>
                        </div>
                    </form>
                </div>

                <!-- サイドバー情報 -->
                <aside class="contact-sidebar">
                    <!-- MEDECHECK クイック申込 -->
                    <div class="contact-medecheck-card">
                        <div class="medecheck-card-header">
                            <span class="medecheck-card-eyebrow"><?php esc_html_e('AIじゃない。目で、チェック。', 'pout-theme'); ?></span>
                            <h2 class="medecheck-card-title"><?php esc_html_e('MEDECHECK', 'pout-theme'); ?></h2>
                        </div>
                        <p class="medecheck-card-description">
                            <?php esc_html_e('プロの目による書類添削サービス。履歴書・職務経歴書・ESを徹底チェックします。', 'pout-theme'); ?>
                        </p>
                        <ul class="medecheck-card-features">
                            <li>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                                <?php esc_html_e('24時間以内納品', 'pout-theme'); ?>
                            </li>
                            <li>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                                <?php esc_html_e('初回50%OFF', 'pout-theme'); ?>
                            </li>
                            <li>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20,6 9,17 4,12"></polyline></svg>
                                <?php esc_html_e('満足保証付き', 'pout-theme'); ?>
                            </li>
                        </ul>
                        <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-outline btn-block btn-sm">
                            <?php esc_html_e('サービス詳細を見る', 'pout-theme'); ?>
                        </a>
                    </div>

                    <!-- お問い合わせ先情報 -->
                    <div class="contact-info-card">
                        <h2 class="contact-info-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <?php esc_html_e('会社情報', 'pout-theme'); ?>
                        </h2>

                        <div class="contact-info-item">
                            <div class="contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div class="contact-info-content">
                                <span class="contact-info-label"><?php esc_html_e('メール', 'pout-theme'); ?></span>
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('pout_email', 'info@pout.co.jp')); ?>">
                                    <?php echo esc_html(get_theme_mod('pout_email', 'info@pout.co.jp')); ?>
                                </a>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path>
                                </svg>
                            </div>
                            <div class="contact-info-content">
                                <span class="contact-info-label"><?php esc_html_e('電話', 'pout-theme'); ?></span>
                                <a href="tel:<?php echo esc_attr(str_replace('-', '', get_theme_mod('pout_phone', '03-0000-0000'))); ?>">
                                    <?php echo esc_html(get_theme_mod('pout_phone', '03-0000-0000')); ?>
                                </a>
                                <span class="contact-info-note"><?php esc_html_e('平日 10:00〜18:00', 'pout-theme'); ?></span>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

                    <!-- 返信について -->
                    <div class="contact-notice-card">
                        <h3 class="notice-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                            <?php esc_html_e('ご返信について', 'pout-theme'); ?>
                        </h3>
                        <ul class="notice-list">
                            <li><?php esc_html_e('通常2営業日以内にご返信いたします', 'pout-theme'); ?></li>
                            <li><?php esc_html_e('お急ぎの方はお電話でお問い合わせください', 'pout-theme'); ?></li>
                            <li><?php esc_html_e('迷惑メールフォルダもご確認ください', 'pout-theme'); ?></li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</article>

<script>
// MEDECHECK選択時に追加フィールドを表示
document.addEventListener('DOMContentLoaded', function() {
    var categorySelect = document.getElementById('contact-category');
    var medecheckFields = document.getElementById('medecheck-fields');

    if (categorySelect && medecheckFields) {
        function toggleMedecheckFields() {
            if (categorySelect.value === 'medecheck') {
                medecheckFields.style.display = 'block';
            } else {
                medecheckFields.style.display = 'none';
            }
        }

        categorySelect.addEventListener('change', toggleMedecheckFields);
        toggleMedecheckFields(); // 初期状態をチェック
    }
});
</script>

<?php get_footer(); ?>
