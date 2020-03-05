<?php
    //Може би липсва метод, с който да се изтриват акаунтите ако изтекат 30 минути без валидация.
    //functions
    function getUserIP()
    {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }

    //make variables available
    $email = $username = $password = $confirm_password = "";
    $emailErr = $usernameErr = $passwordErr = "";
    $errors = array();
    $today = date("Y-m-d");
    $successRegister = $failedToRegister = $existingUser = "";
    //Create a "unique" token.
    $token = bin2hex(openssl_random_pseudo_bytes(32));

if (isset($_POST['submit'])) {
    if (empty($_POST["username"])) {
        $usernameErr = "* Username is required";
        array_push($errors, $usernameErr);
    } else {
        $username = $_POST['username'];
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $usernameErr = "* Username: Only letters and numbers allowed";
            array_push($errors, $usernameErr);
        }
    }


    if (empty($_POST["email"])) {
        $emailErr = "* Email is required";
        array_push($errors, $emailErr);
    } else {
        $email = $_POST["email"];
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "* Invalid email format";
            array_push($errors, $emailErr);
        }
    }

    if (empty($_POST["password"]) || empty($_POST['confirm_password'])) {
        $passwordErr = "* Password is required";
        array_push($errors, $passwordErr);
    } else {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        // check if password is equal on confirm password
        if ($password != $confirm_password) {
            $passwordErr = "* Your passwords do not match";
            array_push($errors, $passwordErr);
        }
    }
    //Call the function getUserIP()
    $user_ip = getUserIP();

    if(count($errors) == 0){
        $query = "SELECT * FROM accounts  WHERE email = ? or login =?;";
        $stmt = mysqli_stmt_init($dbc);
        if(!mysqli_stmt_prepare($stmt, $query)){
            header("Location: login.php?sqlerror=database_error_occured");
            echo " Database Error";
        }
        mysqli_stmt_bind_param($stmt, "ss", $email, $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) == 0){
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO accounts
                (email, emailVerificationToken, login, password, created_time, lastIP)
                VALUES
                (?,?,?,?,?,?);";

            $stmt = mysqli_stmt_init($dbc);
            if(!mysqli_stmt_prepare($stmt, $query)){
                mysqli_error($dbc);
            }

            mysqli_stmt_bind_param($stmt, "ssssss", $email, $token, $username, $hashedPass, $today, $user_ip);
            mysqli_stmt_execute($stmt);

            if(mysqli_affected_rows($dbc) == 1){
                //Get the unique user ID of the user that has just registered.
                $query = "SELECT account_id FROM accounts WHERE email=? or login=?;";
                $stmt = mysqli_stmt_init($dbc);
                if(!mysqli_stmt_prepare($stmt, $query)){
                    header("Location: register.php?error=sqlerror");
                }else {

                    mysqli_stmt_bind_param($stmt, "ss", $email,$username);
                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);
                    if(!$row = mysqli_fetch_assoc($result)){
                        echo "You need to re-submit your account request.";
                        exit();
                    }else {
                        $userId = $row['account_id'];

                        //Construct the URL.
                        $url = "http://localhost/markete/activate-account.php?token=" . $token . "&user=" .$userId;

                        //Build the HTML for the link.
                        $link = '<a href="' . $url . '">' . $url . '</a>';

                        //Send email address
                        $to = $email;

                        $subject = "Activate your account for ...";

                        $message = "<p>We received a activate account request. The link to activate your password
                            make this request, you can ignore this mail.</p>";
                        $message .= "<p>Here is your account activate link: <br>";
                        $message .= '<a href="' . $url .'"> ' . $url . '</a></p>';

                        $headers = "From: vlladislav45@gmail.com" . "\r\n" .
                            "MIME-Version: 1.0" . "\r\n" .
                            "Content-type: text/html; charset=utf-8";

                        $mailsent = mail($to, $subject, $message, $headers);
                        if(!$mailsent) {
                            header("Location: register.php?mailsent=error");
                            exit();
                        }else {
                            //Finish the page:
                            $successRegister = "Thank you for registering! A confirmation
                            email has been sent to " . $email . "
                            Please click on the Activation Link to Activate your account.";
                        }
                    }
                }

            } else {
                $failedToRegister = "Error, please try again later.";
            }
        }else {
            $existingUser = "There is already a user with the same name or email";
        }
    }
    mysqli_close($dbc);
}

?>
