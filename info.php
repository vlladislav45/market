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
				<form action="requires/profile.inc.php" method="POST">
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
									<input id="male" type="radio" name="user-sex" value="1" checked="">
									<label for="male">Male</label>

									<input id="female" type="radio" name="user-sex" value="2">
									<label for="female">Female</label>

									<input id="other" type="radio" name="user-sex" value="0">
									<label for="other">Other</label>

								</td>
							</tr>
						</tbody>
					</table>
					<br>
					<div class="btn-type1">
						<input class="button" type="submit" name="update-profile" value="  Update  ">
					</div>
				</form>
			</div>
			<div id="pfp-settings">
			</div>
		</div>
	</div>
</body>
