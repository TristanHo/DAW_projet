<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>

    <?php require("../../view/css/stylesheet.php");?>

    <link rel="stylesheet" href="../css/topic.css">
    </head>

    

    <body>

        <?php require("../css/header.php");?>

        <?php

            include('../../controller/ControllerForum.php');

            if(isset($_GET['className'])){ ControllerForum::retrieveTopics($_GET['className']); }
            else{ ControllerForum::retrieveTopics($_SESSION['class_name']); }

        ?>

        <br/>
        <a href='../users/accueil.php'>Retour à l'accueil</a>
    <?php require_once("../css/footer.php");?>

    </body>
</html>