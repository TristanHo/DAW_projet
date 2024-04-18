<?php session_start(); ?>
<?php require_once("../css/theme.php");?>

<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" href="../css/message.css">
    </head>

    <body>

        <?php

            error_reporting(E_ALL);
            include('../../controller/ControllerForum.php');
            ControllerForum::retrieveMessages();

        ?>

    </body>
</html>