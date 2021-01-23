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

### queue

```shell
# sail コンテナ内で
php artisan queue:work
# コンテナ外
sail artisan queue:work
```



## Route

| Method | URL        | Action |
| ------ | ---------- | ------ |
| GET    | /          | -      |
| GET    | /valuation | index  |
| POST   | /valuation | result |

-   /にはランディングページや計算ロジック、背景を置く
-   ランディングページにはアルゴリズムも書く、場所がありそうなら index ルートのフォームも付け足す？

## コントローラー

* 計算をさせると重くなってしまうため今回は機能を絞って作成

1. ユーザーの入力のバリデーション 名前に関しては本当にGitHub上に存在する名前かどうか判定
2. タスクを開始するためにカラムを作成
3. 作成したカラムのidを受け取りそのidをキューに設定
4. そのまま値は特に返さずビューを表示 **名前,emailあたりは確認のため返してもいいかも？**

## ビューに渡す要素

| route            | value needed |
| ---------------- | ------------ |
| /                | -            |
| /valuation(POST) | -            |

## DB

* Redisを採用しようと思ったが後にスケジュールを回すと考えるとmysqlが安定？
* 調査するユーザーの名前、タスク途中で出てくる値を保存

* スケジューラーの情報も保存

**users テーブル**

* 既に生成されたものを改変して使用

* 計算途中の値を保存

* 全ての値を保存するのではなく複数のクラスに引き渡す値のみを保存

  →たまたまユーザーに返却するデータとなった
  
* 将来的にはtask_finishedとか追加して5分ごとにスケジュールを回す感じかな？

* 後スケジュールが終わった後の送信先のメールアドレスが必要？

* いたずら防止のため依頼者のIPも欲しい

| カラム        | 型     |
| ------------- | ------ |
| id            | id     |
| name          | string |
| email         | string |
| public_repo   | int    |
| commit_sum    | int    |
| issues        | int    |
| pull_requests | int    |
| star_sum      | int    |
| followers     | int    |
| user_rank     | string |





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

* [x] 

-   ユーザーの評価に関するクラス
-   下のクラスの関数を順番に実行、累積分布
-   最終的には結果を格納したカラムのidを返却

#### 順番

1. FetchGitHubAPI
2. OffsetData
3. normalcdf(累積分布)、四捨五入
4. RankData

### FetchGitHubAPI

* [x] 

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

* [x] 

-   計算途中のオフセットの保存、計算をするクラス
-   オフセットは全て private
-   オフセット合計返却、ユーザーの値をもとにスコアを計算する

### RankData

* [x] 

-   ユーザー評価のランクを保存、計算するクラス
-   ランクはその値以下であるかどうかで判断
-   ランク値は全て private
-   ランク合計、スコアからランクを出す

## Repository

* app/Repositoriesに記載
* 一つしかないためインターフェース、クラスのフォルダ分けはしていない

**計算のため使用する順番**

1. setTask タスク実行のための初期設定として名前を登録しデータを作成 : evaluationの最初に使用
2. setUserStats fetchしたデータを一気に登録 : FetchGitHubAPIの最後に使用
3. getUserStats setUserStatsを受け取るために使用 : evaluationの途中で使用
4. setUserRank 計算後のランクを登録 : evaluationの最後に使用
5. finishTask まだ未実装 タスク終了フラグを立てる : evaluationの最後に使用

**その他**

* getResult : setUserRankから得られたidを受け取り結果を返す

## Command

* タスクをキューに入れる必要が出てきてその呼び出しを簡潔化させるためにコマンドを作成

### EvaluateCommand

* name,mailを受け取り必要な値をDBに格納、格納後のカラムのidを返却
* name,mailを受け取るのではなく事前にidを生成して計算しても良さそう

### SendResultCommand

* idを受け取ってそのカラムを取得、メールを送信

## Queue

* 今回はキューの数が少ないと考えられ早く処理したいのでRedisを採用

## TODO

-   [x] php cx fixer 
-   [x] php docs 適用
-   [x] FetchData を FetchGitHubAPI に直す
-   [x]  修正後のFetchGitHubAPI内の fetch を削除
-   [x] setName 修正→全ての引数に名前を取ることにした
-   [x] commandのドキュメントも作成
-   [x] 全体の改良
-   [ ] 共有しやすくする
-   [ ] メールの内容を整える ipとか入れてもいいかも
-   [ ] 待機画面を整える
-   [ ] DB改良→ タスクが済んだらデータを消す or  同じ名前の人が入力したらデータを上書きする
-   [ ] ipによるアクセス制限 一度判定すると30分休みなど
-   [ ] 



## Features

-   [x] 全体の改良

-   [x] 1. DB にデータを保存 とりあえずロジックは変えずにDB保存を追加するだけ読み出さずに検証→実際にDBのみに保存して検証
-   [x] 2. ロジックをコマンド化
-   [x] 3. mail を作ってみる メールの送り方検証→メールを送る用のコマンド作成→評価コマンドと組み合わせた一つのコマンドを作成 メールのドキュメントを読んで引数の渡し方を調べてコマンド間のデータの引き渡し方を模索
-   [x] 4. コントローラーからコマンドを実行できるようにする、タスクをキューもしくはスケジュールで組めるようにする




-   [ ] 共有しやすくする
-   [ ] 1. twitter 拡散ボタン
-   [ ] 2. twitter card 作成

