# engineerEvaluation



* とりあえず今までの調査結果(https://github.com/SakaiTaka23/GitSampleSurvey)をもとにロジックを作成しユーザーの評価ができるようにする



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

* /にはランディングページや計算ロジック、背景を置く



## ビューに渡す要素

| route      | value needed     |
| ---------- | ---------------- |
| /valuation | 調査から得た結果 |



## モデル・DB

* モデルはいらないかも？
* DBはいらない




## エンジニア評価の方針

1. 必要な値取得
2. オフセット・ランク値の計算←ユーザー関係なく固定値
3. ユーザーデータ＋オフセットの計算
4. 累積分布関数を使って評価点数計算
5. 評価点をもとにランクを計算



## ランク

* 改善の余地あり

| 評価 | 重みの値  | 上位%    |
| ---- | --------- | -------- |
| S+   | ~49       | 1        |
| S    | 49~49.4   | 25       |
| A++  | 49.5~49.9 | 45       |
| A+   | 50~50.9   | 60       |
| B+   | 51~       | それ以下 |



## ロジックの実装ルール

* 基本的に必要になる関数は app/Service に記述
* Serviceにはインターフェース
* Productionにはその実装
* データの取得、データ計算は別クラスに作成



## ロジックのクラス

* それぞれにはその名前＋Interfaceのインターフェースを作成

### CalculateRank
* [x] 
* ユーザーの評価に関するクラス
* 下のクラスの関数を順番に実行、累積分布
* 最終的なランク、点数を返却(小数第３まで)

#### 順番

1. FetchData
2. OffsetData
3. normalcdf(累積分布)、四捨五入
4. RankData

### FetchData
* [x] 
* ユーザーのデータを取得するクラス
* ~~apiを叩くにはlaravel-githubを使用~~
* apiは自力で叩いてみる
* 各要素のデータを取得するものはprivate
* 各要素のデータを取得する、それらの関数の結果をまとめて返す

#### 順番

* 同時に複数取れる関数はそのurlを叩く専用の関数を作る？

1. public_repo,followers→https://api.github.com/users/SakaiTaka23

2. pull_requests→https://api.github.com/search/issues?q=is:pr+author:SakaiTaka23

3. issues→https://api.github.com/search/issues?q=+is:issue+user:SakaiTaka23

4. commit_sum,star_sum→https://api.github.com/users/SakaiTaka23/repos forkrepoも取れるので除ける 空リポジトリの場合の例外処理をする

   https://api.github.com/repos/SakaiTaka23/chase/commits?per_page=100&page=2

### OffsetData
* [x] 
* 計算途中のオフセットの保存、計算をするクラス
* オフセットは全てprivate
* オフセット合計返却、ユーザーの値をもとにスコアを計算する
### RankData
* [x] 
* ユーザー評価のランクを保存、計算するクラス
* ランクはその値以下であるかどうかで判断
* ランク値は全てprivate
* ランク合計、スコアからランクを出す




## 今の課題

* apiトークンの扱い→自分以外のユーザーもいるので自分のものだけでは厳しそう



## TODO

* [x]  設計のドキュメント作成
* [x]  laravel-githubの使い方を調べる→自分の欲しい情報を考えると使う必要性はない気がする
* [x] ロジック作成
* [ ] コントローラー実装→**入力ユーザーの確認**
* [ ] 入力ページ、結果表示ページ作成
* [ ] ランディングページ作成

