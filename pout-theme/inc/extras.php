<?php
/**
 * Extras
 *
 * 便利ツール・追加機能
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ========================================
 * PV カウント
 * ========================================
 */

/**
 * 投稿閲覧数をカウント
 */
function pout_count_post_views($post_id) {
    if (!$post_id) return;

    // ボットを除外
    if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|spider|slurp/i', $_SERVER['HTTP_USER_AGENT'])) {
        return;
    }

    // 管理者を除外
    if (current_user_can('manage_options')) {
        return;
    }

    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);

    if ($count === '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, 1);
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

/**
 * 閲覧数を取得
 */
function pout_get_post_views($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $count = get_post_meta($post_id, 'post_views_count', true);
    return $count ? intval($count) : 0;
}

/**
 * 閲覧数を表示用にフォーマット
 */
function pout_format_views($views) {
    if ($views >= 1000000) {
        return round($views / 1000000, 1) . 'M';
    }
    if ($views >= 1000) {
        return round($views / 1000, 1) . 'K';
    }
    return number_format($views);
}

/**
 * ========================================
 * 人気記事ウィジェット
 * ========================================
 */

class Pout_Popular_Posts_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'pout_popular_posts',
            __('人気記事', 'pout-theme'),
            array('description' => __('閲覧数の多い記事を表示', 'pout-theme'))
        );
    }

    public function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        $number = isset($instance['number']) ? intval($instance['number']) : 5;

        $popular_posts = get_posts(array(
            'posts_per_page' => $number,
            'meta_key'       => 'post_views_count',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
        ));

        if (empty($popular_posts)) {
            return;
        }

        echo $args['before_widget'];

        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo '<ul class="popular-posts-widget">';
        $rank = 1;
        foreach ($popular_posts as $post) {
            ?>
            <li class="popular-posts-item">
                <span class="popular-rank"><?php echo $rank; ?></span>
                <a href="<?php echo get_permalink($post); ?>">
                    <?php if (has_post_thumbnail($post)) : ?>
                    <div class="popular-thumb">
                        <?php echo get_the_post_thumbnail($post, 'thumbnail'); ?>
                    </div>
                    <?php endif; ?>
                    <div class="popular-info">
                        <span class="popular-title"><?php echo get_the_title($post); ?></span>
                        <span class="popular-views"><?php echo pout_format_views(pout_get_post_views($post->ID)); ?> views</span>
                    </div>
                </a>
            </li>
            <?php
            $rank++;
        }
        echo '</ul>';

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : __('人気記事', 'pout-theme');
        $number = isset($instance['number']) ? intval($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('タイトル:', 'pout-theme'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('表示件数:', 'pout-theme'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['number'] = absint($new_instance['number']);
        return $instance;
    }
}

function pout_register_widgets() {
    register_widget('Pout_Popular_Posts_Widget');
}
add_action('widgets_init', 'pout_register_widgets');

/**
 * ========================================
 * 目次自動生成
 * ========================================
 */

/**
 * 見出しにIDを自動付与
 */
function pout_add_heading_ids($content) {
    if (!is_singular('post')) {
        return $content;
    }

    $pattern = '/<(h[2-4])([^>]*)>(.+?)<\/\1>/i';

    $content = preg_replace_callback($pattern, function($matches) {
        $tag = $matches[1];
        $attrs = $matches[2];
        $text = $matches[3];

        // 既にIDがある場合はスキップ
        if (preg_match('/id=["\']([^"\']+)["\']/', $attrs)) {
            return $matches[0];
        }

        // IDを生成
        $id = sanitize_title($text);
        $id = preg_replace('/[^a-z0-9\-_]/i', '', $id);

        if (empty($id)) {
            $id = 'heading-' . wp_rand(1000, 9999);
        }

        return sprintf('<%s%s id="%s">%s</%s>', $tag, $attrs, esc_attr($id), $text, $tag);
    }, $content);

    return $content;
}
add_filter('the_content', 'pout_add_heading_ids', 5);

/**
 * ========================================
 * 関連記事取得
 * ========================================
 */

/**
 * 関連記事を取得
 */
function pout_get_related_posts($post_id = null, $number = 4) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $categories = get_the_category($post_id);
    $tags = get_the_tags($post_id);

    $category_ids = wp_list_pluck($categories, 'term_id');
    $tag_ids = $tags ? wp_list_pluck($tags, 'term_id') : array();

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $number,
        'post__not_in'   => array($post_id),
        'orderby'        => 'rand',
    );

    if (!empty($tag_ids)) {
        $args['tag__in'] = $tag_ids;
    } elseif (!empty($category_ids)) {
        $args['category__in'] = $category_ids;
    }

    return get_posts($args);
}

