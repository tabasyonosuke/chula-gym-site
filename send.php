<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 入力値の簡易サニタイズ（改行コードの除去など）
    $name    = str_replace(["\r", "\n"], '', $_POST['name']);
    $tel     = str_replace(["\r", "\n"], '', $_POST['tel']);
    $email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $menu    = str_replace(["\r", "\n"], '', $_POST['menu']);
    $date1   = str_replace(["\r", "\n"], '', $_POST['date1']);
    $date2   = str_replace(["\r", "\n"], '', $_POST['date2']);
    $date3   = str_replace(["\r", "\n"], '', $_POST['date3']);
    $message = $_POST['message']; 

    // メール送信元として適切なアドレスを指定
    $from_email = "reserve@stg.chulagym-ayase.jp";
    
    $to = "reserve@stg.chulagym-ayase.jp";
    $subject = mb_encode_mimeheader(
    "【CHULA GYM】体験予約・お問い合わせがありました",
    "UTF-8"
);
    

    $body = "サイトの予約フォームから以下の問い合わせがありました。\n\n";
    $body .= "----------------------------------------\n";
    $body .= "【お名前】" . $name . "\n";
    $body .= "【お電話番号】" . $tel . "\n";
    $body .= "【メールアドレス】" . $email . "\n";
    $body .= "【ご希望メニュー】" . $menu . "\n";
    $body .= "【予約希望日時】\n";
    $body .= "・候補1: " . str_replace('T', ' ', $date1) . "\n";
    $body .= "・候補2: " . str_replace('T', ' ', $date2) . "\n";
    $body .= "・候補3: " . str_replace('T', ' ', $date3) . "\n\n";
    $body .= "【お悩み・目標】\n" . ($message ? $message : "なし") . "\n";
    $body .= "----------------------------------------";

    $headers = "From: {$from_email}\r\n";
    $headers .= "Reply-To: {$email}\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n";

    // -f パラメータもFromと同じアドレスに合わせた
    $additional_parameters = "-f " . $from_email;

    if (mb_send_mail($to, $subject, $body, $headers, $additional_parameters)) {
        echo "<h1>送信完了</h1>";
        echo "<p>お問い合わせありがとうございます。</p>";
        echo '<a href="index.html">トップへ戻る</a>';
    } else {
        echo "<h1>送信エラー</h1>";
        echo "<p>申し訳ございません。送信に失敗しました。</p>";
        echo "<p>サーバー管理画面からメールログを確認してください。</p>";
    }
} else {
    // POST以外でのアクセスはトップへリダイレクト
    header("Location: index.html");
    exit;
}
?>