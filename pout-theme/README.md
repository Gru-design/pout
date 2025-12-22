# Pout Theme

コーポレート&メディアハイブリッド WordPress テーマ - 高速・SEO最適化・収益化対応

## 概要

Pout Themeは、企業サイトとメディアサイトを一つのテーマで運用できるハイブリッドWordPressテーマです。SEO最適化、パフォーマンス向上、セキュリティ強化、収益化支援機能を備えています。

### 基本情報

| 項目 | 内容 |
|------|------|
| テーマ名 | Pout Theme |
| バージョン | 1.0.0 |
| 作者 | Pout Inc. |
| 必須PHP | 8.0以上 |
| 必須WordPress | 6.0以上 |
| 動作確認済み | WordPress 6.4 |
| ライセンス | GPL v2 or later |

---

## ディレクトリ構成

```
pout-theme/
├── assets/
│   ├── css/
│   │   └── main.css          # メインスタイルシート
│   ├── js/
│   │   └── scripts.js        # メインJavaScript
│   └── images/               # PWAアイコン等
├── inc/
│   ├── seo.php               # SEO・アナリティクス・構造化データ
│   ├── shortcodes.php        # 11個のカスタムショートコード
│   ├── cta.php               # CTA自動挿入エンジン
│   ├── optimization.php      # パフォーマンス・セキュリティ・WebP最適化
│   ├── advanced-ux.php       # UX拡張・ダークモード
│   ├── extras.php            # ユーティリティ・ウィジェット
│   ├── contact-logic.php     # お問い合わせフォーム処理
│   └── amp.php               # AMP対応
├── front-page.php            # コーポレートトップページ
├── home.php                  # ブログ/メディアトップ
├── single.php                # 記事詳細ページ
├── page-contact.php          # お問い合わせページ
├── page-resumake.php         # サービスランディングページ
├── archive-tools.php         # ツール/エコシステム一覧
├── index.php                 # フォールバックアーカイブ
├── header.php                # ヘッダーテンプレート
├── footer.php                # フッターテンプレート
├── functions.php             # テーマ初期化・コア機能
├── style.css                 # テーマメタデータ
├── manifest.json             # PWAマニフェスト
├── sw.js                     # Service Worker
└── README.md                 # このファイル
```

---

## テンプレートファイル

### メインテンプレート

| ファイル | 用途 | 主な機能 |
|---------|------|----------|
| `front-page.php` | コーポレートトップ | ヒーロー、サービス紹介、実績、CTA |
| `home.php` | ブログ/メディアトップ | フィーチャード記事、記事グリッド、サイドバー |
| `single.php` | 記事詳細 | 目次自動生成、シェアボタン、関連記事 |
| `page-contact.php` | お問い合わせ | フォーム、バリデーション、スパム対策 |
| `page-resumake.php` | サービスLP | Before/After、料金表、FAQ、お客様の声 |
| `archive-tools.php` | ツール一覧 | カテゴリフィルター、ステータスバッジ |
| `index.php` | アーカイブ | 汎用一覧、検索結果表示 |

### 共通テンプレート

| ファイル | 用途 | 主な機能 |
|---------|------|----------|
| `header.php` | ヘッダー | ページタイプ別の条件分岐ヘッダー |
| `footer.php` | フッター | ウィジェットエリア、フローティングシェア |

---

## インクルードファイル (inc/)

### inc/seo.php - SEO・アナリティクス

**機能:**
- メタタグ出力 (description, robots, canonical)
- OGP (Open Graph Protocol) タグ
- Twitter Card メタデータ
- Schema.org 構造化データ
  - Organization
  - WebSite
  - Article
  - WebPage
  - BreadcrumbList
  - FAQPage（サービスLPページ）
  - HowTo（サービスLPページ）
  - Person（E-E-A-T著者情報）
  - Speakable（AI検索/音声検索対応）
- Google Analytics 4 対応
- Google Tag Manager 対応

**E-E-A-T著者プロフィール強化:**
- ユーザープロフィールに追加フィールド
  - 役職・肩書き
  - 専門分野（カンマ区切り）
  - 資格・認定（複数行）
  - 経験年数
  - 所属組織
  - LinkedIn URL
  - X (Twitter) URL
- 記事ページに著者構造化データ（Person Schema）を自動出力
- `knowsAbout`, `hasCredential`, `worksFor`, `sameAs` などE-E-A-T対応プロパティ

**Speakable構造化データ:**
- 記事ページにspeakable属性を自動出力
- Google AI Overview / 音声検索での読み上げ対象指定
- cssSelector: `.article-title`, `.article-summary`, `.definition-box`, `.key-takeaway`

