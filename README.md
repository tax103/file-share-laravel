# ■ Box型ファイル共有  
1. ファイルアップロード機能  
    - アップロードすると専用URLを発行する
    - アップロード時にPWを設定可能
    - ファイルサイズチェック(5MBまで)
    - フォーム    
        - 認証処理を省く代わりにアップロード時にメアド必須入力
        - 掲載期限は必ず設定(1日～7日)    
        - PW
    - アップロードをログ記録する。メアド、日時、ファイル名、ファイルサイズ

2. ファイルダウンロード機能
    - 指定されたURLにアクセスするとダウンロード    
        - 共有範囲設定などは不要    
        - パスワード付きの場合、パスワードを入力POSTするとダウンロードが始まる    
        - ダウンロードログもとる。日時、IP、対象ファイル
    - 掲載期限切れたURLはエラー表示

3. ファイル保持機能
    - 掲載期限が来たらファイルデータを削除する
    - ファイルは直リンクDL可能状態で保持しない

4. 投稿者管理機能
    - 不要

# ■ 開発メモ
* アップロード、ダウンロードのURLはそれぞれ以下
  - http://localhost/upload
  - http://localhost/download/{file_key}

- アップロードされたファイルは以下に保存。１日１回（毎日深夜0時）削除  
(storage\app\uploads)

- ログはアップロード、ダウンロード、削除でそれぞれ作成。14日でローテーション  
(fs-laravel\storage\logs)

- .envはローカルで動かすことを想定した設定になっています

- 現状、以下のコマンドを手動で実行する必要あり  
docker compose up -d --build  
docker compose exec app bash    
php artisan migrate  
npm run build  
service cron start  

# ■ TODO
- サーバーサイドでのアップロード時のバリデーション（現状フロントのみ実装）
- テストクラスの実装
- パスワードの入力文字チェック
- ファイルアップロード時のメール送信
- ファイルキーの重複チェック
- 画面デザイン修正（注意文、説明の追加など）
- 各固定値の設定ファイル化（容量の上限、掲載期限等）
