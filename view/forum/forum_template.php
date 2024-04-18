<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>

    <?php require("../../view/css/stylesheet.php");?>

    </head>

    

    <body>

        <?php require("../css/header.php");?>

        <?php

            include('../../controller/ControllerForum.php');
            ControllerForum::retrieveTopics('Mécanique'); //REMPLACER PARAMETRE PAR VALEUR DU COURS

        ?>

    <?php require_once("../css/footer.php");?>

    </body>
</html>