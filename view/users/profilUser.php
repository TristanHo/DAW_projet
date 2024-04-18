<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("../../view/css/stylesheet.php");?>
    <title>Profil</title>
</head>
<body>

<?php require("../css/header.php");?>

<form action='../../config/routeur.php' method="post">
    <?php
        require_once('../../controller/ControllerUser.php');
        $user = ControllerUser::getUser($_GET['id']);

        echo "Nom : ".$user->getNom()."<br>";
        echo "Prenom : ".$user->getPrenom()."<br>";
        echo "Role : ".$user->getRole()."<br>";

        if($_COOKIE['role'] == 'administrateur') {
            echo "<a href='modifUser.php?id=".$user->getId()."'>Modifier utilisateur</a>";
            echo "<input type='submit' value='Supprimer utilisateur'/>";
        }

        echo "<input type='hidden' name='action' value='deleteUser'/>";
        echo "<input type='hidden' name='id' value='".$user->getId()."'/>";

    ?>
</form>

<?php require_once("../css/footer.php");?>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>