/**
 * ========================================
 * ソーシャルシェア数取得
 * ========================================
 */

/**
 * はてなブックマーク数を取得
 */
function pout_get_hatena_count($url) {
    $cache_key = 'hatena_count_' . md5($url);
    $count = get_transient($cache_key);

    if ($count === false) {
        $api_url = 'https://bookmark.hatenaapis.com/count/entry?url=' . urlencode($url);
        $response = wp_remote_get($api_url, array('timeout' => 5));

        if (!is_wp_error($response)) {
            $count = intval(wp_remote_retrieve_body($response));
            set_transient($cache_key, $count, HOUR_IN_SECONDS);
        } else {
            $count = 0;
        }
    }

    return $count;
}

/**
 * ========================================
 * 投稿一覧カラム追加
 * ========================================
 */

/**
 * 管理画面に閲覧数カラム追加
 */
function pout_add_views_column($columns) {
    $columns['post_views'] = __('閲覧数', 'pout-theme');
    return $columns;
}
add_filter('manage_posts_columns', 'pout_add_views_column');

function pout_show_views_column($column_name, $post_id) {
    if ($column_name === 'post_views') {
        echo pout_format_views(pout_get_post_views($post_id));
    }
}
add_action('manage_posts_custom_column', 'pout_show_views_column', 10, 2);

function pout_views_column_sortable($columns) {
    $columns['post_views'] = 'post_views';
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'pout_views_column_sortable');

function pout_views_column_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('orderby') === 'post_views') {
        $query->set('meta_key', 'post_views_count');
        $query->set('orderby', 'meta_value_num');
    }
}
add_action('pre_get_posts', 'pout_views_column_orderby');

/**
 * ========================================
 * コピー防止機能（オプション）
 * ========================================
 */

/**
 * 右クリック禁止（カスタマイザーで有効化可能）
 */
function pout_disable_right_click() {
    if (!get_theme_mod('pout_disable_right_click', false)) {
        return;
    }
    ?>
    <script>
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
    document.addEventListener('selectstart', function(e) {
        e.preventDefault();
    });
    </script>
    <?php
}
add_action('wp_footer', 'pout_disable_right_click');

/**
 * ========================================
 * 外部リンク処理
 * ========================================
 */

/**
 * 外部リンクに target="_blank" と rel="noopener" を追加
 */
function pout_external_links($content) {
    $home_url = home_url();

    $content = preg_replace_callback(
        '/<a([^>]+)href=["\']([^"\']+)["\']([^>]*)>/i',
        function($matches) use ($home_url) {
            $before = $matches[1];
            $url = $matches[2];
            $after = $matches[3];

            // 内部リンクはスキップ
            if (strpos($url, $home_url) === 0 || strpos($url, '/') === 0 || strpos($url, '#') === 0) {
                return $matches[0];
            }

            // 外部リンクの場合
            if (strpos($url, 'http') === 0) {
                // target="_blank" を追加（なければ）
                if (strpos($before . $after, 'target=') === false) {
                    $after .= ' target="_blank"';
                }

                // rel="noopener noreferrer" を追加
                if (strpos($before . $after, 'rel=') === false) {
                    $after .= ' rel="noopener noreferrer"';
                } else {
                    $after = preg_replace('/rel=["\']([^"\']*)["\']/', 'rel="$1 noopener noreferrer"', $after);
                }
            }

            return '<a' . $before . 'href="' . $url . '"' . $after . '>';
        },
        $content
    );

    return $content;
}
add_filter('the_content', 'pout_external_links');

