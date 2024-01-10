## レシピ管理

### 概要

ユーザーはレシピを投稿、編集、削除が可能で、編集と削除は投稿者または管理者に制限されます。
星評価や検索、ランキング、マイレビュー、オススメレシピ、詳細ページの閲覧が可能。PDF作成やLINEでの共有も可能。
管理者はユーザーの投稿数を確認し、管理者権限の付与やユーザー削除ができ、ユーザーのレシピをオススメに設定可能。
オススメされたレシピはオススメページで閲覧可能で、管理者はユーザーのレシピを削除できます。

### 主な機能
* ログイン機能
  *ユーザーはアカウントを作成し、ログインすることができる。
  *ログインしていないユーザーは、にアクセスできないようにする。
* レシピ関連の機能
  ・ユーザーはレシピを投稿できる。
  ・ユーザーは自分で投稿したレシピを編集できる。
  ・ユーザーは自分で投稿したレシピを削除できる。
  ・レシピにはレビュー機能があり、全ユーザーがレビューできる。
  ・ユーザーは投稿されているレシピを検索できる。
* おすすめ・ランキング
  ・ユーザーはおすすめレシピを閲覧できる。
  ・レシピにはランキングがあり、ユーザーはランキングを閲覧できる。
* 管理者機能
  ・管理者はユーザーが登録したレシピをおすすめに選択できる。
  ・管理者は投稿されたレシピを削除できる。
  ・管理者はユーザーに管理者権限を与えたり、ユーザーを削除できる。



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
