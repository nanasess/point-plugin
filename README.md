# point-plugin（ポイントプラグイン）

[![Build Status](https://travis-ci.org/EC-CUBE/point-plugin.svg?branch=master)](https://travis-ci.org/EC-CUBE/point-plugin)
[![Coverage Status](https://coveralls.io/repos/github/EC-CUBE/point-plugin/badge.svg?branch=master)](https://coveralls.io/github/EC-CUBE/point-plugin?branch=master)

ポイント機能を提供します

# 管理機能
- ポイント設定
  - ポイントの確定ステータスの設定やその他設定を行います
- 受注登録・編集
  - 利用ポイント・加算ポイントの編集を行います
  - 受注ステータスが確定ステータスに変更された際に加算ポイントを確定します
- 会員登録・編集
  - 会員の保有ポイントを編集します
- 商品登録・編集
  - 商品ごとにポイント付与率を設定します

# フロント機能
- 商品詳細
  - 発行される加算ポイントを表示します
- カート
  - 発行される加算ポイントを表示します
- 購入
  - ポイントの利用や、購入完了時のポイント発行を行います
- マイページ
  - 保有ポイントを表示します
  - 注文履歴に利用ポイントや加算ポイントを表示します
