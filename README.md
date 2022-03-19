# モール型ECサイト

## インストール方法

```
cd umarche
composer install
./vendor/bin/sail up

docker exec -it umarche_laravel.test_1 bash
npm run dev
```
.env.example をコピーして .env ファイルを作成

.envファイルの中の下記をご利用の環境に合わせて変更してください
- STRIPE_PUBLIC_KEY
- STRIPE_SECRET_KEY

DB起動後

umarcheというデータベースを作成

その後laravelのコンテナ内で

`php artisan migrate:fresh --seed`

と実行してください。（データベーステーブルとダミーデータが追加されればOK）

最後に

`php artisan key:generate`

と入力してキーを生成


## インストール後の実施事項

画像のダミーデータは
public/imagesフォルダ内に
sample1.jpg 〜 sample6.jpg として
保存しています。

`php artisan storage:link` で
storageフォルダにリンク後、

storage/app/public/productsフォルダ内に
保存すると表示されます。
（productsフォルダがない場合は作成してください。）

ショップの画像も表示する場合は、
storage/app/public/shopsフォルダを作成し
画像を保存してください。

メール処理に、キューを使用しています。

必要な場合は `php artisan queue:work` で
ワーカーを立ち上げて動作確認するようにしてください。