**ピクセルトラッカー統合:**
カスタマイザーから各広告プラットフォームのピクセルIDを設定可能:
- Meta Pixel（Facebook/Instagram広告）
- LINE Tag（LINE広告）
- X (Twitter) Pixel
- TikTok Pixel
- Pinterest Tag
- LinkedIn Insight Tag
- コンバージョンイベント自動トラッキング対応

**カスタマイザー設定:**
- Google Analytics ID
- GTM ID
- デフォルトOGP画像
- Twitterアカウント
- 会社情報 (名前、電話、メール、住所)
- SNSリンク (Twitter, Facebook, LinkedIn, YouTube, Instagram)
- 各種ピクセルトラッカーID

---

### inc/shortcodes.php - ショートコード

11個の収益化・コンテンツ装飾用ショートコードを提供:

| ショートコード | 用途 | パラメータ例 |
|---------------|------|-------------|
| `[pout_button]` | スタイル付きボタン | `url`, `text`, `style` |
| `[pout_cta]` | CTAボックス | `type` (default/highlight/minimal) |
| `[pout_affiliate]` | アフィリエイト商品ボックス | `image`, `title`, `rating`, `url` |
| `[pout_comparison]` | 商品比較表（親） | - |
| `[pout_comparison_item]` | 比較項目（子） | `name`, `price`, `features` |
| `[pout_balloon]` | 吹き出し | `name`, `image`, `position` |
| `[pout_notice]` | 通知ボックス | `type` (info/success/warning/error) |
| `[pout_accordion]` | アコーディオン（親） | - |
| `[pout_accordion_item]` | アコーディオン項目（子） | `title` |
| `[pout_profile]` | プロフィールカード | `name`, `image`, `bio` |
| `[pout_posts]` | 記事一覧 | `count`, `columns` (1-4) |

### スカーシティマーケティング ショートコード（inc/shortcodes.php）

コンバージョン促進用のカウントダウン・在庫表示ショートコード:

| ショートコード | 用途 | パラメータ例 |
|---------------|------|-------------|
| `[pout_countdown]` | カウントダウンタイマー | `date`, `title`, `style` (default/minimal/urgent) |
| `[pout_limited_badge]` | 期間限定バッジ | `text`, `end_date`, `style` |
| `[pout_stock]` | 残り在庫表示 | `current`, `total`, `style` (default/bar) |

**使用例:**

```
[pout_countdown date="2025-12-31 23:59:59" title="キャンペーン終了まで" style="urgent"]

[pout_limited_badge text="期間限定50%OFF" style="urgent"]

[pout_stock current="3" total="100" style="bar"]
```

### Featured Snippet最適化ショートコード（inc/seo.php）

Featured Snippetおよび AI検索最適化用のショートコード:

| ショートコード | 用途 | パラメータ例 |
|---------------|------|-------------|
| `[definition]` | 定義ボックス（〇〇とは？） | `term="SEO"` |
| `[key_takeaway]` | キーポイント/要約ボックス | `title`, `type` (summary/checklist/steps) |
| `[article_summary]` | 記事サマリー | - |
| `[comparison_table]` | 比較テーブル（パイプ区切り） | - |

**使用例:**

```
[definition term="SEO"]
検索エンジン最適化（Search Engine Optimization）の略で、
Webサイトを検索結果で上位表示させるための施策です。
[/definition]

[key_takeaway title="この記事でわかること" type="checklist"]
- SEOの基本概念
- 具体的な対策方法
- 効果測定の方法
[/key_takeaway]

[article_summary]
この記事ではSEOの基礎から応用まで、
初心者にもわかりやすく解説しています。
[/article_summary]

[comparison_table]
項目|プランA|プランB|プランC
月額料金|無料|1,000円|3,000円
機能|基本|標準|フル
サポート|なし|メール|電話+メール
[/comparison_table]
```

---

### inc/cta.php - CTA自動挿入

**機能:**
- 記事内H2見出し後への自動CTA挿入
- 記事末尾へのCTA挿入
- 4種類のCTAスタイル (default, minimal, highlight, banner)
- 投稿別の無効化オプション (メタボックス)
- カテゴリ除外機能

**カスタマイザー設定:**
- CTA有効/無効
- 挿入位置 (何番目のH2見出し後か)
- CTAテキスト、説明文
- ボタンテキスト、URL
- CTA画像
- 除外カテゴリID

---

### inc/optimization.php - パフォーマンス・セキュリティ

**パフォーマンス最適化:**
- 不要なWordPressヘッダー削除
- アセットからクエリ文字列削除
- スクリプトのdefer読み込み
- CSSプリロード
- フォントプリロード
- 画像/iframeのネイティブLazy Loading
- HTTP/2 Server Pushヘッダー

**ローカルフォントホスティング:**
- Google Fontsをローカルから配信してGDPR対応＆高速化
- カスタマイザーからワンクリックで有効化
- 対応フォント: Noto Sans JP, Zen Kaku Gothic New, システムフォント
- 外部リクエスト削減でPageSpeed向上

