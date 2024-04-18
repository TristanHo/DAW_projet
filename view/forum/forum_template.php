<?php session_start(); ?>
<?php require_once("../css/theme.php");?>

<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" href="../css/topic.css">
    </head>

    <body>

        <?php
            $_SESSION['login'] = "admin";
            include('../../controller/ControllerForum.php');

            if(isset($_GET['className'])){ ControllerForum::retrieveTopics($_GET['className']); }
            else{ ControllerForum::retrieveTopics($_SESSION['class_name']); }

        ?>

    </body>
</html>