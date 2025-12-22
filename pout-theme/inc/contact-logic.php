<?php
/**
 * Contact Form Logic
 *
 * お問い合わせフォーム処理API
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * フォーム送信処理
 */
function pout_handle_contact_form() {
    // Nonce 検証
    if (!isset($_POST['pout_contact_nonce']) || !wp_verify_nonce($_POST['pout_contact_nonce'], 'pout_contact_form')) {
        pout_contact_redirect('error');
        return;
    }

    // ハニーポットチェック（スパム対策）
    if (!empty($_POST['website'])) {
        pout_contact_redirect('error');
        return;
    }

    // レート制限チェック
    if (!pout_check_rate_limit()) {
        pout_contact_redirect('error');
        return;
    }

    // データのサニタイズ
    $name = sanitize_text_field($_POST['contact_name'] ?? '');
    $company = sanitize_text_field($_POST['contact_company'] ?? '');
    $email = sanitize_email($_POST['contact_email'] ?? '');
    $phone = sanitize_text_field($_POST['contact_phone'] ?? '');
    $category = sanitize_text_field($_POST['contact_category'] ?? '');
    $message = sanitize_textarea_field($_POST['contact_message'] ?? '');
    $privacy = isset($_POST['contact_privacy']);

    // バリデーション
    $errors = array();

    if (empty($name)) {
        $errors[] = __('お名前は必須です', 'pout-theme');
    }

    if (empty($email) || !is_email($email)) {
        $errors[] = __('有効なメールアドレスを入力してください', 'pout-theme');
    }

    if (empty($category)) {
        $errors[] = __('お問い合わせ種別を選択してください', 'pout-theme');
    }

    if (empty($message)) {
        $errors[] = __('お問い合わせ内容を入力してください', 'pout-theme');
    }

    if (mb_strlen($message) > 5000) {
        $errors[] = __('お問い合わせ内容は5000文字以内で入力してください', 'pout-theme');
    }

    if (!$privacy) {
        $errors[] = __('プライバシーポリシーへの同意が必要です', 'pout-theme');
    }

    // 禁止ワードチェック
    if (pout_contains_spam_words($message)) {
        $errors[] = __('不正なコンテンツが含まれています', 'pout-theme');
    }

    if (!empty($errors)) {
        // エラーをセッションに保存
        set_transient('pout_contact_errors_' . pout_get_client_ip(), $errors, 5 * MINUTE_IN_SECONDS);
        pout_contact_redirect('error');
        return;
    }

    // カテゴリラベルを取得
    $category_labels = array(
        'service'     => __('サービスについて', 'pout-theme'),
        'quote'       => __('お見積り依頼', 'pout-theme'),
        'partnership' => __('協業・提携について', 'pout-theme'),
        'recruit'     => __('採用について', 'pout-theme'),
        'media'       => __('取材・メディア掲載', 'pout-theme'),
        'other'       => __('その他', 'pout-theme'),
    );
    $category_label = $category_labels[$category] ?? $category;

    // メール本文作成
    $email_body = sprintf(
        "
=================================
お問い合わせ詳細
=================================

【お名前】
%s

【会社名】
%s

【メールアドレス】
%s

【電話番号】
%s

【お問い合わせ種別】
%s

【お問い合わせ内容】
%s

=================================
送信情報
=================================
送信日時: %s
IPアドレス: %s
ユーザーエージェント: %s
",
        $name,
        $company ?: '未入力',
        $email,
        $phone ?: '未入力',
        $category_label,
        $message,
        current_time('Y-m-d H:i:s'),
        pout_get_client_ip(),
        $_SERVER['HTTP_USER_AGENT'] ?? ''
    );

    // 管理者へメール送信
    $admin_email = get_theme_mod('pout_email', get_option('admin_email'));
    $subject = sprintf('[%s] お問い合わせ: %s様より', get_bloginfo('name'), $name);

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . $admin_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    $sent = wp_mail($admin_email, $subject, $email_body, $headers);

    if (!$sent) {
        error_log('Contact form email failed to send');
        pout_contact_redirect('error');
        return;
    }

    // 自動返信メール送信
    pout_send_auto_reply($email, $name, $category_label, $message);

    // お問い合わせをデータベースに保存（オプション）
    pout_save_contact_to_db($name, $company, $email, $phone, $category, $message);

    // 成功リダイレクト
    pout_contact_redirect('success');
}
add_action('admin_post_pout_contact_submit', 'pout_handle_contact_form');
add_action('admin_post_nopriv_pout_contact_submit', 'pout_handle_contact_form');

