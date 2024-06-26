<?php

mb_internal_encoding("utf8");
session_start();


$login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
if ($login === 1) {

  // クエリパラメータが設定されているかどうかを確認し、セッションをクリアする
  if (isset($_GET['clear_session']) && $_GET['clear_session'] === 'true') {
    // セッションをクリアする
    require_once 'sessionFunction.php';
    sessionClear();
  }

  $errors = array();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $family_name = $_POST['family_name'];
    $last_name = $_POST['last_name'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $grade = $_POST['grade'];
    $authority = $_POST['authority'];

    // 入力チェック
    if (empty($family_name)) {
      $errors['family_name'] = '名前（名）が未入力です。';
    } elseif (mb_strlen($family_name, 'UTF-8') > 10 || !preg_match('/^[ぁ-んァ-ン一-龠]+$/u', $family_name)) {
      $errors['family_name'] = '名前（名）はひらがな、漢字のみ入力可能で、最大10文字です。';
    }

    if (empty($last_name)) {
      $errors['last_name'] = '名前（姓）が未入力です。';
    } elseif (mb_strlen($last_name, 'UTF-8') > 10 || !preg_match('/^[ぁ-んァ-ン一-龠]+$/u', $last_name)) {
      $errors['last_name'] = '名前（姓）はひらがな、漢字のみ入力可能で、最大10文字です。';
    }

    if (empty($mail)) {
      $errors['mail'] = 'メールアドレスが未入力です。';
    } elseif (!preg_match('/^[a-zA-Z0-9\-@.]{1,100}$/', $mail)) {
      $errors['mail'] = 'メールアドレスは半角英数字、半角ハイフン、半角記号（ハイフンとアットマーク）のみ入力可能で、最大100文字です。';
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      $errors['mail'] = 'メールアドレスの形式が無効です。';
    }

    if (empty($password)) {
      $errors['password'] = 'パスワードが未入力です。';
    } elseif (!preg_match('/^[a-zA-Z0-9]{1,10}$/', $password)) {
      $errors['password'] = 'パスワードは半角英数字のみ入力可能で、最大10文字です。';
    }

    if (empty($grade)) {
      $errors['grade'] = '学年が未入力です。';
    }

    if (empty($errors)) {
      $_SESSION['family_name'] = $family_name;
      $_SESSION['last_name'] = $last_name;
      $_SESSION['mail'] = $mail;
      $_SESSION['password'] = $password;
      $_SESSION['gender'] = $gender;
      $_SESSION['grade'] = $grade;
      $_SESSION['authority'] = $authority;
      //確認画面に遷移する
      header('Location: actor_confirm.php');
      exit();
    } else {
      $_SESSION['family_name'] = $family_name;
      $_SESSION['last_name'] = $last_name;
      $_SESSION['mail'] = $mail;
      $_SESSION['password'] = $password;
      $_SESSION['gender'] = $gender;
      $_SESSION['grade'] = $grade;
      $_SESSION['authority'] = $authority;
    }
  }
} else {
  echo
  "<!doctype HTML>
            <html lang=\"ja\">
            <head>
            <meta charset=\"utf-8\">
            <title>イベント一覧</title>
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
    <title>参加者登録画面</title>
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

    <main>

        <h1>参加者登録画面</h1>
        <form method="post" action="actor.php">

            <div>
                <label>名前(姓)　　</label>
                <input type="text" class="text" size="35" name="family_name"
                    value="<?php echo (!empty($_SESSION['family_name'])) ? $_SESSION['family_name'] : ''; ?>">

                <?php if (!empty($errors['family_name'])) : ?>
                <p class='error-message'><?php echo $errors['family_name']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label>名前(名)　　</label>
                <input type="text" class="text" size="35" name="last_name"
                    value="<?php echo (!empty($_SESSION['last_name'])) ? $_SESSION['last_name'] : ''; ?>">

                <?php if (!empty($errors['last_name'])) : ?>
                <p class='error-message'><?php echo $errors['last_name']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label>メールアドレス　　</label>
                <input type="text" class="text" size="35" name="mail"
                    value="<?php echo (!empty($_SESSION['mail'])) ? $_SESSION['mail'] : ''; ?>">

                <?php if (!empty($errors['mail'])) : ?>
                <p class='error-message'><?php echo $errors['mail']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label>パスワード　　</label>
                <input type="text" class="text" size="35" name="password"
                    value="<?php echo (!empty($_SESSION['password'])) ? $_SESSION['password'] : ''; ?>">

                <?php if (!empty($errors['password'])) : ?>
                <p class='error-message'><?php echo $errors['password']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="gender-label">性別</label>
                <div class="gender-input">
                    <span for="male">男</span>
                    <input type="radio" id="male" name="gender" checked="checked" value="0"
                        <?php echo (!empty($_SESSION['gender']) && $_SESSION['gender'] === '0') ? 'checked' : ''; ?>>
                </div>
                <div class="gender-input">
                    <span for="female">女</span>
                    <input type="radio" id="female" name="gender" value="1"
                        <?php echo (!empty($_SESSION['gender']) && $_SESSION['gender'] === '1') ? 'checked' : ''; ?>>

                </div>
            </div>


            <div>
                <label>学年(M1は5年・M2は6年を選択)　</label>
                <select class="text" name="grade">
                    <option value=""
                        <?php echo (empty($_SESSION['grade']) || $_SESSION['grade'] === '') ? 'selected' : ''; ?>>
                    </option>
                    <?php
          $grades = array(
            '1', '2', '3', '4', '5', '6'
          );
          foreach ($grades as $grade) {
            echo '<option value="' . $grade . '"';
            echo (!empty($_SESSION['grade']) && $_SESSION['grade'] === $grade) ? ' selected' : '';
            echo '>' . $grade . "年" . '</option>';
          }
          ?>
                </select>

                <?php if (!empty($errors['grade'])) : ?>
                <p class='error-message'><?php echo $errors['grade']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label>アカウント権限　　</label>
                <select class="text" name="authority">
                    <option selected value="0"
                        <?php echo (!empty($_SESSION['authority']) && $_SESSION['authority'] === '0') ? 'selected' : ''; ?>>
                        一般</option>
                    <option value="1"
                        <?php echo (!empty($_SESSION['authority']) && $_SESSION['authority'] === '1') ? 'selected' : ''; ?>>
                        管理者</option>
                </select>
            </div>

            <div>
                <input type="submit" class="submit" value="確認する">
            </div>

        </form>
    </main>

    <footer>
        <p><small>&copy; 2024 volleyball</p>
    </footer>

</body>

</html>