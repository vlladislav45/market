<?php

    if (isset($_POST['login-submit'])) {
        $loginMailuid = $_POST['login-mailuid'];
        $loginPassword = $_POST['login-password'];
        $_SESSION['accId'] = $_SESSION['accUsername'] = "";

        if (empty($loginMailuid) || empty($loginPassword)) {
            header("Location: login.php?error=emptyfields");
            exit();
        } else {
            //Check email for verification
            //login or email equals in our database
            //Check that if account is not activated in thirdy minutes
            $query = "SELECT * FROM accounts WHERE login=? OR email=?";
            //Initialize a statement and return an object to use with mysqli_stmt_prepare():
            $stmt = mysqli_stmt_init($dbc);

            //If we have problem with MySQL
            if (!mysqli_stmt_prepare($stmt, $query)) {
                header("Location: login.php?error=sqlerror");
                exit();
            } else {
                //mysqli_stmt_bind_param - Binds variables to a prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss", $loginMailuid, $loginMailuid);
                //Executes a prepared Query(заявка)
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                //Fetch a result row as an associative array - Извличане на ред с резултати като асоциативен масив
                if ($row = mysqli_fetch_assoc($result)) {
                    //Check login password with the password in MySQL
                    $emailToken = $row['email_verification'];
                    $pwdCheck = password_verify($loginPassword, $row['password']);

                    if ($pwdCheck == false) {
                        header("Location: login.php?error=wrongpassword");
                        exit();
                    }
                    //Sometimes have problems if we don't check for TRUE
                    //It's a mistake error..
                    else if ($pwdCheck == true) {
                        if($emailToken == "not_verified"){
                            header("Location: login.php?account=notactivated");
                            exit();
                        }else if($emailToken == "verified"){
                            session_start();
                            $_SESSION['accId'] = $row['account_id'];
                            $_SESSION['accUsername'] = $row['login'];

                            if(!empty($_POST['login-remember'])){
                                //Cookies for 30 days
                                setcookie("login", $_POST['login-mailuid'], time()+(60*60*24*30));
                            }

                            header("Location: index.php");
                            exit();
                        }else {
                            header("Location: login.php?account=notactivated");
                            exit();
                        }
                    } else {
                        header("Location: login.php?error=wrongpwd");
                        exit();
                    }
                } else {
                    header("Location: login.php?error=nouser");
                    exit();
                }
            }
        }
    }

?>
