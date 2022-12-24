<?php
require('db.php');
if(!isset($_SESSION)){
session_start();
}
?>
<?php
    // フォームが送信されたら、ユーザー セッションを確認して作成します。
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // バックスラッシュを削除します
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        // ユーザーがデータベースに存在することを確認します
        $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;
            // ユーザー ダッシュボードページにリダイレクト
            header("Location: dashboard.php");
        } else {
            echo "<div class='form'>
                  <h3>ユーザー名/パスワードが正しくありません。</h3><br/>
                  <p class='link'>もう一度<a href='login.php'>ここをクリック</a>して再度ログインしてください。</p>
                  </div>";
        }
    } else {
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8"/>
        <title>ログイン</title>
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
    <form class="form" method="post" name="login">
        <h1 class="login-title">ログイン</h1>
        <input type="text" class="login-input" name="username" placeholder="ユーザー名" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="パスワード"/>
        <input type="submit" value="ログイン" name="submit" class="login-button"/>
        <p class="link">アカウントをお持ちでない場合　<a href="registration.php">今すぐ登録</a></p>
  </form>
<?php
    }
?>
</body>
</html>
