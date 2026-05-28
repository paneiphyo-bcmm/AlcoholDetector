<!-- SETUP.md -->
# Alcohol Detection System - セットアップ手順

## 必要環境

- PHP 8.2以上
- Composer
- MySQL 8.0
- Node.js (任意)

## インストール手順

    # 1. パッケージインストール
    composer install

    # 2. 環境設定ファイルコピー
    cp .env.example .env

    # 3. アプリケーションキー生成
    php artisan key:generate

    # 4. .envのDB設定を編集
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=alcohol_detection
    DB_USERNAME=root
    DB_PASSWORD=

    # 5. S3設定（月初CSV保存用）
    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=ap-northeast-1
    AWS_BUCKET=your-bucket-name

    # 6. マイグレーション実行
    php artisan migrate

    # 7. シーダー実行
    php artisan db:seed

    # 8. Passport インストール
    php artisan passport:install

    # 9. スケジューラ登録（crontab）
    # * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1

## デフォルトユーザー

    管理者: admin@example.com / password
    拠点管理者: org@example.com / password

## テスト実行

    php artisan test