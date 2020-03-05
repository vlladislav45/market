<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recover password</title>

    <!--External Styles-->
    <link rel="stylesheet" href="styles/recover/recover.css">
    <link rel="icon" href="images/favicon/Chat-Shopping-girl.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>
<body>
    <div class="container">
        <div class="logo" ></div>
    </div>
        <?php
            $selector = $_GET['selector'];
            $validator = $_GET['validator'];

            if(empty($selector) || empty($validator)){
                echo "Could not validate your request";
            }else {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
                    ?>
                    <form action="requires/reset-password.inc.php" method="post">
                        <h1> New Password: </h1>

                        <div class="form-input">
                            <input type="hidden" name="selector" value="<?php echo "$selector"; ?>">

                            <input type="hidden" name="validator" value="<?php echo "$validator"; ?>">

                            <input type="password" name="password" placeholder="Enter a new password...">

                            <input type="password" name="confirm-password" placeholder="Repeat new password...">
                        </div>
                        <input type="submit" name="recover-password-submit" value="Reset password">
                    </form>
                    <?php
                }
            }
        ?>
</body>
</html>