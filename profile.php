<?php
    session_start();

    require "config/stats.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>

    <!--External Styles-->
    <link rel="stylesheet" href="styles/profile/profile.css">
    <link rel="icon" href="images/favicon/Chat-Shopping-girl.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>
<body>
	<div class="wrapper">
		<div class="setting-profile-top">
			<h2>Account settings</h2>
			<div class="menu">
			</div>
		</div>
		<div class="setting-body">
			<div class="text-settings">
      <?php  if(isset($_SESSION['accId'])) {
          require "requires/profile.inc.php";
          ?>

        <form action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> " method="POST" enctype="multipart/form-data" >
          <table id="profile-table">
            <tbody>

              <tr>
                <td width="10%">
                  <span>Nickname</span>
                </td>
                <td colspan="2" width="40%">
                  <input id="nick" type="text" name="username">
                </td>
              </tr>

              <tr>
                <td width="10%">
                  <span>Gender</span>
                </td>
                <td>
                  <input type="radio" name="male">
                  <label for="male">Male</label>

                  <input type="radio" name="female">
                  <label for="female">Female</label>

                  <input type="radio" name="other">
                  <label for="other">Other</label>

                </td>
              </tr>

              <tr>
                <td width="10%">
                    <span>Profile Image</span>
                </td>
                <td>
                    <input type="file" name="image_filename">
                </td>
              </tr>
            </tbody>
          </table>
          <br>

          <div class="btn-type1">
            <input class="button" type="submit" name="update-profile" value="Update">
          </div>

          <div>
            <a class="button" href="index.php">BACK</a>
          </div>
        </form>
    <?php  } ?>

      </div>
		</div>
	</div>
</body>
