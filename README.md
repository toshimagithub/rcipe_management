## レシピ管理

### 概要

ユーザーはレシピを投稿、編集、削除が可能で、編集と削除は投稿者または管理者に制限されます。
星評価や検索、ランキング、マイレビュー、オススメレシピ、詳細ページの閲覧が可能。PDF作成やLINEでの共有も可能。
管理者はユーザーの投稿数を確認し、管理者権限の付与やユーザー削除ができ、ユーザーのレシピをオススメに設定可能。
オススメされたレシピはオススメページで閲覧可能で、管理者はユーザーのレシピを削除できます。

    ```INI
    DB_PASSWORD=root
    ```

* APP_KEY生成

    ```console
    php artisan key:generate
    ```

* Composerインストール

    ```console
    composer install
    ```

* フロント環境構築

    ```console
    npm ci
    npm run build
    ```

* マイグレーション

    ```console
    php artisan migrate
    ```

* 起動

    ```console
    php artisan serve
    ```
