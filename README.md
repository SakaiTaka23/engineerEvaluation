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



## モデル

* いらないかも？



## DB

* いらない



## TODO

* [ ]  ロジック作成