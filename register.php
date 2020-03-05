<?php require "config/stats.php"; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register form</title>
    <link rel="icon" href="images/favicon/Chat-Shopping-girl.ico">

    <!--External Styles-->
    <link rel="stylesheet" href="styles/register/register.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">

    <!--External Libraries and Scripts-->
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
</head>
<body>

    <?php require "requires/register.inc.php"; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <p><span class="error">* required field</span></p>
        <div class="form-input">
            <div class="input-emogi"><i class="fa fa-envelope"></i></div>
            <input type="email" name="email" placeholder="Email address">
            <span class="error">*</span>
        </div>

        <div class="form-input">
            <div class="input-emogi"><i class="fa fa-user"></i></div>
            <input type="text" name="username" placeholder="Username">
            <span class="error">*</span>
        </div>

        <div class="form-input">
            <div class="input-emogi"><i class="fa fa-lock"></i></div>
            <input type="password" name="password" id="password" placeholder="Password">
            <span class="error">*</span>
        </div>

        <div class="form-input">
            <div class="input-emogi"><i class="fa fa-lock"></i></div>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
            <span class="error">*</span>
        </div>

        <div class="form-submit">
            <input type="submit" name="submit" value="Create Account">
        </div>

        <span id='message'></span>
        <div class="error"><?php echo $emailErr ?></div>
        <div class="error"><?php echo $usernameErr ?></div>
        <div class="error"><?php echo $passwordErr ?></div>
        <div class="error"><?php echo $existingUser ?></div>
        <div class="error"><?php echo $failedToRegister ?></div>
        <div class='success'><?php echo $successRegister ?></div>

        <div class="form-login">
            <li><a href="login.php">Log In</a></li>
        </div>
    </form>

    <script>
        $(document).ready(function(){
            $('#password, #confirm_password').on('keyup', function () {
                if ($('#password').val() == $('#confirm_password').val()) {
                    $('#message').html('Matching').css('color', 'green');
                } else
                    $('#message').html('Not Matching').css('color', 'red');
            });
        });
    </script>
</body>
</html>
