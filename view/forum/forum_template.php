<?php session_start(); ?>
<?php require_once("../css/theme.php");?>

<!DOCTYPE html>
<html>
    <head>

    <?php require("../../view/css/stylesheet.php");?>

    <link rel="stylesheet" href="../css/topic.css">
    </head>

    

    <body>

        <?php require("../css/header.php");?>

        <?php
            $_SESSION['login'] = "admin";
            include('../../controller/ControllerForum.php');

            if(isset($_GET['className'])){ ControllerForum::retrieveTopics($_GET['className']); }
            else{ ControllerForum::retrieveTopics($_SESSION['class_name']); }

        ?>

    <?php require_once("../css/footer.php");?>

    </body>
</html>