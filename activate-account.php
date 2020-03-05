<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
    //Connect to the database
    require "config/stats.php";
    //Make sure that our query string parameters exist.
    if(isset($_GET['token']) && isset($_GET['user'])){
        $token = $_GET['token'];
        $userId = $_GET['user'];

        $query = "SELECT * FROM accounts WHERE account_id=? AND emailVerificationToken=?;";
        $stmt = mysqli_stmt_init($dbc);
        if(!mysqli_stmt_prepare($stmt, $query)){
            header("Location: activate-account.php?error=firstsqlerror");
            exit();
        }else {
            mysqli_stmt_bind_param($stmt, "ss", $userId, $token);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if(!$row = mysqli_fetch_assoc($result)){
                header("Location: activate-account.php?token=isnotvalidate");
                exit();
            }else {
                //Token is valid. Verify  the email address.
                $query = "UPDATE accounts SET email_verification=? WHERE account_id = ?;";
                $stmt = mysqli_stmt_init($dbc);
                if(!mysqli_stmt_prepare($stmt, $query)){
                    header("Location: activate-account.php?error=sqlerror");
                    exit();
                }else {
                    echo "You successfully activate your account!";
                    $emailVerified = "verified";

                    mysqli_stmt_bind_param($stmt, "ss", $emailVerified, $userId);
                    mysqli_stmt_execute($stmt);
                }
            }
        }
    }
    ?>
</body>
</html>
