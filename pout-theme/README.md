<div align="center">

# Pout Theme

**コーポレート & メディア ハイブリッド WordPress テーマ**

高速 • SEO最適化 • 収益化対応 • AI検索対応

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.0+-purple.svg)
![WordPress](https://img.shields.io/badge/WordPress-6.0+-blue.svg)
![License](https://img.shields.io/badge/license-GPL--2.0+-green.svg)

<!-- デモ画像: テーマのヒーロースクリーンショット -->
![Pout Theme Hero](assets/images/demo/hero-screenshot.png)

[機能紹介](#-features) • [クイックスタート](#-quick-start) • [ドキュメント](#-documentation) • [カスタマイズ](#-customization)

</div>

---

## 目次

- [概要](#概要)
- [デモ](#-demo)
- [機能一覧](#-features)
- [クイックスタート](#-quick-start)
- [ディレクトリ構成](#-directory-structure)
- [テンプレートガイド](#-template-guide)
- [ショートコード](#-shortcodes)
- [カスタマイザー設定](#-customizer)
- [SEO機能](#-seo)
- [パフォーマンス](#-performance)
- [セキュリティ](#-security)
- [アクセシビリティ](#-accessibility)
- [開発者向け](#-for-developers)
- [トラブルシューティング](#-troubleshooting)
- [更新履歴](#-changelog)
- [ライセンス](#-license)

---

## 概要

Pout Themeは、**企業サイト**と**メディアサイト**を1つのテーマで運用できるハイブリッドWordPressテーマです。

### このテーマが最適な方

- **コーポレートサイト**を運営したい企業
- **オウンドメディア**を同時に展開したい企業
- **SEO**と**パフォーマンス**を重視する方
- **AI検索（Google SGE/AI Overview）** に対応したい方
- **収益化**（アフィリエイト・広告）を行いたいメディア運営者

### 基本情報

| 項目 | 内容 |
|:-----|:-----|
| テーマ名 | Pout Theme |
| バージョン | 1.0.0 |
| 作者 | Pout Inc. |
| 必須 PHP | 8.0以上 |
| 必須 WordPress | 6.0以上 |
| 動作確認済み | WordPress 6.4 |
| ライセンス | GPL v2 or later |

---

## Demo

### コーポレートトップページ

<!-- デモ画像: フロントページのスクリーンショット -->
![Corporate Top Page](assets/images/demo/corporate-top.png)

**特徴:**
- ヒーローセクション（動画/画像対応）
- サービス紹介カード
- 実績・数字セクション（カウントアップアニメーション）
- お客様の声
- CTA（Call to Action）セクション

### メディア/ブログページ

<!-- デモ画像: ブログページのスクリーンショット -->
![Media Page](assets/images/demo/media-page.png)

**特徴:**
- フィーチャード記事
- カテゴリ別グリッド表示
- サイドバー（人気記事ウィジェット）
- 無限スクロール対応

### 記事詳細ページ

<!-- デモ画像: 記事詳細のスクリーンショット -->
![Article Detail](assets/images/demo/article-detail.png)

**特徴:**
- 目次自動生成（TOC）
- 読了プログレスバー
- 著者プロフィール（E-E-A-T対応）
- シェアボタン
- 関連記事
- CTA自動挿入

### ダークモード

<!-- デモ画像: ダークモードのスクリーンショット -->
![Dark Mode](assets/images/demo/dark-mode.png)

**特徴:**
- システム設定に連動
- 手動切り替えボタン
- 全コンポーネント対応
- FOUC（Flash of Unstyled Content）防止

### モバイル表示

<!-- デモ画像: モバイル表示のスクリーンショット -->
<p align="center">
<img src="assets/images/demo/mobile-view.png" alt="Mobile View" width="300">
</p>

**特徴:**
- レスポンシブデザイン
- モバイル専用メニュー
- タッチターゲット最適化
- PWA（ホーム画面追加）対応

---

## Features

### SEO & AI検索対応

| 機能 | 説明 |
|:-----|:-----|
| **構造化データ** | Organization, Article, BreadcrumbList, FAQPage, HowTo |
| **E-E-A-T著者情報** | 著者の専門性・資格・経験を構造化データで出力 |
| **Speakable** | Google AI Overview / 音声検索対応 |
| **Featured Snippet** | 定義ボックス、キーポイント、比較テーブル |
| **OGP / Twitter Card** | SNSシェア最適化 |

### パフォーマンス

| 機能 | 説明 |
|:-----|:-----|
| **Critical CSS** | ファーストビュー最適化 |
| **WebP自動変換** | 画像アップロード時に自動生成 |
| **Lazy Loading** | 画像・iframe の遅延読み込み |
| **プリフェッチ** | ホバー時に次ページを先読み |
| **ローカルフォント** | Google Fonts をローカルホスト（GDPR対応） |

### モダン機能

| 機能 | 説明 |
|:-----|:-----|
| **PWA** | Service Worker、オフラインキャッシュ |
| **AMP** | 投稿ページの AMP 対応 |
| **ダークモード** | システム設定連動 + 手動切り替え |
| **Core Web Vitals** | LCP, FID, CLS 測定対応 |

### 収益化

| 機能 | 説明 |
|:-----|:-----|
| **CTA自動挿入** | H2見出し後・記事末尾に自動挿入 |
| **アフィリエイトボックス** | 商品紹介用ショートコード |
| **比較テーブル** | 商品比較表ショートコード |
| **カウントダウン** | 期限訴求・スカーシティ |
| **ピクセルトラッカー** | Meta, LINE, X, TikTok, Pinterest, LinkedIn |

### セキュリティ

| 機能 | 説明 |
|:-----|:-----|
| **ログイン試行制限** | ブルートフォース攻撃対策 |
| **スパム対策** | ハニーポット、レート制限 |
| **セキュリティヘッダー** | XSS, Clickjacking 対策 |
| **REST API制限** | ユーザー情報の漏洩防止 |

---

## Quick Start

### 1. テーマのインストール

```bash
# テーマディレクトリにコピー
cp -r pout-theme /path/to/wordpress/wp-content/themes/
```

または WordPress 管理画面からZIPファイルをアップロード。

### 2. テーマの有効化

**外観** → **テーマ** → **Pout Theme** を有効化

### 3. 初期設定

1. **外観** → **カスタマイズ** を開く
2. 以下を設定:
   - サイトロゴ
   - カラー設定
   - SEO設定（GA/GTM ID）
   - 会社情報
   - SNSリンク

### 4. メニューの設定

**外観** → **メニュー** で以下を設定:
- メインメニュー（`primary`）
- フッターメニュー（`footer`）
- モバイルメニュー（`mobile`）

### 5. 固定ページの作成

以下のページを作成し、テンプレートを割り当て:

| ページ | テンプレート | 備考 |
|:-------|:-------------|:-----|
| トップページ | `front-page.php` | フロントページに設定 |
| お問い合わせ | `page-contact.php` | スラッグ: `contact` |
| サービスLP | `page-resumake.php` | スラッグ: `resumake` |

---

## Directory Structure

```
pout-theme/
│
├── assets/                      # 静的アセット
│   ├── css/
│   │   └── main.css            # メインスタイルシート
│   ├── js/
│   │   └── scripts.js          # メインJavaScript
│   ├── fonts/                  # ローカルフォント（オプション）
│   └── images/
│       └── demo/               # デモ画像
│
├── inc/                        # PHPモジュール
│   ├── seo.php                 # SEO・構造化データ・ピクセル
│   ├── shortcodes.php          # ショートコード定義
│   ├── cta.php                 # CTA自動挿入
│   ├── optimization.php        # パフォーマンス・セキュリティ
│   ├── advanced-ux.php         # UX拡張・ダークモード
│   ├── extras.php              # ユーティリティ
│   ├── contact-logic.php       # フォーム処理
│   └── amp.php                 # AMP対応
│
├── Template Files              # テンプレートファイル
│   ├── front-page.php          # コーポレートトップ
│   ├── home.php                # ブログトップ
│   ├── single.php              # 記事詳細
│   ├── page-contact.php        # お問い合わせ
│   ├── page-resumake.php       # サービスLP
│   ├── archive-tools.php       # ツール一覧
│   ├── index.php               # アーカイブ
│   ├── header.php              # ヘッダー
│   └── footer.php              # フッター
│
├── functions.php               # テーマ初期化
├── style.css                   # テーマメタデータ
├── manifest.json               # PWAマニフェスト
├── sw.js                       # Service Worker
└── README.md                   # このファイル
```

---

## Template Guide

### ページタイプ自動判定

テーマはURLとテンプレートから自動的にページタイプを判定し、適切なレイアウトを適用します。

```
┌─────────────────┬──────────────────────┬──────────────────────┐
│   ページタイプ   │      テンプレート      │        特徴          │
├─────────────────┼──────────────────────┼──────────────────────┤
│ corporate       │ front-page.php       │ 透過ヘッダー, CTA    │
│ service         │ page-resumake.php    │ 透過ヘッダー, FAQ    │
│ contact         │ page-contact.php     │ フォーム, バリデーション│
│ media           │ home.php / archive   │ サイドバー, グリッド  │
│ article         │ single.php           │ 目次, 読了バー       │
│ ecosystem       │ archive-tools.php    │ フィルター, バッジ   │
└─────────────────┴──────────────────────┴──────────────────────┘
```

### テンプレート階層図

```
                    ┌─────────────────┐
                    │   front-page    │ ← トップページ
                    └────────┬────────┘
                             │
         ┌───────────────────┼───────────────────┐
         │                   │                   │
   ┌─────┴─────┐      ┌──────┴──────┐     ┌──────┴──────┐
   │   home    │      │   single    │     │    page     │
   │ (ブログ)  │      │  (記事)     │     │  (固定)     │
   └───────────┘      └─────────────┘     └──────┬──────┘
                                                  │
                                    ┌─────────────┼─────────────┐
                                    │             │             │
                             ┌──────┴──────┐ ┌────┴────┐ ┌──────┴──────┐
                             │page-contact │ │page-LP  │ │  default    │
                             └─────────────┘ └─────────┘ └─────────────┘
```

---

## Shortcodes

### コンテンツ装飾

#### ボタン

```
[pout_button url="https://example.com" text="詳しく見る" style="primary" size="lg"]
```

**パラメータ:**
| パラメータ | 値 | デフォルト |
|:-----------|:---|:-----------|
| `style` | `primary`, `outline`, `ghost` | `primary` |
| `size` | `sm`, `md`, `lg`, `xl` | `md` |
| `target` | `_self`, `_blank` | `_self` |

<!-- デモ画像: ボタンバリエーション -->
![Button Variations](assets/images/demo/shortcode-buttons.png)

#### 通知ボックス

```
[pout_notice type="info" title="お知らせ"]
ここに通知内容を記載します。
[/pout_notice]
```

**タイプ:**
- `info` - 情報（青）
- `success` - 成功（緑）
- `warning` - 警告（黄）
- `error` - エラー（赤）

<!-- デモ画像: 通知ボックスバリエーション -->
![Notice Boxes](assets/images/demo/shortcode-notices.png)

#### 吹き出し

```
[pout_balloon name="太郎" image="https://..." position="left"]
こんにちは！
[/pout_balloon]
```

<!-- デモ画像: 吹き出し表示 -->
![Balloon](assets/images/demo/shortcode-balloon.png)

#### アコーディオン

```
[pout_accordion]
[pout_accordion_item title="質問1" open="true"]回答1[/pout_accordion_item]
[pout_accordion_item title="質問2"]回答2[/pout_accordion_item]
[/pout_accordion]
```

<!-- デモ画像: アコーディオン表示 -->
![Accordion](assets/images/demo/shortcode-accordion.png)

### 収益化

#### アフィリエイトボックス

```
[pout_affiliate
  name="商品名"
  image="https://..."
  price="¥1,980"
  rating="4.5"
  url="https://..."
  badge="おすすめ"
]
```

<!-- デモ画像: アフィリエイトボックス -->
![Affiliate Box](assets/images/demo/shortcode-affiliate.png)

#### 商品比較表

```
[pout_comparison]
[pout_comparison_item name="商品A" price="¥1,000" rating="4" features="機能1,機能2" url="..." featured="true"]
[pout_comparison_item name="商品B" price="¥2,000" rating="5" features="機能1,機能2,機能3" url="..."]
[/pout_comparison]
```

<!-- デモ画像: 比較表 -->
![Comparison Table](assets/images/demo/shortcode-comparison.png)

#### CTAボックス

```
[pout_cta
  title="今すぐ始めよう"
  description="30日間無料トライアル"
  button_text="無料で始める"
  button_url="/signup"
  style="highlight"
]
```

<!-- デモ画像: CTAボックス -->
![CTA Box](assets/images/demo/shortcode-cta.png)

### スカーシティ（緊急性訴求）

#### カウントダウンタイマー

```
[pout_countdown
  date="2025-12-31 23:59:59"
  title="キャンペーン終了まで"
  style="urgent"
]
```

**スタイル:**
- `default` - ダークグラデーション
- `minimal` - シンプル
- `urgent` - 赤色＋パルスアニメーション

<!-- デモ画像: カウントダウンタイマー -->
![Countdown Timer](assets/images/demo/shortcode-countdown.png)

#### 期間限定バッジ

```
[pout_limited_badge text="期間限定50%OFF" end_date="2025-12-31" style="urgent"]
```

#### 在庫表示

```
[pout_stock current="3" total="100" style="bar"]
```

<!-- デモ画像: スカーシティ要素 -->
![Scarcity Elements](assets/images/demo/shortcode-scarcity.png)

### SEO最適化

#### 定義ボックス（Featured Snippet対応）

```
[definition term="SEO"]
検索エンジン最適化（Search Engine Optimization）の略で、
Webサイトを検索結果で上位表示させるための施策です。
[/definition]
```

<!-- デモ画像: 定義ボックス -->
![Definition Box](assets/images/demo/shortcode-definition.png)

#### キーポイント

```
[key_takeaway title="この記事のポイント" type="checklist"]
- ポイント1
- ポイント2
- ポイント3
[/key_takeaway]
```

**タイプ:**
- `summary` - 要約（黄色）
- `checklist` - チェックリスト（緑）
- `steps` - 手順（紫）

<!-- デモ画像: キーポイント -->
![Key Takeaway](assets/images/demo/shortcode-keytakeaway.png)

#### 比較テーブル（パイプ区切り）

```
[comparison_table]
項目|プランA|プランB|プランC
月額|無料|¥1,000|¥3,000
機能|基本|標準|フル
サポート|なし|メール|電話
[/comparison_table]
```

<!-- デモ画像: 比較テーブル -->
![Comparison Table](assets/images/demo/shortcode-table.png)

---

## Customizer

### アクセス方法

**外観** → **カスタマイズ** から各設定にアクセス

### 設定セクション一覧

```
カスタマイズ
│
├── サイト基本情報
│   ├── サイトのタイトル
│   ├── キャッチフレーズ
│   └── サイトアイコン
│
├── SEO設定
│   ├── Google Analytics ID (G-XXXXXXXXXX)
│   ├── GTM ID (GTM-XXXXXXX)
│   ├── デフォルトOGP画像
│   └── Twitter アカウント
│
├── 会社情報
│   ├── 会社名
│   ├── 電話番号
│   ├── メールアドレス
│   └── 住所
│
├── SNSリンク
│   ├── Twitter (X)
│   ├── Facebook
│   ├── LinkedIn
│   ├── YouTube
│   └── Instagram
│
├── ピクセルトラッカー
│   ├── Meta Pixel ID
│   ├── LINE Tag ID
│   ├── X (Twitter) Pixel ID
│   ├── TikTok Pixel ID
│   ├── Pinterest Tag ID
│   └── LinkedIn Partner ID
│
├── CTA設定
│   ├── 有効/無効
│   ├── 挿入位置（H2見出し番号）
│   ├── CTAタイプ
│   ├── タイトル・説明文
│   ├── ボタンテキスト・URL
│   └── 除外カテゴリ
│
└── フォント設定
    ├── ローカルフォント有効化
    └── 日本語フォント選択
        ├── Noto Sans JP
        ├── Zen Kaku Gothic New
        └── システムフォント
```

---

## SEO

### 構造化データ出力

テーマは以下の構造化データを自動出力します:

#### 全ページ共通

```json
{
  "@context": "https://schema.org",
  "@graph": [
    { "@type": "Organization", ... },
    { "@type": "WebSite", "potentialAction": { "@type": "SearchAction", ... }}
  ]
}
```

#### 記事ページ

```json
{
  "@type": "Article",
  "headline": "...",
  "author": { "@type": "Person", "name": "..." },
  "publisher": { "@id": "/#organization" },
  "datePublished": "...",
  "dateModified": "..."
}
```

#### E-E-A-T著者情報

ユーザープロフィールで設定された情報を元に Person Schema を出力:

```json
{
  "@type": "Person",
  "name": "山田太郎",
  "jobTitle": "シニアエンジニア",
  "knowsAbout": ["SEO", "Web開発", "マーケティング"],
  "hasCredential": [
    { "@type": "EducationalOccupationalCredential", "name": "Google認定資格" }
  ],
  "worksFor": { "@type": "Organization", "name": "株式会社Pout" },
  "sameAs": ["https://linkedin.com/...", "https://twitter.com/..."]
}
```

#### Speakable（AI検索対応）

記事ページで読み上げ対象を指定:

```json
{
  "@type": "WebPage",
  "speakable": {
    "@type": "SpeakableSpecification",
    "cssSelector": [".article-title", ".article-summary", ".definition-box"]
  }
}
```

### メタタグ出力

```html
<!-- 基本メタ -->
<meta name="description" content="...">
<meta name="robots" content="index, follow">
<link rel="canonical" href="...">

<!-- OGP -->
<meta property="og:type" content="article">
<meta property="og:title" content="...">
<meta property="og:description" content="...">
<meta property="og:image" content="...">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="...">
```

---

## Performance

### 最適化機能一覧

| 機能 | 効果 | デフォルト |
|:-----|:-----|:-----------|
| Critical CSS | LCP改善 | 有効 |
| CSS非同期読み込み | レンダリングブロック解消 | 有効 |
| スクリプトdefer | レンダリングブロック解消 | 有効 |
| 画像Lazy Loading | 初期ロード軽量化 | 有効 |
| WebP自動変換 | 画像サイズ削減 | 有効 |
| プリフェッチ | 体感速度向上 | 有効 |
| ローカルフォント | 外部リクエスト削減 | 設定で有効化 |
| 不要ヘッダー削除 | HTMLサイズ削減 | 有効 |

### PageSpeed Insights スコア目安

```
┌─────────────────────────────────────────────┐
│         Performance Score                    │
│                                             │
│  Mobile:   ████████████████████░░  90-95    │
│  Desktop:  █████████████████████░  95-100   │
│                                             │
│  LCP:    < 2.5s ✓                           │
│  FID:    < 100ms ✓                          │
│  CLS:    < 0.1 ✓                            │
└─────────────────────────────────────────────┘
```

### Core Web Vitals 測定

管理者ログイン時、ブラウザのコンソールに測定結果を出力:

```javascript
// コンソール出力例
LCP: 1234.56 ms
FID: 12.34 ms
CLS: 0.0123
```

---

## Security

### 実装済みセキュリティ対策

```
┌─────────────────────────────────────────────────────────┐
│                  Security Layers                         │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌─────────────────┐   ┌─────────────────────────────┐ │
│  │  HTTP Headers   │   │  Application Security        │ │
│  │                 │   │                             │ │
│  │  X-Frame-Options│   │  CSRF Protection (nonce)   │ │
│  │  X-XSS-Protection   │  Rate Limiting             │ │
│  │  X-Content-Type │   │  Login Attempt Limit       │ │
│  │  Referrer-Policy│   │  Spam Honeypot             │ │
│  └─────────────────┘   └─────────────────────────────┘ │
│                                                          │
│  ┌─────────────────┐   ┌─────────────────────────────┐ │
│  │  API Security   │   │  File Security              │ │
│  │                 │   │                             │ │
│  │  XML-RPC: OFF   │   │  Upload MIME Restriction   │ │
│  │  REST /users: ✗ │   │  File Editor: Disabled     │ │
│  │  REST API Limit │   │  Revision Limit: 5         │ │
│  └─────────────────┘   └─────────────────────────────┘ │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

### ログイン試行制限

- **最大試行回数:** 5回
- **ロックアウト時間:** 15分
- **対象:** IPアドレスベース

### お問い合わせフォーム保護

- **CSRF:** nonce検証
- **スパム:** ハニーポットフィールド
- **レート制限:** 1時間に5送信/IP
- **文字数制限:** 5,000文字

---

## Accessibility

### 対応状況

| 項目 | 対応 |
|:-----|:-----|
| キーボードナビゲーション | ○ |
| スクリーンリーダー対応 | ○ |
| フォーカス表示 | ○ (`focus-visible`) |
| スキップリンク | ○ |
| カラーコントラスト | ○ (WCAG AA) |
| モーション軽減設定対応 | ○ |

### アクセシビリティ機能

```html
<!-- スキップリンク -->
<a class="skip-link screen-reader-text" href="#main-content">
  コンテンツへスキップ
</a>

<!-- ARIAラベル -->
<nav role="navigation" aria-label="メインメニュー">
<button aria-expanded="false" aria-controls="mobile-menu">

<!-- ライブリージョン -->
<div aria-live="polite" id="sr-announcer"></div>
```

### モーション軽減対応

```css
@media (prefers-reduced-motion: reduce) {
  html {
    scroll-behavior: auto;
  }
  *, *::before, *::after {
    animation-duration: 0.01ms !important;
    transition-duration: 0.01ms !important;
  }
}
```

---

## For Developers

### フック一覧

#### アクションフック

| フック | 場所 | 用途 |
|:-------|:-----|:-----|
| `pout_before_header` | header.php | ヘッダー前 |
| `pout_after_header` | header.php | ヘッダー後 |
| `pout_before_footer` | footer.php | フッター前 |
| `pout_after_article_content` | single.php | 記事本文後 |

#### フィルターフック

| フィルター | 引数 | 用途 |
|:-----------|:-----|:-----|
| `pout_cta_html` | $html | CTA HTML変更 |
| `pout_reading_time` | $time, $post_id | 読了時間計算 |
| `pout_amp_enabled` | $bool | AMP有効/無効 |

### カスタムフィールド

#### 投稿メタ

| キー | 用途 |
|:-----|:-----|
| `_pout_disable_cta` | CTA非表示フラグ |
| `_pout_views_count` | 閲覧数 |

#### ユーザーメタ（E-E-A-T）

| キー | 用途 |
|:-----|:-----|
| `pout_job_title` | 役職・肩書き |
| `pout_expertise` | 専門分野 |
| `pout_credentials` | 資格・認定 |
| `pout_experience_years` | 経験年数 |
| `pout_organization` | 所属組織 |
| `pout_linkedin` | LinkedIn URL |
| `pout_twitter` | X (Twitter) URL |

### JavaScript API

```javascript
// ダークモード
window.poutDarkMode.toggle();           // 切り替え
window.poutDarkMode.setTheme('dark');   // 明示的に設定
window.poutDarkMode.getTheme();         // 現在のテーマ取得

// コンバージョントラッキング
pout_track_conversion('Lead', { value: 1000 });
```

### REST APIエンドポイント

| エンドポイント | メソッド | 用途 |
|:--------------|:---------|:-----|
| `/wp-json/pout/v1/contact` | POST | お問い合わせ送信 |
| `/wp-json/pout/v1/views` | POST | 閲覧数カウント |

---

## Troubleshooting

### よくある問題

#### ダークモードが動作しない

1. ブラウザのlocalStorageが有効か確認
2. ブラウザキャッシュをクリア
3. 他のプラグインとの競合を確認

#### CTAが表示されない

1. **カスタマイズ** → **CTA設定** で有効化されているか確認
2. 投稿編集画面で「CTAを無効化」にチェックが入っていないか確認
3. 除外カテゴリに該当していないか確認

#### WebPが生成されない

1. PHPのGDライブラリがインストールされているか確認:
   ```php
   <?php phpinfo(); // imagecreatefromjpeg, imagewebp を確認
   ```
2. アップロードディレクトリの書き込み権限を確認

#### ローカルフォントが適用されない

1. `assets/fonts/` ディレクトリが存在するか確認
2. フォントファイル（.woff2）が配置されているか確認
3. カスタマイザーで「ローカルフォントを使用」が有効か確認

### デバッグモード

`wp-config.php` に以下を追加:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

ログは `wp-content/debug.log` に出力されます。

---

## Changelog

### v1.0.0 (2024-12-22)

#### 新機能
- 初回リリース
- コーポレート & メディアハイブリッド対応
- 14個のショートコード
- E-E-A-T著者プロフィール強化
- Speakable構造化データ
- Featured Snippet最適化ショートコード
- ピクセルトラッカー統合（6プラットフォーム）
- ローカルフォントホスティング
- スカーシティマーケティング機能
- PWA / AMP対応
- ダークモード
- Core Web Vitals計測

---

## License

GNU General Public License v2 or later

```
Pout Theme - Professional WordPress Theme
Copyright (C) 2024 Pout Inc.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
```

---

<div align="center">

**Pout Theme** by [Pout Inc.](https://pout.co.jp/)

Made with ♥ in Japan

</div>
