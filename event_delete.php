<?php
mb_internal_encoding("utf8");
session_start();

$login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
if ($login === 1) {
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
                <title>イベント削除画面</title>
                <link rel=\"stylesheet\" type=\"text/css\" href=\"./css/style.accessError.css\">
                </head>
                <body>
    
                <header>
                    <img src=\"./images/logo.jpeg\">
                    <ul class=\"menu\">
                        <li><a href=\"index.php\">イベント登録</a></li>
                    </ul>
                </header>
    
                <h1>イベント削除画面</h1>
    
    
                <div class='error-message'>エラーが発生したためイベント削除できませんでした</div>
    
    
                <footer>
                    <p><small>&copy; 2024 volleyball</p>
                </footer>
    
            </body>
            </html>";
        exit();
    }


    // 通常削除リクエストの際はgetメソッドを利用する
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    $stmt = $pdo->query("SELECT * FROM events WHERE event_id = $id");
    $event = $stmt->fetch();
} else {
    echo
    "<!doctype HTML>
            <html lang=\"ja\">
            <head>
            <meta charset=\"utf-8\">
            <title>イベント更新</title>
            <link rel=\"stylesheet\" type=\"text/css\" href=\"./css/style.accessError.css\">
            </head>
            <body>

            <div class='error-message'>このページにアクセスしないでください</div>


            <footer>
                <p><small>&copy; 2024 volleyball</p>
            </footer>

        </body>
        </html>";
    exit();
}
?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>アカウント削除画面</title>
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

    <h1>イベント削除画面</h1>

    <div class="confirm">
        <div class="confirm-wrapper">
            <p>イベント　　
                <span>
                    <?php echo $event['event_name']; ?>
                </span>
            </p>

            <p>開催地　　　　
                <span>
                    <?php echo $event['address']; ?>
                </span>
            </p>

            <p>開催日(月)　　
                <span>
                    <?php echo $event['month'] . "月"; ?>
                </span>
            </p>

            <p>開催日(日)　　
                <span>
                    <?php echo $event['date'] . "日"; ?>
                </span>
            </p>
        </div>

        <div class="confirm-form">
            <form action="event_delete_confirm.php" method="post">
                <input type="submit" class="button2" value="確認する">
                <input type="hidden" value="<?php echo $event['event_id']; ?>" name="id">
                <input type="hidden" value="<?php echo $event['event_name']; ?>" name="event_name">
                <input type="hidden" value="<?php echo $event['address']; ?>" name="address">
                <input type="hidden" value="<?php echo $event['month']; ?>" name="month">
                <input type="hidden" value="<?php echo $event['date']; ?>" name="date">
            </form>
        </div>

    </div>

    <footer>
        <p><small>&copy; 2024 volleyball</p>
    </footer>

</body>

</html>