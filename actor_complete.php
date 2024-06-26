<?php
session_start();
$login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
//SESSIONを各名前の変数に格納する
$family_name = isset($_SESSION['family_name']) ? $_SESSION['family_name'] : '';
$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$mail = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
$gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
$grade = isset($_SESSION['grade']) ? $_SESSION['grade'] : '';
$authority = isset($_SESSION['authority']) ? $_SESSION['authority'] : '';

date_default_timezone_set('Asia/Tokyo');
$time = date("Y-m-d H:i:s");

// 暗号化に使用するキーを生成
$key = 'userAccountEntryKey';

// パスワードを暗号化
$encrypted_password = openssl_encrypt($password, 'AES-256-CBC', $key, 0, substr($key, 0, 16));


mb_internal_encoding("utf8");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  try {
    // ここで接続エラーが発生する可能性がある。
    $pdo = new PDO("mysql:dbname=kogaport_portfolio;host=mysql1.php.starfree.ne.jp;", "kogaport_root", "ryo19990617");
  } catch (PDOException $e) {
    // 接続エラーが発生した場合の処理
    echo
    "<!doctype HTML>
            <html lang=\"ja\">
            <head>
            <meta charset=\"utf-8\">
            <title>参加者登録完了画面</title>
            <link rel=\"stylesheet\" type=\"text/css\" href=\"./css/style.accessError.css\">
            </head>
            <body>

            <header>
                <img src=\"./images/logo.jpeg\">
                <ul class=\"menu\">
                    <li><a href=\"index.php\">イベント登録</a></li>
                </ul>
            </header>

            <h1>参加者登録完了画面</h1>


            <div class='error-message'>エラーが発生したため参加者登録できませんでした</div>


            <footer>
                <p><small>&copy; 2024 volleyball</p>
            </footer>

        </body>
        </html>";
    exit();
  }

  $result =
    $pdo->exec("insert into actor(family_name, last_name, mail, password, gender, grade, authority, delete_flag, registered_time, update_time)
      values('$family_name', '$last_name', '$mail', '$encrypted_password', '$gender', '$grade', '$authority', '0', '$time', '$time')");
  if ($result !== false || $pdo !== false) {
    require_once 'sessionFunction.php';
    sessionClear();

    header("location:actor_complete.php");
    exit;
  } else {
    $error = "エラーが発生したため登録できません";
  }
}
?>

<!doctype HTML>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>参加者登録完了画面</title>
    <link rel="stylesheet" type="text/css" href="./css/style.entry.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script>
    $(document).ready(function() {
        $('.menu-icon').click(function() {
            $(this).toggleClass('open');
            $('.menu').toggleClass('open');
        });
    });
    </script>
</head>

<body>

    <header>
        <a href="index.php?clear_session=true"><img src="./images/logo.jpeg" alt="logo-mark"></a>
        <div class="menu-icon">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
        <ul class="menu">
            <li><a href="index.php?clear_session=true">イベント一覧</a></li>
            <?php if ($login === 1) :  //幹事が操作できる  
      ?>
            <li><a href="actor.php?clear_session=true">参加者登録</a></li>
            <li><a href="event.php?clear_session=true">イベント登録</a></li>
            <li><a href="list.php?clear_session=true">参加者一覧</a></li>
            <?php endif; ?>
        </ul>
    </header>


    <h1>参加者登録完了画面</h1>


    <div class="complete">
        <h2>登録完了しました</h2>
        <form action="index.php" method="post">
            <input type="submit" class="button2" value="TOPページに戻る">
    </div>

    <?php
  if (!empty($error)) {
    echo "<div class='error-message'>$error</div>";
  }
  ?>


    <footer>
        <p><small>&copy; 2024 volleyball</p>
    </footer>

</body>

</html>