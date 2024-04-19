<?php session_start(); ?>
<?php require_once("../css/theme.php");?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/message.css">
        <?php require("../../view/css/stylesheet.php");?>
    </head>

    <body>

        <?php require("../css/header.php");?>

        <?php

            /////////////////////////////////////
            $_COOKIE['role'] = "administrateur";
            $_COOKIE['login'] = "administrateur";
            /////////////////////////////////


            error_reporting(E_ALL);
            include('../../controller/ControllerForum.php');
            ControllerForum::retrieveMessages();

        ?>

        <?php require_once("../css/footer.php");?>

    </body>
</html>