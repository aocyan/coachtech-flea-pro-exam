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
<p>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://localhost/login">http://localhost/login</a> にアクセスする<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;※1.permissionエラーが出た際には、ubuntu内coachtech-flea-pro-examディレクトリで、<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sudo chmod -R 777 src/*　を実行してください。<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;※2.chmod(): Operation not permittedエラーやfile_put_contents: failed to open stream: Permission deniedが出た際には、ubuntu内coachtech-flea-pro-examディレクトリで<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sudo chown -R www-data:www-data src/storage　を実行してください。<br>
   （※1のエラーについてはテスト時必ず出ていたため、あらかじめコマンドを実行しておいた方がよいと思われます。）</p>  
<h3>13.ダミーデータを挿入</h3>
<p>&nbsp;&nbsp;&nbsp;&nbsp;ubuntu内PHPコンテナ上で<br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;php artisan db:seed　を実行し、ダミーデータを挿入する。<br>
   &nbsp;&nbsp;&nbsp;&nbsp;※１.ダミーデータのユーザについては<br>
   &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;ユーザ1．出品した商品：C001からC005　アドレス：test1@example.com　パスワード：1234abcd<br>
   &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;ユーザ2. 出品した商品：C006からC0010 アドレス：test2@example.com　パスワード：1234abcd<br>
   &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;ユーザ2. 出品した商品：なし 　　　　　アドレス：test3@example.com　パスワード：1234abcd<br>
   &nbsp;&nbsp;&nbsp;&nbsp;で設定してあります。</p>
<h3>14.その他</h3>
<h4>①本アプリについて</h4>
<p>本アプリは以前の模擬案件作成時のアプリを改修したものとなります。</p>
<h4>②stripe機能について</h4>
<p>stripe機能は使用しませんが、必要ならば以下の手順で設定してください。</p>
<p>Stripe導入手順<br>  
&nbsp;&nbsp;&nbsp;&nbsp;①　Stripe公式サイト( https://stripe.com/jp )にアクセスしてアカウントを作成する<br>  
&nbsp;&nbsp;&nbsp;&nbsp;②　公式サイトの左上にある「≡ New business」アイコンをクリックして、メニュー下にある「開発者」をクリックする。<br>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（このとき、左上に「テスト環境」と書かれていることを確認する。）<br>  
&nbsp;&nbsp;&nbsp;&nbsp;③　「APIキー」をクリックすると、「公開可能キー」と「シークレットキー」があることを確認する。<br>  
&nbsp;&nbsp;&nbsp;&nbsp;④　VSCode内LaravelのCoachTech-fleaで.envファイルを開き、<br>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STRIPE_KEY=「Stripeの公開可能キーのトークン」<br>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STRIPE_SECRET=「Stripeのシークレットキーのトークン」<br>  
&nbsp;&nbsp;&nbsp;&nbsp;をそれぞれ挿入する。（それぞれのキーはコピー＆ペーストする）<br>  
&nbsp;&nbsp;&nbsp;&nbsp;⑤　VSCode内Laravelのcoachtech-flea-pro-examで、config/service.phpに<br>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return [<br>    
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'stripe' => [<br>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'secret' => env('STRIPE_SECRET'),<br>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'public' => env('STRIPE_KEY'),<br>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;],<br>    
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;];<br>  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;となっていることを確認してください。<br>  
&nbsp;&nbsp;&nbsp;&nbsp;⑥　Strage公式サイト内右上にある設定アイコン（ギアのマーク）をクリックし、「設定」をクリックする。<br>  
&nbsp;&nbsp;&nbsp;&nbsp;⑦　「製品の設定」にある「決済」をクリックし、ナビゲーションにある「決済手段」をクリックする<br>  
&nbsp;&nbsp;&nbsp;&nbsp;⑧　「店舗支払い」の項目にある「コンビニ決済」を「有効」に設定する。</p>
<h4>③未実装について</h4>
<p>1.メール機能は実装できておりません。</p>
<p>2.コメント新着機能は実装できておりません。</p>
   
<h2>〇　使用技術(実行環境)</h2>
<p>* PHP：7.4.9</p>
<p>* Laravel：8.83.29</p>
<p>*MySQL：15.1</p>
<p>* ubuntu：24.04.1 LTS</p>

<h2>〇　ER図</h2>
![CoachTechFlea](https://github.com/user-attachments/assets/944b0a35-574a-4087-a8fc-b13f7ee985c0)



<h2>〇　URL</h2>
* 開発環境：　http://localhost/
* phpMyAdmin：　http://localhost:8080/
