<?php

$link = mysqli_connect(
    'localhost', // 資料庫伺服器位址
    'root',      // 資料庫使用者名稱
    '',          // 資料庫密碼
    '0425hw'     // 資料庫名稱
);
$uName = $_GET["uName"]; // 接收使用者輸入的姓名
// 設定資料庫連線的字元集為 UTF-8，避免中文亂碼
mysqli_set_charset($link, "utf8");

$no;
$uEmail;
$uPhoto;
// 查詢資料表，根據 `no` 取得對應的資料
$sql = "SELECT * FROM user WHERE Name='$uName'";
if ($result = mysqli_query($link, $sql)) {
    // 使用 while 迴圈讀取資料（實際上只會有一筆資料）
    while ($row = mysqli_fetch_assoc($result)) {
        $no = $row["No"]; // 取得資料中的姓名
        $uEmail = $row["email"]; // 取得資料中的電子郵件
        $uPhoto = $row["photo"]; // 取得資料中的照片連結
    }
}
echo "姓名: $uName<br>";
echo "電子郵件: $uEmail<br>";
echo "照片連結: $uPhoto<br>";
echo "<img src='$uPhoto' alt='photo' style='width:200px;height:200px;'><br>";
echo "<br>";
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// //Load Composer's autoloader (created by composer, not included with PHPMailer)
// require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'sxiang0705@gmail.com';                     //SMTP username
    $mail->Password   = 'xgva pdgx dfgf vhvg';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465; 
                                       //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('sxiang0705@gmail.com', 'Mailer');
    //$mail->addAddress('', 'Joe User');     //Add a recipient
    $mail->addAddress($uEmail);               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $subject="恭喜註冊網站";
    $subject = "=?UTF-8?B?".base64_encode(string: $subject)."?="; //Subject must be encoded in UTF-8
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = "
    <h1>恭喜註冊網站<h1>
    <p>Name: ".$uName."</p>
    <p>這是你的照片</p>
    <img src='$uPhoto' alt='photo' style='width:200px;height:200px;'><br>";
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>