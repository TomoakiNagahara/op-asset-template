# Translation Template

## 目的

`translation.php` と `translation.phtml` は、Translation Service UI のための共通テンプレート部品です。

ページまたは layout が framework translation service を表示する場合は、この 2 つを組み合わせて使います。

この分割は、必要な JavaScript と CSS の登録を維持したまま、表示 HTML を application 側でカスタマイズできるようにするためです。

## 責務

`translation.php` は、translation service に必要な WebPack asset を登録します。

- `asset:/webpack/js/Translator.js`
- `asset:/webpack/js/Translate_Language.js`
- `asset:/webpack/css/color.css`
- `asset:/webpack/css/Translate_Language.css`

`translation.phtml` は、標準の表示 HTML を出力します。

- `Translation Service` の見出し
- `id="op-translate-language-area"` を持つ言語選択エリア

表示 HTML は application または layout 側でカスタマイズできます。ただし、JavaScript は `id="op-translate-language-area"` を持つ要素を必要とします。`Translate_Language.js` は、その要素の中に言語選択 UI を描画します。

## 使い方

translation service の HTML を描画する前に、`translation.php` を呼び出します。

```php
<?php if( OP()->Config('execute')['translation'] ?? false ): ?>
	<?php OP()->Template('translation.php') ?>
	<?php OP()->Template('translation.phtml') ?>
<?php endif; ?>
```

言語選択 UI を動作させる必要がある場合、`translation.phtml` だけを呼び出してはいけません。HTML は出力されますが、WebPack asset の登録が抜けます。

標準 markup でよい場合は、表示 markup の所有者を 1 つにするため `translation.phtml` を使います。

独自 markup が必要な場合は、`translation.php` を呼び出したうえで、必須の language area ID を持つ要素を用意します。

```html
<div id="op-translate-language-area"></div>
```

## WebPack のタイミング

endpoint template は、layout head が grouped WebPack URL を出力する前に実行されます。

そのため、page template が `translation.php` を呼び出して translation asset を登録しても、その登録は `layout/head.phtml` が生成する WebPack hash に反映されます。

translation UI が個別 endpoint ではなく共有 page frame に属する場合は、layout 側でこの 2 つを呼び出しても構いません。

## 移行メモ

古い `translation.phtml` は、WebPack 登録と HTML 出力の両方を担当していました。

現在の仕様では、責務を分けています。

- WebPack 登録には `translation.php` を使う
- 標準 HTML 出力には `translation.phtml` を使う。または `id="op-translate-language-area"` を持つ独自 HTML を用意する

古い呼び出し側を更新する場合は、単独の `OP()->Template('translation.phtml')` 呼び出しを、上記の 2 段階の呼び出しに置き換えます。
