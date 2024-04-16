<?php session_start() ?>

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

        <form method="get" action="../../controller/routeur.php" class="inputArea">
            <textarea name="messageInput" rows="5" cols="40" placeholder="Saisir un message... (Problème si message contient des apostrophes" size="50"></textarea><br>
            <input type="submit" value="Envoyer">
        </form>

    </body>
</html>