<?php /** @noinspection PhpDeprecationInspection */
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "1234";

    $dbc = mysqli_connect($db_server, $db_user, $db_pass)
            or die(mysqli_connect_error());

    mysqli_select_db($dbc, "market")
        or die(mysqli_error($dbc));
?>
