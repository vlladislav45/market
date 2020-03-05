<?php
    if(isset($_POST['recover-request-submit'])){

        $selector = bin2hex(openssl_random_pseudo_bytes(8));
        $token = openssl_random_pseudo_bytes(32);

        $url = "http://localhost/markete/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

        //Todays date in seconds since 1970
        $expires = date("U") + 1800;

        require "../config/stats.php";

        $userEmail = $_POST['email'];

        //We don't delete directly for more security system.
        $query = "DELETE FROM password_reset WHERE passwordResetEmail=?";
        $stmt = mysqli_stmt_init($dbc);
        if (!mysqli_stmt_prepare($stmt, $query)){
            $sqlErr = "There was an error!";
        }else {
            //What the question mark is going to be replaced with before will be executed
            mysqli_stmt_bind_param($stmt, "s", $userEmail);
            mysqli_stmt_execute($stmt);
        }

        $query = "INSERT INTO password_reset (passwordResetEmail, passwordResetSelector,
                    passwordResetToken, passwordResetExpires)
                    VALUES (?,?,?,?);";
        $stmt = mysqli_stmt_init($dbc);
        if (!mysqli_stmt_prepare($stmt, $query)){
            $sqlErr = "There was an error!";
        }else {
            $hashToken = password_hash($token, PASSWORD_DEFAULT);

            //What the question mark is going to be replaced with before will be executed
            mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector,
                                   $hashToken, $expires);
            mysqli_stmt_execute($stmt);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($dbc);

        $to = $userEmail;

        $subject = "Reset your password for ...";

        $message = "<p>We received a password reset request. The link to reset your password 
                    make this request, you can ignore this mail.</p>";
        $message .= "<p>Here is your password reset link: <br>";
        $message .= '<a href="' . $url .'"> ' . $url . '</a></p>';

        $headers = "From: vlladislav45@gmail.com" . "\r\n" .
                   "MIME-Version: 1.0" . "\r\n" .
                    "Content-type: text/html; charset=utf-8";

        $mailsent = mail($to, $subject, $message, $headers);
        if(!$mailsent) {
            echo "Error to sent a message.";
        }else {
            echo "The mail is sent.";
            header("Location: ../recover.php?reset=success");
        }
    }
?>