/**
 * ========================================
 * SNS埋め込み最適化
 * ========================================
 */

/**
 * Twitter埋め込みの遅延読み込み
 */
function pout_lazy_twitter_embed($content) {
    if (strpos($content, 'twitter-tweet') === false) {
        return $content;
    }

    // Twitterスクリプトを遅延読み込み
    $content .= '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var tweets = document.querySelectorAll(".twitter-tweet");
            if (tweets.length > 0) {
                var script = document.createElement("script");
                script.src = "https://platform.twitter.com/widgets.js";
                script.async = true;
                document.body.appendChild(script);
            }
        });
    </script>';

    return $content;
}
add_filter('the_content', 'pout_lazy_twitter_embed');

/**
 * ========================================
 * 投稿フォーマット判定
 * ========================================
 */

/**
 * 投稿が長いかどうかを判定
 */
function pout_is_long_post($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $content = get_post_field('post_content', $post_id);
    return mb_strlen(strip_tags($content)) > 3000;
}

/**
 * ========================================
 * デバッグ用ツール
 * ========================================
 */

/**
 * クエリ数とロード時間を表示（管理者のみ）
 */
function pout_show_performance_stats() {
    if (!current_user_can('manage_options') || is_admin()) {
        return;
    }

    global $wpdb;
    $query_count = $wpdb->num_queries;
    $memory_usage = round(memory_get_peak_usage() / 1024 / 1024, 2);
    $load_time = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 4);

    echo '<!-- Performance: ' . $query_count . ' queries, ' . $memory_usage . 'MB memory, ' . $load_time . 's -->';
}
add_action('wp_footer', 'pout_show_performance_stats', 999);

/**
 * ========================================
 * カスタムログイン画面
 * ========================================
 */

/**
 * ログイン画面のロゴを変更
 */
function pout_login_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo_url = $custom_logo_id ? wp_get_attachment_image_url($custom_logo_id, 'full') : '';

    if (!$logo_url) {
        return;
    }
    ?>
    <style type="text/css">
        #login h1 a {
            background-image: url(<?php echo esc_url($logo_url); ?>);
            background-size: contain;
            width: 200px;
            height: 60px;
        }
    </style>
    <?php
}
add_action('login_enqueue_scripts', 'pout_login_logo');

/**
 * ログインロゴのリンク先を変更
 */
function pout_login_logo_url() {
    return home_url('/');
}
add_filter('login_headerurl', 'pout_login_logo_url');

/**
 * ログインロゴのタイトルを変更
 */
function pout_login_logo_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'pout_login_logo_title');

/**
 * ========================================
 * ウィジェット用スタイル
 * ========================================
 */

function pout_widget_styles() {
    ?>
    <style>
    .popular-posts-widget {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .popular-posts-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--color-border-light);
    }
    .popular-posts-item:last-child {
        border-bottom: none;
    }
    .popular-rank {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-primary);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: var(--radius-sm);
    }
    .popular-posts-item:nth-child(1) .popular-rank { background: #fbbf24; }
    .popular-posts-item:nth-child(2) .popular-rank { background: #9ca3af; }
    .popular-posts-item:nth-child(3) .popular-rank { background: #b45309; }
    .popular-posts-item a {
        display: flex;
        gap: 0.75rem;
        color: inherit;
        flex: 1;
    }
    .popular-thumb {
        flex-shrink: 0;
        width: 60px;
        height: 40px;
        border-radius: var(--radius-sm);
        overflow: hidden;
    }
    .popular-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .popular-info {
        flex: 1;
        min-width: 0;
    }
    .popular-title {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1.4;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .popular-views {
        font-size: 0.75rem;
        color: var(--color-text-muted);
    }
    </style>
    <?php
}
add_action('wp_head', 'pout_widget_styles');
