<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/message.css">
        <?php require("../../view/css/stylesheet.php");?>
    </head>

    <body>

        <?php require("../css/header.php");?>

        <?php

            error_reporting(E_ALL);
            include('../../controller/ControllerForum.php');
            ControllerForum::retrieveMessages();

        ?>
        
        
        <a href='forum_template.php'>Retour à l'accueil du forum</a>
        
        
        <?php require_once("../css/footer.php");?>

        
    </body>
</html>