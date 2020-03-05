<?php require "config/stats.php"; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>

    <!--External Styles-->
    <link rel="stylesheet" href="styles/login/login.css">
    <link rel="icon" href="images/favicon/Chat-Shopping-girl.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>
<body>

    <?php

        require "requires/login.inc.php";

    ?>

    <form action="" method="post">
        <div class="form-input">
            <div class="input-emogi"><i class="fa fa-user"></i></div>
            <input type="text" name="login-mailuid" placeholder="Mail/Username"
            <?php if(isset($_COOKIE['login'])) { echo "value=" . $_COOKIE['login'];  } ?> >
        </div>

        <div class="form-input">
            <div class="input-emogi"><i class="fa fa-lock"></i></div>
            <input type="password" name="login-password" id="password" placeholder="Password">
        </div>

        <input type="checkbox" name="login-remember" value="Remember Me"> Remember Me

        <input type="submit" name="login-submit" value="Login">

        <p><a href="recover.php">Forgot your password?</a></p>

        <div class="form-register">
            <li><a href="register.php">Sign Up</a></li>
        </div>
    </form>
</body>
</html>
