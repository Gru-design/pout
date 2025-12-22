<?php
/**
 * Footer Template
 *
 * 条件分岐フッター - ページタイプに応じたフッター表示
 *
 * @package Pout_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$page_type = pout_get_page_type();
$footer_class = 'site-footer site-footer--' . $page_type;
?>
</main><!-- #main-content -->

<footer class="<?php echo esc_attr($footer_class); ?>" role="contentinfo">
    <?php if ($page_type === 'corporate' || $page_type === 'service') : ?>
    <!-- コーポレート向けCTA -->
    <section class="footer-cta">
        <div class="container">
            <div class="footer-cta-content">
                <h2 class="footer-cta-title"><?php esc_html_e('お気軽にお問い合わせください', 'pout-theme'); ?></h2>
                <p class="footer-cta-text"><?php esc_html_e('サービスに関するご質問・ご相談はこちらから', 'pout-theme'); ?></p>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('お問い合わせ', 'pout-theme'); ?>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- フッターメイン -->
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- 会社情報 -->
                <div class="footer-brand">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <span class="footer-logo-text"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                    <p class="footer-description">
                        <?php bloginfo('description'); ?>
                    </p>

                    <!-- ソーシャルリンク -->
                    <div class="footer-social">
                        <?php
                        $social_links = array(
                            'twitter'  => get_theme_mod('pout_twitter_url', ''),
                            'facebook' => get_theme_mod('pout_facebook_url', ''),
                            'linkedin' => get_theme_mod('pout_linkedin_url', ''),
                            'youtube'  => get_theme_mod('pout_youtube_url', ''),
                        );
                        foreach ($social_links as $platform => $url) :
                            if ($url) :
                        ?>
                            <a href="<?php echo esc_url($url); ?>" class="social-link social-<?php echo esc_attr($platform); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($platform)); ?>">
                                <span class="social-icon social-icon-<?php echo esc_attr($platform); ?>"></span>
                            </a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>

                <!-- フッターウィジェット -->
                <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-3')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-3'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- フッターナビゲーション -->
    <div class="footer-nav">
        <div class="container">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_class'     => 'footer-menu',
                'container'      => false,
                'fallback_cb'    => false,
                'depth'          => 1,
            ));
            ?>
        </div>
    </div>

    <!-- コピーライト -->
    <div class="footer-bottom">
        <div class="container">
            <p class="copyright">
                &copy; <?php echo esc_html(date('Y')); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>.
                <?php esc_html_e('All Rights Reserved.', 'pout-theme'); ?>
            </p>
        </div>
    </div>
</footer>

<?php if ($page_type === 'article') : ?>
<!-- 記事ページ用固定シェアボタン -->
<div class="floating-share" aria-label="<?php esc_attr_e('シェア', 'pout-theme'); ?>">
    <button class="share-toggle" aria-expanded="false">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="18" cy="5" r="3"></circle>
            <circle cx="6" cy="12" r="3"></circle>
            <circle cx="18" cy="19" r="3"></circle>
            <path d="M8.59 13.51l6.83 3.98M15.41 6.51l-6.82 3.98"></path>
        </svg>
    </button>
    <div class="share-buttons">
        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" class="share-btn share-twitter" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
            <span>X</span>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" class="share-btn share-facebook" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <span>FB</span>
        </a>
        <a href="https://b.hatena.ne.jp/entry/<?php echo urlencode(get_permalink()); ?>" class="share-btn share-hatena" target="_blank" rel="noopener noreferrer" aria-label="はてなブックマーク">
            <span>B!</span>
        </a>
        <button class="share-btn share-copy" data-url="<?php echo esc_url(get_permalink()); ?>" aria-label="<?php esc_attr_e('URLをコピー', 'pout-theme'); ?>">
            <span>📋</span>
        </button>
    </div>
</div>
<?php endif; ?>

<!-- ページトップへ戻る -->
<button class="back-to-top" aria-label="<?php esc_attr_e('ページトップへ戻る', 'pout-theme'); ?>">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 15l-6-6-6 6"></path>
    </svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
