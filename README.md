# engineerEvaluation

-   とりあえず今までの調査結果(https://github.com/SakaiTaka23/GitSampleSurvey)をもとにロジックを作成しユーザーの評価ができるようにする

## インストール

### Laravel Sail

https://laravel.com/docs/8.x/sail

```shell
git clone https://github.com/SakaiTaka23/instagram_clean.git
cd instagram_clean

cp .env.sail.example .env

docker run --rm \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install

sail up -d

sail artisan key:generate
sail artisan migrate:fresh
```

## Route

| Method | URL        | Action |
| ------ | ---------- | ------ |
| GET    | /          | -      |
| GET    | /valuation | index  |
| POST   | /valuation | result |

-   /にはランディングページや計算ロジック、背景を置く
-   ランディングページにはアルゴリズムも書く、場所がありそうなら index ルートのフォームも付け足す？

## ビューに渡す要素

| route            | value needed               |
| ---------------- | -------------------------- |
| /                | -                          |
| /valuation(GET)  | - フォームを渡すだけ       |
| /valuation(POST) | 名前、個々の値、評価の結果 |

## モデル・DB

-   モデルはいらないかも？
-   DB はいらない

## エンジニア評価の方針

1. 必要な値取得
2. オフセット・ランク値の計算 ← ユーザー関係なく固定値
3. ユーザーデータ＋オフセットの計算
4. 累積分布関数を使って評価点数計算
5. 評価点をもとにランクを計算

## ランク

-   改善の余地あり

| 評価 | 重みの値  | 上位%    |
| ---- | --------- | -------- |
| S+   | ~49       | 1        |
| S    | 49~49.4   | 25       |
| A++  | 49.5~49.9 | 45       |
| A+   | 50~50.9   | 60       |
| B+   | 51~       | それ以下 |

## ロジックの実装ルール

-   基本的に必要になる関数は app/Service に記述
-   Service にはインターフェース
-   Production にはその実装
-   データの取得、データ計算は別クラスに作成

## ロジックのクラス

-   それぞれにはその名前＋ Interface のインターフェースを作成

### CalculateRank

-   [x]
-   ユーザーの評価に関するクラス
-   下のクラスの関数を順番に実行、累積分布
-   最終的なランク、点数を返却(小数第３まで)

#### 順番

1. FetchGitHubAPI
2. OffsetData
3. normalcdf(累積分布)、四捨五入
4. RankData

### FetchGitHubAPI

-   [x]
-   ユーザーのデータを取得するクラス
-   ~~api を叩くには laravel-github を使用~~
-   api は自力で叩いてみる
-   各要素のデータを取得するものは private
-   各要素のデータを取得する、それらの関数の結果をまとめて返す

#### 順番

-   同時に複数取れる関数はその url を叩く専用の関数を作る？

1. public_repo,followers→https://api.github.com/users/SakaiTaka23

2. pull_requests→https://api.github.com/search/issues?q=is:pr+author:SakaiTaka23

3. issues→https://api.github.com/search/issues?q=+is:issue+user:SakaiTaka23

4. commit_sum,star_sum→https://api.github.com/users/SakaiTaka23/repos forkrepo も取れるので除ける 空リポジトリの場合の例外処理をする

    https://api.github.com/repos/SakaiTaka23/chase/commits?per_page=100&page=2

### OffsetData

-   [x]
-   計算途中のオフセットの保存、計算をするクラス
-   オフセットは全て private
-   オフセット合計返却、ユーザーの値をもとにスコアを計算する

### RankData

-   [x]
-   ユーザー評価のランクを保存、計算するクラス
-   ランクはその値以下であるかどうかで判断
-   ランク値は全て private
-   ランク合計、スコアからランクを出す

## 今の課題

-   api トークンの扱い → 自分以外のユーザーもいるので自分のものだけでは厳しそう

## TODO

-   [x] php cx fixer ,php docs 適用
-   [x] fetchData を FetchGitHubAPI に直す
-   [ ] fetchData 内の fetch を修正
-   [ ] setName 修正

## Features

-   [ ] 全体の改良

-   [ ] 1. DB にデータを保存
-   [ ] 2. ロジックをコマンド化
-   [ ] 3. mail を作ってみる

-   [ ] 共有しやすくする
-   [ ] 1. twitter 拡散ボタン
-   [ ] 2. twitter card 作成
