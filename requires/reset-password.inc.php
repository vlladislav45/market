<?php

    if(isset($_POST['recover-password-submit'])){

        $selector = $_POST['selector'];
        $validator = $_POST['validator'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];

        if(empty($password) || empty($confirmPassword)){
            header("Location: ../create-new-password.php?newpwd=empty");
            exit();
        }else if($password != $confirmPassword) {
            header("Location: ../create-new-password.php?newpwd=pwdnotsame");
            exit();
        }

        $currentDate = date("U");

        require "../config/stats.php";

        $query = "SELECT * FROM password_reset WHERE passwordResetSelector=? AND passwordResetExpires >=?";
        $stmt = mysqli_stmt_init($dbc);
        if (!mysqli_stmt_prepare($stmt, $query)){
            $sqlErr = "There was an error!";
        }else {
            //What the question mark is going to be replaced with before will be executed
            mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if(!$row = mysqli_fetch_assoc($result)){
                echo "You need to re-submit your reset request.";
                exit();
            }else {

                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin, $row['passwordResetToken']);

                if($tokenCheck === false){
                    echo "You need to re-submit your reset request.";
                    exit();
                }elseif($tokenCheck === true) {

                    $tokenEmail = $row['passwordResetEmail'];

                    $query = "SELECT * FROM accounts WHERE email=?;";

                    $stmt = mysqli_stmt_init($dbc);
                    if (!mysqli_stmt_prepare($stmt, $query)){
                        $sqlErr = "There was an error!";
                    }else {
                        mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);
                        if(!$row = mysqli_fetch_assoc($result)){
                            echo "There was an error.";
                            exit();
                        }else {

                            $query = "UPDATE accounts SET password=? WHERE email=?;";
                            $stmt = mysqli_stmt_init($dbc);
                            if (!mysqli_stmt_prepare($stmt, $query)){
                                $sqlErr = "There was an error!";
                            }else {
                                $newPwdHash = password_hash($password, PASSWORD_DEFAULT);

                                mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                                mysqli_stmt_execute($stmt);

                                $query = "DELETE FROM password_reset WHERE passwordResetEmail=?";
                                $stmt = mysqli_stmt_init($dbc);
                                if (!mysqli_stmt_prepare($stmt, $query)){
                                    $sqlErr = "There was an error!";
                                }else {
                                    //What the question mark is going to be replaced with before will be executed
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: ../index.php?newpwd=passwordupdated");
                                }

                            }
                        }
                    }

                }else {
                    echo "You need to re-submit your reset request.";
                    exit();
                }
            }
        }
    }
?>