**セキュリティ対策:**
- セキュリティヘッダー
  - X-Content-Type-Options
  - X-Frame-Options
  - X-XSS-Protection
  - Referrer-Policy
  - Permissions-Policy
- XML-RPC無効化
- REST API制限 (非認証ユーザーのusersエンドポイント遮断)
- ログイン試行制限 (15分間に5回まで)
- 汎用ログインエラーメッセージ
- ファイルエディタ無効化
- Pingback無効化
- コメントHTML制限
- アップロードMIMEタイプ制限
- 投稿リビジョン制限 (5件)
- 自動保存間隔調整 (120秒)

---

### inc/advanced-ux.php - UX拡張

**プリフェッチ/プリレンダー:**
- DNSプリフェッチ (Google Fonts, Analytics, GTM)
- ホバー時リンクプリフェッチ (Instant.page方式)

**スクロール体験:**
- スムーズスクロール (motion-reduced対応)
- スクロール位置復元
- ページ遷移プログレスバー
- 記事読了プログレスバー
- スクロール時ヘッダー縮小

**ローディング:**
- スケルトンローダースタイル
- 画像出現アニメーション

**アクセシビリティ:**
- focus-visibleスタイル
- キーボードフォーカスアウトライン
- タッチターゲット拡大
- スクリーンリーダー用ライブリージョン

**パフォーマンス計測:**
- Core Web Vitals測定 (LCP, FID, CLS)
- 読了率GA4イベント送信

---

### inc/extras.php - ユーティリティ

**PVカウンター:**
- 投稿閲覧数トラッキング (ボット/管理者除外)
- 閲覧数フォーマット (M/K表記)

**人気記事ウィジェット:**
- カスタムWP_Widgetクラス
- ランクバッジ、サムネイル、閲覧数表示

**その他:**
- 自動見出しID生成
- 関連記事取得関数
- はてなブックマーク数取得
- 外部リンク処理 (target="_blank", rel="noopener noreferrer")
- Twitter埋め込みLazy Loading
- ログインページロゴカスタマイズ
- 管理バーカスタマイズ
- パフォーマンス統計表示 (管理者のみ)

---

### inc/contact-logic.php - フォーム処理

**セキュリティ:**
- CSRF保護 (nonce)
- ハニーポットスパム対策
- レート制限 (1時間あたり5送信/IP)
- Cloudflare/プロキシ対応IPアドレス取得
- スパムワードフィルタリング
- メッセージ長制限 (5000文字)

**処理機能:**
- データサニタイズ・バリデーション
- 管理者へのメール送信
- 自動返信メール
- データベース保存オプション
- カテゴリ別ルーティング

**AJAX対応:**
- 非同期送信エンドポイント
- JSONレスポンス

---

## カスタム投稿タイプ

### Tools (エコシステム)

```php
// URL: /tools/
// REST API: 有効
// サポート: title, editor, thumbnail, excerpt, custom-fields
```

ツールやサービスを紹介するためのカスタム投稿タイプ。

### Contact Submissions (お問い合わせ)

```php
// 非公開 (管理者のみ)
// お問い合わせフォーム送信の保存用
```

---

## ウィジェットエリア

| ID | 名称 | 配置場所 |
|----|------|---------|
| `sidebar-1` | サイドバー | メディアページ右側 |
| `footer-1` | フッター左 | フッターエリア |
| `footer-2` | フッター中央 | フッターエリア |
| `footer-3` | フッター右 | フッターエリア |

---

## ナビゲーションメニュー

| 位置 | 用途 |
|------|------|
| `primary` | メインナビゲーション |
| `footer` | フッターリンク |
| `mobile` | モバイル専用メニュー |

---

## CSS設計

### CSS変数 (カスタムプロパティ)

```css
:root {
  /* カラー */
  --color-primary: #2563eb;
  --color-secondary: #64748b;
  --color-accent: #f59e0b;

  /* タイポグラフィ */
  --font-sans: 'Noto Sans JP', sans-serif;
  --font-mono: 'JetBrains Mono', monospace;

  /* スペーシング */
  --spacing-1: 0.25rem;
  /* ... 13段階のスケール */
  --spacing-13: 6rem;

  /* レイアウト */
  --max-width: 1200px;
  --max-width-narrow: 800px;

  /* シャドウ */
  --shadow-sm: /* ... */;
  --shadow-xl: /* ... */;

  /* トランジション */
  --transition-fast: 150ms;
  --transition-base: 200ms;
}
```

### コンポーネント

- ボタン (`.btn`, `.btn-primary`, `.btn-outline`, `.btn-ghost`)
- アラート (`.alert-success`, `.alert-error`, etc.)
- カード
- グリッドシステム
- フォーム
- バッジ/ラベル
- プログレスバー
- スケルトンローダー

