<?php session_start(); ?>

<!DOCTYPE html>

<html>
    <head>

    </head>

    <body>

        <?php

            include('../../controller/ControllerForum.php');
            ControllerForum::retrieveTopics('Mécanique'); //REMPLACER PARAMETRE PAR VALEUR DU COURS

        ?>

    </body>
</html>