<?php session_start(); ?>

<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" href="../css/topic.css">
    </head>

    <body>

        <?php
            $_SESSION['login'] = "admin";
            include('../../controller/ControllerForum.php');
            ControllerForum::retrieveTopics('Mécanique'); //REMPLACER PARAMETRE PAR VALEUR DU COURS

        ?>

    </body>
</html>