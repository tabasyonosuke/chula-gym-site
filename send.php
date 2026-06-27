<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームから送られてきた値を取得
    $name    = $_POST['name'];
    $tel     = $_POST['tel'];
    $email   = $_POST['email'];
    $menu    = $_POST['menu'];
    $date1   = $_POST['date1'];
    $date2   = $_POST['date2'];
    $date3   = $_POST['date3'];
    $message = $_POST['message'];

    // 送信先メールアドレス
    $to = "hayate032606@icloud.com";
    $subject = "【CHULA GYM】体験予約・お問い合わせがありました";

    // メールの本文
    $body = "サイトの予約フォームから以下の問い合わせがありました。\n\n";
    $body .= "----------------------------------------\n";
    $body .= "【お名前】\n" . $name . "\n\n";
    $body .= "【お電話番号】\n" . $tel . "\n\n";
    $body .= "【メールアドレス】\n" . $email . "\n\n";
    $body .= "【ご希望メニュー】\n" . $menu . "\n\n";
    $body .= "【予約希望日時】\n";
    $body .= "・候補1: " . str_replace('T', ' ', $date1) . "\n";
    $body .= "・候補2: " . str_replace('T', ' ', $date2) . "\n";
    $body .= "・候補3: " . str_replace('T', ' ', $date3) . "\n\n";
    $body .= "【お悩み・目標】\n" . ($message ? $message : "なし") . "\n";
    $body .= "----------------------------------------";

    // 送信元情報（メール送信時のヘッダー）
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";

    // メール送信実行
    if (mb_send_mail($to, $subject, $body, $headers)) {
        // 送信成功時の処理（必要に応じてHTMLを表示）
        echo "<h1>送信完了</h1>";
        echo "<p>お問い合わせありがとうございます。担当者より折り返しご連絡いたします。</p>";
    } else {
        // 送信失敗時の処理
        echo "<h1>送信エラー</h1>";
        echo "<p>申し訳ございません。送信に失敗しました。再度お試しください。</p>";
    }
} else {
    // 直接アクセスされた場合
    header("Location: contact.html");
    exit;
}
?>