# CoachTech-flea(コーチテックフリマ)
## 〇　環境構築手順  
※(osはwindows11を使用しております。osがmacを使用の際は適宜環境構築お願いします。)
1. ubuntu内で　git clone git@github.com:aocyan/CoachTech-flea.git　を実行しクローンする。

2. DockerDesktopアプリを立ち上げる
   
3. ubuntu内で　docker-compose up -d --build　を実行する。(CoachTech-fleaディレクトリ内で実行する）
   
4. ubuntu上で　code .　を実行(CoachTech-fleaディレクトリ内で実行する）し、  
　"docker-compose.yml"ファイル内の<br>  
    mysql:<br>
        image: mysql:8.0.26<br>
        environment:<br>
            MYSQL_ROOT_PASSWORD: root<br>
            MYSQL_DATABASE: laravel_db<br>
            MYSQL_USER: laravel_user<br>
            MYSQL_PASSWORD: laravel_pass<br>  
であることを確認してください。

5. ubntu上で docker-compose exec php bash を実行し、PHPコンテナ上で<br>  
　composer install　を実行する。
  
6. "5"に続いてPHPコンテナ上で<br>  
　cp .env.example .env を実行し、.envファイルをコピーする
  
7. "6"でコピーした".env"ファイルと".yml"ファイルを同期する<br>  
　.envファイルを<br>  
     DB_HOST=mysql<br>
     DB_DATABASE=laravel_db<br>
     DB_USERNAME=laravel_user<br>
     DB_PASSWORD=laravel_pass<br>  
 に設定を変更する。<br>  
 ※'.env' を保存できませんでした。とエラーが出た場合は、ubuntu内CoachTech-fleaディレクトリ内で<br>  
   sudo chown ユーザ名:ユーザ名 ファイル名<br>  
   でファイルを書き換える権限を付与させてください。<br>  
   例：sudo chown aocyan:aocyan /home/aocyan/coachtech/laravel/mogitate-test/src/.env
     
8. http://localhost:8080 にデータベースが存在しているか確認する（laravel_dbがあるか確認してください）<br>

9. ubuntu内PHPコンテナ上で<br>  
  php artisan key:generate　を実行し、アプリケーションキーを生成する。
  
10. ubuntu内PHPコンテナ上で<br>  
  php artisan storage:link　を実行し、シンボリックリンクを作成する。（作成済みであるというメッセージが出るかもしれませんが、一応実行してください）
 
12. ubuntu内PHPコンテナ上で<br>  
  php artisan migrate　を実行し、マイグレーションする。
  
13. ubuntu内PHPコンテナ上で<br>  
  php artisan db:seed　を実行し、シーダファイルを挿入する。
  
14. http://localhost/ にアクセスする<br>  
  ※1.permissionエラーが出た際には、ubuntu内CoachTech-fleaディレクトリで、<br>  
 　　sudo chmod -R 777 src/*　を実行してください。<br>  
  ※2.出品するときなどにchmod(): Operation not permittedエラーが出た際には、ubuntu内CoachTech-fleaディレクトリで<br>  
　　 sudo chown -R www-data:www-data src/storage　を実行してください。
  
15. Stripe導入手順<br>  
　①　Stripe公式サイト( https://stripe.com/jp )にアクセスしてアカウントを作成する<br>  
　②　公式サイトの左上にある「≡」アイコンをクリックして、メニュー下にある「開発者」をクリックする。<br>  
　　 （このとき、左上に「テスト環境」と書かれていることを確認する。）<br>  
　③　「APIキー」をクリックすると、「公開可能キー」と「シークレットキー」があることを確認する。<br>  
　④　VSCode内LaravelのCoachTech-fleaで.envファイルを開き、<br>  
　　　STRIPE_KEY=「Stripeの公開可能キーのトークン」<br>  
　　　STRIPE_SECRET=「Stripeのシークレットキーのトークン」<br>  
　　をそれぞれ挿入する。（それぞれのキーはコピー＆ペーストする）<br>  
　⑤　VSCode内LaravelのCoachTech-fleaで、config/service.phpに<br>  
　　　return [    
　　　　'stripe' => [  
    　　　　　　'secret' => env('STRIPE_SECRET'),  
    　　　　　　'public' => env('STRIPE_KEY'),  
    　　　　　　],    
    　　　　];<br>  
    となっていることを確認してください。<br>  
  ⑥　Strage公式サイト内右上にある設定アイコン（ギアのマーク）をクリックし、「設定」をクリックする。<br>  
  ⑦　「製品の設定」にある「決済」をクリックし、ナビゲーションにある「決済手段」をクリックする<br>  
  ⑧　「店舗支払い」の項目にある「コンビニ決済」を「有効」に設定する。

16. テストケースの実行<br>
  PHPコンテナ上で　php artisan test　を実行すると、すべてのテストケースを実行することができます。<br>
  もし、個別にテストケースを実行するときは<br>  
　　　　php artisan test tests/Feature/テストファイル名<br>
　　例：php artisan test tests/Feature/UserTest.php<br>  
　で実行してください。

17. その他<br>
  ①　Stripeの導入により、配送先住所のデータベースに挿入するタイミングは、Stripeの支払い（コンビニ払いの場合は支払方法確認）の後に表示される、購入完了画面です。<br>
  ②　Stripeのカード払いのとき（テスト環境下）は、<br>  
　　　カード番号：4242 4242 4242 4242（Visaカードでのテスト）<br>
　　　有効期限：未来の日付<br>
　　　CVCコード：任意の3ケタの数字<br>  
　　でテストしてください。
   
## 〇　使用技術(実行環境)
* PHP：7.4.9
* Laravel：8.83.8
* MySQL：8.0.41
* ubuntu：24.04.1

## 〇　ER図
![CoachTechFlea](https://github.com/user-attachments/assets/2e2835f2-3649-4eb9-84bf-21c071158ee7)

## 〇　URL
* 開発環境：　http://localhost/
* phpMyAdmin：　http://localhost:8080/
