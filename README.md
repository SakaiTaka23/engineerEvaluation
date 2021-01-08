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

| 評価 | 上位%           |
| ---- | --------------- |
| S+   | 1               |
| S    | 25              |
| A++  | 45              |
| A+   | 60              |
| B+   | それ以外(下40%) |





## ロジックの実装手順

### ルール

* 基本的に必要になる関数は app/Service に記述
* Serviceにはインターフェース
* Productionにはその実装






## 今の課題

* apiトークンの扱い→自分以外のユーザーもいるので自分のものだけでは厳しそう



## TODO

* [ ]  ロジック作成
* [ ] コントローラー実装
* [ ] ランディングページ作成

