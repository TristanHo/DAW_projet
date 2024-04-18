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

            error_reporting(E_ALL);
            include('../../controller/ControllerForum.php');
            ControllerForum::retrieveMessages();

        ?>

        <form method="get" action="../../controller/routeur.php" class="inputArea">
            <textarea name="messageInput" rows="5" cols="40" placeholder="Saisir un message... (Problème si message contient des apostrophes" size="50"></textarea><br>
            <input type="submit" value="Envoyer">
        </form>

        <?php require_once("../css/footer.php");?>

    </body>
</html>