/**
 * 自動返信メール送信
 */
function pout_send_auto_reply($to, $name, $category, $message) {
    $site_name = get_bloginfo('name');

    $subject = sprintf('[%s] お問い合わせを受け付けました', $site_name);

    $body = sprintf(
        "%s 様

この度は %s へお問い合わせいただき、誠にありがとうございます。
以下の内容でお問い合わせを受け付けいたしました。

=================================
お問い合わせ内容
=================================

【お問い合わせ種別】
%s

【お問い合わせ内容】
%s

=================================

通常2営業日以内にご返信いたします。
今しばらくお待ちくださいますよう、お願い申し上げます。

※このメールは自動送信です。このメールへの返信はできません。

--
%s
%s
",
        $name,
        $site_name,
        $category,
        $message,
        $site_name,
        home_url('/')
    );

    $admin_email = get_theme_mod('pout_email', get_option('admin_email'));
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $site_name . ' <' . $admin_email . '>',
    );

    wp_mail($to, $subject, $body, $headers);
}

/**
 * お問い合わせをデータベースに保存
 */
function pout_save_contact_to_db($name, $company, $email, $phone, $category, $message) {
    // カスタム投稿タイプとして保存（オプション）
    if (!post_type_exists('contact_submissions')) {
        return;
    }

    $post_data = array(
        'post_title'   => sprintf('%s - %s', $name, current_time('Y-m-d H:i')),
        'post_content' => $message,
        'post_status'  => 'private',
        'post_type'    => 'contact_submissions',
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        update_post_meta($post_id, '_contact_name', $name);
        update_post_meta($post_id, '_contact_company', $company);
        update_post_meta($post_id, '_contact_email', $email);
        update_post_meta($post_id, '_contact_phone', $phone);
        update_post_meta($post_id, '_contact_category', $category);
        update_post_meta($post_id, '_contact_ip', pout_get_client_ip());
    }
}

/**
 * お問い合わせ保存用カスタム投稿タイプ登録
 */
