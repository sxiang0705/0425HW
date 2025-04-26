<?php
// 從表單接收使用者輸入的資料
$uName = $_POST["name"]; // 接收使用者輸入的姓名
$uEmail = $_POST["email"]; // 接收使用者輸入的電子郵件
$uPhoto = $_POST["photo"]; // 接收使用者輸入的照片連結


// 建立與資料庫的連線
$link = mysqli_connect(
    'localhost', // 資料庫伺服器位址
    'root',      // 資料庫使用者名稱
    '',          // 資料庫密碼
    '0425hw'     // 資料庫名稱
);

// 設定資料庫連線的字元集為 UTF-8，避免中文亂碼
mysqli_set_charset($link, "utf8");

// 建立 SQL INSERT 語句，將使用者輸入的資料插入到 info 資料表中
$sql = "INSERT INTO user (Name, email, photo) VALUES ('$uName', '$uEmail', '$uPhoto')";

// 執行 SQL 語句，並檢查是否執行成功
if (mysqli_query($link, $sql)) {
    // 如果執行成功，重新導向到 sendMail.php 頁面

    header("Location:sendMail.php?uName=" . urlencode($uName));
    echo "資料新增成功<br>"; // 顯示成功訊息（不過這行在 header 後可能不會執行）
} else {
    // 如果執行失敗，顯示錯誤訊息
    echo "錯誤:" . mysqli_error($link);
    echo "資料新增失敗<br>";
    echo "<a href='form.php'><button type='button'>回到註冊頁面</button></a><br>";
}


// 關閉資料庫連線（可選，PHP 在腳本結束時會自動關閉連線）
mysqli_close($link);
?>