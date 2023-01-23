# sotukenn
## 開発環境構築 
1. GitHubアカウントの登録  
    1. [GitHub](https://github.com/)にアクセスして、右上のSignUpから作成する。
2. Dockerの導入 
    1. コマンドプロンプトかPowerShellを管理者権限で起動する 
    2. wslを導入するために以下のコマンドを打つ 
    ```
    wsl --install
    ```
    3. 公式サイトからインストールする  
    [Docker公式サイト](https://www.docker.com/products/docker-desktop/)のfor Windowsをクリックしてインストーラをダウンロードし実行
    4. インストーラのコンフィグにチェックを入れる  
    install requiredとAdd shortcut to desktopにチェックを入れOKをクリック
3. gitの導入
    1. 公式サイトからインストーラをダウンロード  
    [公式サイト](https://gitforwindows.org/)のDownloadをクリック
    2. インストーラの手順  
    [解説サイト](https://www.curict.com/item/60/60bfe0e.html)このページを読みながら行えばOK
    3. 解説  
    gitをインストールすることでGit bashを使えるようになり、linuxのコマンドをWindows上で使えるようになる　　
4. git cloneを行う
    1. GitBashを開き、以下のコマンドを打つ。
    ```
    cd ~
    mkdir <~好きな作業用ディレクトリ名~>
    cd <~上で名付けたディレクトリ名~>
    git clone git@github.com:akaitigo/sotukenn.git
    ```
    2. エクスプローラで<~上で名付けたディレクトリ名~>のフォルダを開き階層構造が以下になっている確認する
    ```
    sotukenn
      |
      |---infra
      |---src
      |---README.md
      |---docker-compose.yml
    ```
5. Dockerを起動し、更新する。
    1. Docker Desktopを起動し、ポップアップに従って再起動する。
6. Cloneしたリポジトリが正常に動作するか確認する。  
    1. Git Bashを開き、cd <~上で名付けたディレクトリ名~>　でディレクトリを変更する。  
    2. 以下のコマンドを打つ。
    ``` 
    docker compose up -d
    //docker compose execが上手くいかなかったら、Docker Windowsからappサーバーのターミナルを開いて、chmodから始める
    docker compose exec app bash
    chmod -R 777 storage bootstrap/cache
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan storage:link
    php artisan migrate
    exit
    docker compose down
    ```
    3. 
    teammember/yamamura,tsumagari,kudou,tokuchan



appサーバにnodeとnpmの追加

```
rm -rf /usr/local/bin/npm /usr/local/share/man/man1/node* ~/.npm
rm -rf /usr/local/lib/node*
rm -rf /usr/local/bin/node*
rm -rf /usr/local/include/node*

apt-get purge nodejs npm
apt autoremove
curl -fsSL https://deb.nodesource.com/setup_19.x | bash - &&\
apt-get install -y nodejs
curl -qL https://www.npmjs.com/install.sh | sh
```
dbサーバーにcliでアクセス
```
mysql -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE
```
appサーバーにdefault-jdkを入れる
```
apt update
apt install default-jdk
```
pathを通す
```
export JAVA_HOME=/usr/lib/jvm/java-11-openjdk-amd64
export PATH=$PATH:$JAVA_HOME/bin
```


ngrok公式サイト
https://ngrok.com/

アカウント作成
Connect Your Accountのトークンをコピー
Download ngrokでダウンロード

インストールしたらngrokが入っているフォルダをShift+右クリックでPowerShellで開く
トークンの冒頭に './'を追加して貼り付け
ex)./ngrok config...

下のコードを張り付け
./ngrok http 8080 --host-header="localhost:8080"


12/9用
https://3ee2-49-104-8-143.jp.ngrok.io

'''
chmod -R 777 src/storage/fonts
apt-get install xpdf
export COMPOSER_PROCESS_TIMEOUT=1200
composer install
'''

