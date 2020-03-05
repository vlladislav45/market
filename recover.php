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
    <form action="requires/reset-request.inc.php" method="post">
        <h1> Recover password </h1>
        <div class="form-input">
            <input type="email" name="email" placeholder="Email">
        </div>
        <input type="submit" name="recover-request-submit" value="Send a request">
    </form>
        <?php
            if(isset($_GET['reset'])){
                if($_GET['reset'] == "success"){
                    echo "<p>Check your email address.</p>";
                }
            }
        ?>
</body>
</html>