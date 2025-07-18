<h1>coachtech-flea-pro-exam(コーチテックPro試験フリマサイト)</h1>
<h2>〇　環境構築手順</h2>  
<p>※OSはWindows11を使用しております。OSがMacを使用の際は適宜環境構築お願いいたします。</p>
<h3>1.クローンする</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;ubuntu内で　git clone git@github.com:aocyan/coachtech-flea-pro-exam.git　を実行しクローンする。</p>
<h3>2.DockerDesktopの立ち上げ</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;DockerDesktopアプリを立ち上げる。</p>   
<h3>3.docker-compose up -d --build　の実行</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;ubuntu内で　docker-compose up -d --build　を実行する。<br>
&nbsp;&nbsp;&nbsp;&nbsp;(coachtech-flea-pro-examディレクトリ内で実行する。)</p>
<h3>4.VSCodeの起動とymlファイルの確認</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;ubuntu上で　code .　を実行(coachtech-flea-pro-examディレクトリ内で実行する)し、"docker-compose.yml"ファイル内の<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;mysql:<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;image: mysql:8.0.26<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;environment:<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MYSQL_ROOT_PASSWORD: root<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MYSQL_DATABASE: laravel_db<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MYSQL_USER: laravel_user<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MYSQL_PASSWORD: laravel_pass<br>
   であることを確認してください。</p>
<h3>5.composerをインストール</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;ubuntu上で　docker-compose exec php bash　を実行し、PHPコンテナ上で<br>
   composer install　を実行する。</p>
<h3>6.envファイルをコピー</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;"5"に続いてPHPコンテナ上で<br>
   cp .env.example .env　を実行し、.envファイルをコピーする。</p>
<h3>7.envファイルをymlファイルに同期させる</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;"6"でコピーした"envファイル"と"ymlファイル"を同期する。<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".envファイル"を<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DB_HOST=mysql<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DB_DATABASE=laravel_db<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DB_USERNAME=laravel_user<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DB_PASSWORD=laravel_pass<br>
  に設定を変更する。<br>
  ※「'.env'を保存できませんでした。」とエラーが出た際は、ubuntu内coachtech-flea-pro-examディレクトリ内で<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sudo chown ユーザ名:ユーザ名 ファイル名<br>
  でファイルを書き換える権限を付与させてください。<br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;例：sudo chown aocyan:aocyan /home/aocyan/coachtech/laravel/coachtech-flea-pro-exam/src/.env</p>
<h3>8.mysqlのデータベース確認</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://localhost:8080/">http://localhost:8080</a> にデータベースが存在しているか確認する（laravel_dbがあるか確認してください）</p>
<h3>9.アプリケーションキーの生成</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;ubuntu内PHPコンテナ上で<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;php artisan key:generate　を実行し、アプリケーションキーを生成する。
<h3>10.シンボリックリンクを作成</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;ubuntu内PHPコンテナ上で<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;php artisan storage:link　を実行し、シンボリックリンクを作成する。<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（作成済みであるというメッセージが出るかもしれませんが、一応実行してください）</p>
<h3>11.マイグレーション</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;ubuntu内PHPコンテナ上で<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;php artisan migrate　を実行し、マイグレーションする。</p>
<h3>12.localhostにアクセス(エラー対策)</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://localhost/">http://localhost/</a> にアクセスする<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;※1.permissionエラーが出た際には、ubuntu内coachtech-flea-pro-examディレクトリで、<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sudo chmod -R 777 src/*　を実行してください。<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;※2.chmod(): Operation not permittedエラーやfile_put_contents: failed to open stream: Permission deniedが出た際には、ubuntu内coachtech-flea-pro-examディレクトリで<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sudo chown -R www-data:www-data src/storage　を実行してください。<br>
   （エラーについてはテスト時必ず出ていたため、あらかじめコマンドを実行しておいた方がよいと思われます。）</p>  
<h3>13.ダミーデータを挿入</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;ubuntu内PHPコンテナ上で<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;php artisan db:seed　を実行し、ダミーデータを挿入する。<br>
   &nbsp;&nbsp;&nbsp;&nbsp;※ダミーデータのユーザについては<br>
   &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;ユーザ1. 出品した商品：C001からC005　アドレス：test1@example.com　パスワード：1234abcd<br>
   &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;ユーザ2. 出品した商品：C006からC0010 アドレス：test2@example.com　パスワード：1234abcd<br>
   &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;ユーザ3. 出品した商品：なし 　　　　　アドレス：test3@example.com　パスワード：1234abcd<br>
   &nbsp;&nbsp;&nbsp;&nbsp;で設定してあります。</p>
<h3>14.その他</h3>
<p>①　本アプリは以前の模擬案件作成時のアプリを改修したものとなります。</p>
<p>②　メール機能は実装しておりません。</p>   
<h2>〇　使用技術(実行環境)</h2>
<p>* PHP：7.4.9</p>
<p>* Laravel：8.83.29</p>
<p>*MySQL：15.1</p>
<p>* ubuntu：24.04.1 LTS</p>

<h2>〇　ER図</h2>

![coachtech-flea-pro-exam](https://github.com/user-attachments/assets/99ad75c4-5e81-464c-a24c-aa2ceb0aa912)



<h2>〇　URL</h2>
<p>* 開発環境：　<a href="http://localhost/">http://localhost/</a></p>
<p>* phpMyAdmin：　<a href="http://localhost:8080/">http://localhost:8080/</a></p>
