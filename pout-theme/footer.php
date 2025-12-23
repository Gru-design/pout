<?php
/**
 * Footer Template
 *
 * サイトフッター
 * Pout.Lab - 履歴書・職務経歴書添削の研究所
 *
 * @package Pout_Theme
 * @version 3.0.0
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
                <h2 class="footer-cta-title"><?php esc_html_e('あなたの書類を「通過する書類」に', 'pout-theme'); ?></h2>
                <p class="footer-cta-text"><?php esc_html_e('累計850件以上の添削実績。Pout.Labの研究員があなたの書類を診断します。', 'pout-theme'); ?></p>
                <div class="footer-cta-actions">
                    <a href="<?php echo esc_url(home_url('/medecheck/')); ?>" class="btn btn-secondary btn-lg">
                        <?php esc_html_e('添削サービスを見る', 'pout-theme'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline btn-lg">
                        <?php esc_html_e('無料相談する', 'pout-theme'); ?>
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
                        <span class="footer-logo-text">Pout<span class="footer-logo-dot">.</span>Lab</span>
                    <?php endif; ?>
                    <p class="footer-tagline"><?php esc_html_e('履歴書・職務経歴書添削の研究所', 'pout-theme'); ?></p>
                    <p class="footer-description">
                        <?php esc_html_e('累計850件以上の添削実績。AIじゃない。目で、チェック。', 'pout-theme'); ?><br>
                        <?php esc_html_e('あなたの経験を、通過する言葉に変換します。', 'pout-theme'); ?>
                    </p>

                    <!-- Social Links -->
                    <div class="footer-social">
                        <?php
                        $social_links = array(
                            'twitter'   => array(
                                'url'  => get_theme_mod('pout_twitter_url', ''),
                                'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
                            ),
                            'note'      => array(
                                'url'  => get_theme_mod('pout_note_url', 'https://note.com/pout_lab'),
                                'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>',
                            ),
                            'coconala'  => array(
                                'url'  => get_theme_mod('pout_coconala_url', ''),
                                'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>',
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
                        <li><a href="https://note.com/pout_lab" target="_blank" rel="noopener"><?php esc_html_e('研究レポート (note)', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/tools/')); ?>"><?php esc_html_e('転職ツール比較', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('キャリア相談', 'pout-theme'); ?></a></li>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
                <?php else : ?>
                <div class="footer-widget-area">
                    <h4><?php esc_html_e('研究所について', 'pout-theme'); ?></h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('Pout.Labとは', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('リサーチ記事', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/faq/')); ?>"><?php esc_html_e('よくある質問', 'pout-theme'); ?></a></li>
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
                        <li><a href="<?php echo esc_url(home_url('/category/resume/')); ?>"><?php esc_html_e('職務経歴書の書き方', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/category/interview/')); ?>"><?php esc_html_e('面接対策', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/category/career/')); ?>"><?php esc_html_e('キャリア戦略', 'pout-theme'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/category/case-study/')); ?>"><?php esc_html_e('添削事例', 'pout-theme'); ?></a></li>
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
                    <li><a href="<?php echo esc_url(home_url('/tokutei/')); ?>"><?php esc_html_e('特定商取引法に基づく表記', 'pout-theme'); ?></a></li>
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
                <a href="<?php echo esc_url(home_url('/')); ?>">Pout.Lab</a>
                <?php esc_html_e('- 履歴書・職務経歴書添削の研究所', 'pout-theme'); ?>
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