function pout_register_contact_post_type() {
    register_post_type('contact_submissions', array(
        'labels' => array(
            'name'          => __('お問い合わせ', 'pout-theme'),
            'singular_name' => __('お問い合わせ', 'pout-theme'),
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-email-alt',
        'supports'     => array('title', 'editor'),
        'capabilities' => array(
            'create_posts' => 'do_not_allow',
        ),
        'map_meta_cap' => true,
    ));
}
add_action('init', 'pout_register_contact_post_type');

/**
 * レート制限チェック
 */
function pout_check_rate_limit() {
    $ip = pout_get_client_ip();
    $transient_key = 'contact_limit_' . md5($ip);
    $limit = 5; // 1時間あたりの送信上限
    $period = HOUR_IN_SECONDS;

    $count = get_transient($transient_key);

    if ($count === false) {
        set_transient($transient_key, 1, $period);
        return true;
    }

    if ($count >= $limit) {
        return false;
    }

    set_transient($transient_key, $count + 1, $period);
    return true;
}

/**
 * スパムワードチェック
 */
function pout_contains_spam_words($content) {
    $spam_words = array(
        'viagra',
        'cialis',
        'casino',
        'poker',
        'slots',
        'payday loan',
        'adult dating',
        'xxx',
    );

    $content_lower = strtolower($content);

    foreach ($spam_words as $word) {
        if (strpos($content_lower, $word) !== false) {
            return true;
        }
    }

    return false;
}

/**
 * クライアントIPを取得
 */
function pout_get_client_ip() {
    $ip_keys = array(
        'HTTP_CF_CONNECTING_IP', // Cloudflare
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_REAL_IP',
        'REMOTE_ADDR',
    );

    foreach ($ip_keys as $key) {
        if (!empty($_SERVER[$key])) {
            $ip = $_SERVER[$key];
            // カンマ区切りの場合は最初のIPを取得
            if (strpos($ip, ',') !== false) {
                $ip = trim(explode(',', $ip)[0]);
            }
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }

    return '0.0.0.0';
}

/**
 * リダイレクト処理
 */
function pout_contact_redirect($status) {
    $redirect_url = add_query_arg('contact', $status, home_url('/contact/'));
    wp_safe_redirect($redirect_url);
    exit;
}

/**
 * AJAXフォーム送信対応
 */
function pout_ajax_contact_form() {
    // Nonce検証
    if (!check_ajax_referer('pout_nonce', 'nonce', false)) {
        wp_send_json_error(array('message' => __('不正なリクエストです', 'pout-theme')));
    }

    // ハニーポット
    if (!empty($_POST['website'])) {
        wp_send_json_error(array('message' => __('エラーが発生しました', 'pout-theme')));
    }

    // データ取得・サニタイズ
    $name = sanitize_text_field($_POST['contact_name'] ?? '');
    $company = sanitize_text_field($_POST['contact_company'] ?? '');
    $email = sanitize_email($_POST['contact_email'] ?? '');
    $phone = sanitize_text_field($_POST['contact_phone'] ?? '');
    $category = sanitize_text_field($_POST['contact_category'] ?? '');
    $message = sanitize_textarea_field($_POST['contact_message'] ?? '');

    // バリデーション
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array('message' => __('必須項目を入力してください', 'pout-theme')));
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('有効なメールアドレスを入力してください', 'pout-theme')));
    }

    // カテゴリラベル
    $category_labels = array(
        'service'     => __('サービスについて', 'pout-theme'),
        'quote'       => __('お見積り依頼', 'pout-theme'),
        'partnership' => __('協業・提携について', 'pout-theme'),
        'recruit'     => __('採用について', 'pout-theme'),
        'media'       => __('取材・メディア掲載', 'pout-theme'),
        'other'       => __('その他', 'pout-theme'),
    );
    $category_label = $category_labels[$category] ?? $category;

    // メール送信
    $admin_email = get_theme_mod('pout_email', get_option('admin_email'));
    $subject = sprintf('[%s] お問い合わせ: %s様より', get_bloginfo('name'), $name);

    $email_body = sprintf(
        "お名前: %s\n会社名: %s\nメール: %s\n電話: %s\n種別: %s\n\n%s",
        $name,
        $company ?: '未入力',
        $email,
        $phone ?: '未入力',
        $category_label,
        $message
    );

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    $sent = wp_mail($admin_email, $subject, $email_body, $headers);

    if ($sent) {
        pout_send_auto_reply($email, $name, $category_label, $message);
        wp_send_json_success(array('message' => __('送信が完了しました', 'pout-theme')));
    } else {
        wp_send_json_error(array('message' => __('送信に失敗しました', 'pout-theme')));
    }
}
add_action('wp_ajax_pout_contact', 'pout_ajax_contact_form');
add_action('wp_ajax_nopriv_pout_contact', 'pout_ajax_contact_form');

/**
 * お問い合わせ管理画面のカスタマイズ
 */
function pout_contact_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['contact_email'] = __('メール', 'pout-theme');
    $new_columns['contact_category'] = __('種別', 'pout-theme');
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter('manage_contact_submissions_posts_columns', 'pout_contact_admin_columns');

function pout_contact_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'contact_email':
            echo esc_html(get_post_meta($post_id, '_contact_email', true));
            break;
        case 'contact_category':
            $category = get_post_meta($post_id, '_contact_category', true);
            $labels = array(
                'service'     => __('サービス', 'pout-theme'),
                'quote'       => __('見積り', 'pout-theme'),
                'partnership' => __('協業', 'pout-theme'),
                'recruit'     => __('採用', 'pout-theme'),
                'media'       => __('メディア', 'pout-theme'),
                'other'       => __('その他', 'pout-theme'),
            );
            echo esc_html($labels[$category] ?? $category);
            break;
    }
}
add_action('manage_contact_submissions_posts_custom_column', 'pout_contact_admin_column_content', 10, 2);
