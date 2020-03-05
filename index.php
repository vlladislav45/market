<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon/Chat-Shopping-girl.ico">
    <title>Main page</title>

    <!--External Styles-->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/dropdown.css">
    <link rel="stylesheet" href="styles/footer.css">

    <!--External Scripts-->
    <script
            src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous"></script>
    <script src="scripts/mainpage.js"></script>
</head>
<body>
    <header>
        <ul class="header-ul">
            <li class="header-btn button"><a href="#">Services</a>
                <ul class="dropdown first">
                    <li><a href="index.php">Home</a></li>

                    <li><a href="login.php">Login</a></li>

                    <li><a href="register.php">Register</a></li>

                    <li><a href="info.php">Information</a></li>

                    <li><a href="contacts.php">Contacts</a></li>
                </ul>
            </li>

            <li class="header-btn sec-btn"><a href="#">Free Shop</a>
                <ul class="dropdown sec">
                    <li><a href="#">Free Templates<br>(used)</a></li>

                    <li><a href="#">Free Files<br>(used)</a></li>
                </ul>
            </li>
        </ul>

        <div id="profile" class="profile">
                <?php
                    if(isset($_SESSION['accId'])) {
                      require "config/stats.php";

                      $userId = $_SESSION['accId'];


                      ?>
                            <li class='form-btn'><a href='profile.php'>Profile</a></li>

                            <li class='form-btn'><a href='requires/logout.inc.php'>Logout</a></li>

                      <?php


                      $query = "SELECT * FROM images WHERE image_username = ?;";
                      $stmt = mysqli_stmt_init($dbc);
                      if(!mysqli_stmt_prepare($stmt, $query)) {
                          header("Location: index.php?sql=error");
                          exit();
                      }else {

                        mysqli_stmt_bind_param($stmt, "s", $userId);
                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);
                        while($row = mysqli_fetch_assoc($result)) {
                            // $tempid = $row['image_id'];
                            // if($row['image_id'] > $tempid) {
                            //     $query = "DELETE FROM images WHERE image_id = ?;";
                            //     $stmt = mysqli_stmt_init($dbc);
                            //
                            //     if(!mysqli_stmt_prepare($stmt, $query)) {
                            //       header("Location: index.php?sql=error");
                            //       exit();
                            //     }else {
                            //
                            //       mysqli_stmt_bind_param($stmt, "s", $tempid);
                            //       mysqli_stmt_execute($stmt);
                            //
                            //       }
                            //     }
                            //else {
                                    if($row['status'] == 1) {
                                      $image = "profiles/" . $row['image_id'] . ".jpg";
                                      ?>
                                          <script>
                                              let profile = $('#profile');
                                              profile.css('padding', '8px');

                                              $('.form-btn').remove();
                                          </script>

                                          <div id="profile-img" class="new-profile" style="background-image: url(<?php echo $image ?>); ">


                                            <li class='new-form-btn'><a href='profile.php'>Profile</a></li>

                                            <li class='new-form-btn'><a href='requires/logout.inc.php'>Logout</a></li>


                                          </div>


                                      <?php

                              //  }


                            }
                          }
                        }

                      }else {
                        ?>

                          <li class='form-btn'><a href='login.php'>Log in</a></li>

                          <li class='form-btn'><a href='register.php'>Sign up</a></li>

                        <?php
                      }


                ?>
        </div>
    </header>

    <main>
        <div class="mountains">
            <div class="temp-container">
                <div class="frames">
                    <div class="frame1">
                        <span> Newest Template 25 EURO per 7 days </span>
                    </div><!-- /.frame1-->

                    <div class="frame2">
                        <span> Place for ad or template 45 EURO per month </span>
                    </div><!-- /.frame2-->
                </div><!-- /.frames-->
            </div>

            <ul class="main-nav">
                <div class="container">
                    <li class="btn custom-btn1"><a href="#">Games</a></li>

                    <li class="btn custom-btn2"><a href="#">Blogs</a></li>
                </div><!-- /.container-->

                <li class="diamond" id="diamond-button"></li><!-- /.diamond button-->

                <div class="reverse">
                    <li class="btn custom-btn3"><a href="#">Markets</a></li>

                    <li class="btn custom-btn4"><a href="#">Models</a></li>
                </div><!-- /.reverse container-->
            </ul><!-- /.main navigation-->
        </div><!-- /.mountains-->


        <div class="features">
            <span>Welcome to bestcustomtemplates.com</span>
             <?php if(isset($_SESSION['accId'])) {
                echo "<h2 style='color: #250801;'>" . $_SESSION['accUsername'] . "</h2>";
             }
             ?>
            <div class="shell">
                <?php require "game-templates.php"; ?>

            </div><!-- /.shell-->
        </div><!-- /.features-->
    </main><!-- /.main-->

    <footer>
        <div class="footer">
            <p>This site is created by Team in &copy 2019 Coder: vlladislav45 / Designer: Salieri</p>
        </div>
    </footer>
</body>
</html>
