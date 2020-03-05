


<?php
    if(isset($_POST['update-profile'])) {
        //user ID
        $username_id = $_SESSION['accId'];
        //request for new login name
        $requestUsername = $_POST['username'];

           if(!empty($requestUsername)) {
             $query = "UPDATE accounts SET login = ? WHERE account_id = ? ;";
             $stmt = mysqli_stmt_init($dbc);
             if(!mysqli_stmt_prepare($stmt, $query)) {
                header("Location: profile.php?update=error");
              }else {
                mysqli_stmt_bind_param($stmt, "ss", $requestUsername, $username_id);
                mysqli_stmt_execute($stmt);

                header("Location: profile.php?account=updated");
              }
           }

           //Image
           $today = date("Y-m-d");
           $image_tempname = $_FILES['image_filename']['name'];

           //Directory
           $imageDir = "D:/xampp/htdocs/Markete/profiles/";
           $imageName = $imageDir . $image_tempname;

             if(move_uploaded_file($_FILES['image_filename']['tmp_name'],
                                $imageName)) {

                    list($width, $height, $type, $attr) = getimagesize($imageName);

                    if($type > 3) {
                        echo "Sorry, but the file you uploaded was not a GIF, JPG or PNG FILE<br>";
                    }else {
                      $query = "INSERT INTO images
                                (image_username, image_date, status)
                                VALUES
                                (?,?,?)
                       ;";
                       $stmt = mysqli_stmt_init($dbc);
                       if(!mysqli_stmt_prepare($stmt, $query)) {
                          header("Location: index.php?imageupload=failed");
                          exit();
                       }else {
                          header("Location: profile.php?imageupload=success");

                          $status = "1";
                          mysqli_stmt_bind_param($stmt, "sss", $username_id, $today, $status);
                          mysqli_stmt_execute($stmt);

                          $lastpicid = mysqli_insert_id($dbc);

                          $newfilename = $imageDir . $lastpicid . ".jpg";

                          if($type == 2) {
                              //rename($imageName, $newfilename);

                              $image_old = imagecreatefromjpeg($imageName);
                          }else {
                            if ($type == 1) {
                              $image_old = imagecreatefromgif($imageName);
                            }else if ($type == 3) {
                              $image_old = imagecreatefrompng($imageName);
                            }
                          }

                          $newwidth = 80;
                          $newheight = 80;
                          $image_jpg = imagecreatetruecolor($newwidth, $newheight);

                          imagecopyresampled($image_jpg, $image_old, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                          imagejpeg($image_jpg, $newfilename);

                          imagedestroy($image_old);
                          imagedestroy($image_jpg);

                        }
                    }
              }

         }

 ?>
