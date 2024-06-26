<?php
mb_internal_encoding("utf8");
session_start();
$login = isset($_SESSION['login']) ? $_SESSION['login'] : '';

$pdo = new PDO("mysql:dbname=kogaport_portfolio;host=mysql1.php.starfree.ne.jp;", "kogaport_root", "ryo19990617");

$id = isset($_POST['id']) ? $_POST['id'] : '';

$stmt = $pdo->query("SELECT * FROM events WHERE event_id = $id");
$event = $stmt->fetch();

?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>イベント削除確認画面</title>
    <link rel="stylesheet" type="text/css" href="./css/style.event.css">
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

    <h1>イベント削除確認画面</h1>

    <div class="confirm">
        <h2 class="confirm-message">本当に削除してよろしいですか？</h2>

        <div class="confirm-form">
            <form action="event_delete.php" method="get">
                <input type="submit" class="button1" value="前に戻る">
                <input type="hidden" value="<?php echo $event['event_id']; ?>" name="id">
            </form>

            <form action="event_delete_complete.php" method="post">
                <input type="submit" class="button2" value="削除する">
                <input type="hidden" value="<?php echo $event['event_id']; ?>" name="id">
            </form>
        </div>
    </div>

    <footer>
        <p><small>&copy; 2024 volleyball</p>
    </footer>

</body>

</html>