---

## JavaScript機能

### 初期化される機能

```javascript
document.addEventListener('DOMContentLoaded', () => {
  initMobileMenu();       // モバイルメニュー
  initSearchOverlay();    // 検索オーバーレイ
  initBackToTop();        // トップへ戻るボタン
  initSmoothScroll();     // スムーズスクロール
  initTableOfContents();  // 目次自動生成
  initShareButtons();     // シェアボタン
  initContactForm();      // お問い合わせフォーム
  initToolsFilter();      // ツールフィルター
  initHeaderScroll();     // ヘッダースクロール効果
  initCounterAnimation(); // 数字カウントアニメーション
  initFAQAccordion();     // FAQアコーディオン
});
```

### 主要機能

| 機能 | 説明 |
|------|------|
| モバイルメニュー | ハンバーガーメニュー、ESCキー閉じ |
| 検索オーバーレイ | モーダル検索、フォーカス管理 |
| 目次生成 | H2/H3から自動生成、ジャンプリンク |
| シェアボタン | Twitter, Facebook, はてな, URLコピー |
| フォームバリデーション | リアルタイム検証、文字数カウンター |
| ツールフィルター | カテゴリ別フィルタリング |
| カウンターアニメーション | 数値の動的表示 |

---

## ページタイプ

テーマは6種類のページタイプを自動判定:

| タイプ | 判定条件 | 用途 |
|--------|---------|------|
| `corporate` | front-page.php | コーポレートトップ |
| `service` | page-resumake.php | サービスLP |
| `contact` | page-contact.php | お問い合わせ |
| `media` | home.php, archive | メディア/ブログ |
| `article` | single.php | 記事詳細 |
| `ecosystem` | archive-tools.php | ツール一覧 |

---

## 機能一覧

### パフォーマンス
- ネイティブLazy Loading
- アセットdefer読み込み
- CSSプリロード
- フォント最適化
- クエリ文字列削除
- 不要ヘッダー削除
- Server Pushヘッダー
- ローカルフォントホスティング（GDPR対応）

### SEO
- 完全なメタタグ生成
- Schema.org構造化データ
- OGPタグ
- Twitter Card
- パンくずスキーマ
- 自動見出しID
- E-E-A-T著者プロフィール強化
  - カスタム著者フィールド（役職、専門分野、資格、経験年数）
  - Person Schema自動出力
- AI検索対応
  - Speakable構造化データ
  - Google AI Overview / SGE最適化
- Featured Snippet最適化
  - 定義ボックスショートコード
  - キーポイント/要約ショートコード
  - 比較テーブルショートコード
- ピクセルトラッカー統合
  - Meta Pixel (Facebook/Instagram)
  - LINE Tag
  - X (Twitter) Pixel
  - TikTok Pixel
  - Pinterest Tag
  - LinkedIn Insight Tag

### セキュリティ
- CSRF保護
- レート制限
- スパム対策
- ファイルアップロード制限
- コメントHTML制限
- XML-RPC無効化
- REST API制限
- セキュリティヘッダー
- ログイン試行制限

### UX
- スムーズスクロール
- モバイルレスポンシブ
- ハンバーガーメニュー
- 検索オーバーレイ
- トップへ戻るボタン
- シェアボタン
- 読了プログレスバー
- 目次自動生成
- 関連記事
- 人気記事ウィジェット
- アクセシビリティ対応
- ダークモード（システム設定連動）

### モダン対応
- PWA (Progressive Web App)
  - manifest.json
  - Service Worker（オフラインキャッシュ）
  - ホーム画面追加対応
- AMP (Accelerated Mobile Pages)
  - 投稿ページAMP対応
  - amp-img, amp-iframe, amp-youtube変換
  - AMPアナリティクス
- Critical CSS（ファーストビュー最適化）
- WebP自動変換
  - アップロード時自動生成
  - pictureタグ自動出力
- FAQ/HowTo構造化データ

### 収益化
- 14個の収益化ショートコード
- アフィリエイト商品ボックス
- 商品比較表
- CTA自動挿入
- 投稿別CTA制御
- 複数CTAスタイル
- スカーシティマーケティング
  - カウントダウンタイマー
  - 期間限定バッジ
  - 残り在庫表示

---

## 日本語対応

- 全文字列は `__()` / `esc_html__()` で翻訳対応
- テキストドメイン: `pout-theme`
- 日本語デフォルトコンテンツ
- 日本語日付フォーマット
- 日本語文字数ベースの読了時間計算 (600文字/分)

---

## 動作要件

- WordPress 6.0以上
- PHP 8.0以上
- MySQL 5.7以上 または MariaDB 10.3以上

---

## ライセンス

GNU General Public License v2 or later
