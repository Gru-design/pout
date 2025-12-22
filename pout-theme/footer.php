<?php
/**
 * Footer Template
 *
 * サイトフッター
 * Pout Consulting / MEDECHECK
 *
 * @package Pout_Theme
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$is_front_page = is_front_page();
$is_lp_page = is_page_template('page-medecheck.php') || is_page_template('page-resumake.php');
$is_article = is_singular('post');
$show_footer_cta = $is_front_page || is_page();
?>
</main><!-- #main-content -->

<footer class="site-footer" role="contentinfo">
    <?php if ($show_footer_cta && !$is_lp_page) : ?>
    <!-- Footer CTA -->
    <section class="footer-cta">
        <div class="container">
            <div class="footer-cta-content">
                <h2 class="footer-cta-title"><?php esc_html_e('あなたのキャリアを、次のステージへ', 'pout-theme'); ?></h2>
                <p class="footer-cta-text"><?php esc_html_e('MEDECHECKで、プロの目による書類添削を体験してみませんか？', 'pout-theme'); ?></p>
                <div class="footer-cta-actions">
                    <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-secondary btn-lg">
                        <?php esc_html_e('MEDECHECKを見る', 'pout-theme'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline btn-lg">
                        <?php esc_html_e('お問い合わせ', 'pout-theme'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Footer Main -->
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- Company Info -->
                <div class="footer-brand">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <span class="footer-logo-text">Pout</span>
                    <?php endif; ?>
                    <p class="footer-description">
                        <?php esc_html_e('「AIじゃない。目で、チェック。」', 'pout-theme'); ?><br>
                        <?php esc_html_e('プロのキャリアアドバイザーによる書類添削サービス MEDECHECK を提供しています。', 'pout-theme'); ?>
                    </p>

                    <!-- Social Links -->
                    <div class="footer-social">
                        <?php
                        $social_links = array(
                            'twitter'   => array(
                                'url'  => get_theme_mod('pout_twitter_url', ''),
                                'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
                            ),
                            'facebook'  => array(
                                'url'  => get_theme_mod('pout_facebook_url', ''),
                                'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                            ),
                            'linkedin'  => array(
                                'url'  => get_theme_mod('pout_linkedin_url', ''),
                                'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                            ),
                            'instagram' => array(
                                'url'  => get_theme_mod('pout_instagram_url', ''),
                                'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
                            ),
                        );
                        foreach ($social_links as $platform => $data) :
                            if (!empty($data['url'])) :
                        ?>
                            <a href="<?php echo esc_url($data['url']); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($platform)); ?>">
                                <?php echo $data['icon']; ?>
                            </a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>

                <!-- Footer Widgets or Static Links -->
                <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
                <?php else : ?>
                <div class="footer-widget-area">
                    <h4><?php esc_html_e('サービス', 'pout-theme'); ?></h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/medecheck/')); ?>">MEDECHECK</a></li>
                        <li><a href="<?php echo esc_url(home_url('/pricing/')); ?>"><?php esc_html_e('料金プラン', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/case-studies/')); ?>"><?php esc_html_e('導入事例', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/faq/')); ?>"><?php esc_html_e('よくある質問', 'pout-theme'); ?></a></li>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
                <?php else : ?>
                <div class="footer-widget-area">
                    <h4><?php esc_html_e('会社情報', 'pout-theme'); ?></h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('私たちについて', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/team/')); ?>"><?php esc_html_e('チーム', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/careers/')); ?>"><?php esc_html_e('採用情報', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('お問い合わせ', 'pout-theme'); ?></a></li>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-3')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-3'); ?>
                </div>
                <?php else : ?>
                <div class="footer-widget-area">
                    <h4><?php esc_html_e('コンテンツ', 'pout-theme'); ?></h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('メディア', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/category/resume/')); ?>"><?php esc_html_e('職務経歴書', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/category/interview/')); ?>"><?php esc_html_e('面接対策', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/category/career/')); ?>"><?php esc_html_e('キャリア戦略', 'pout-theme'); ?></a></li>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer Navigation -->
    <div class="footer-nav">
        <div class="container">
            <?php
            if (has_nav_menu('footer')) {
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => false,
                    'depth'          => 1,
                ));
            } else {
                ?>
                <ul class="footer-menu">
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php esc_html_e('プライバシーポリシー', 'pout-theme'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms/')); ?>"><?php esc_html_e('利用規約', 'pout-theme'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/sitemap/')); ?>"><?php esc_html_e('サイトマップ', 'pout-theme'); ?></a></li>
                </ul>
                <?php
            }
            ?>
        </div>
    </div>

    <!-- Copyright -->
    <div class="footer-bottom">
        <div class="container">
            <p class="copyright">
                &copy; <?php echo esc_html(gmdate('Y')); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">Pout</a>.
                <?php esc_html_e('All Rights Reserved.', 'pout-theme'); ?>
            </p>
        </div>
    </div>
</footer>

<?php if ($is_article) : ?>
<!-- Floating Share (Article Pages) -->
<div class="floating-share" aria-label="<?php esc_attr_e('シェア', 'pout-theme'); ?>">
    <button class="share-toggle" type="button" aria-expanded="false" aria-label="<?php esc_attr_e('シェアオプションを開く', 'pout-theme'); ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="18" cy="5" r="3"></circle>
            <circle cx="6" cy="12" r="3"></circle>
            <circle cx="18" cy="19" r="3"></circle>
            <path d="M8.59 13.51l6.83 3.98M15.41 6.51l-6.82 3.98"></path>
        </svg>
    </button>
    <div class="share-buttons" aria-hidden="true">
        <a href="https://twitter.com/intent/tweet?url=<?php echo esc_url(rawurlencode(get_permalink())); ?>&text=<?php echo esc_attr(rawurlencode(get_the_title())); ?>" class="share-btn share-twitter" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)">X</a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(rawurlencode(get_permalink())); ?>" class="share-btn share-facebook" target="_blank" rel="noopener noreferrer" aria-label="Facebook">FB</a>
        <a href="https://b.hatena.ne.jp/entry/<?php echo esc_url(rawurlencode(get_permalink())); ?>" class="share-btn share-hatena" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('はてなブックマーク', 'pout-theme'); ?>">B!</a>
        <button class="share-btn share-copy" type="button" data-url="<?php echo esc_url(get_permalink()); ?>" aria-label="<?php esc_attr_e('URLをコピー', 'pout-theme'); ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
            </svg>
        </button>
    </div>
</div>
<?php endif; ?>

<!-- Back to Top -->
<button class="back-to-top" type="button" aria-label="<?php esc_attr_e('ページトップへ戻る', 'pout-theme'); ?>">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 15l-6-6-6 6"></path>
    </svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
