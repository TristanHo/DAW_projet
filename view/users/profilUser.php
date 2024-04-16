<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>

<form action='../../config/routeur.php' method="get">
    <?php
        require_once('../../controller/ControllerUser.php');
        $user = ControllerUser::getUser($_GET['id']);

        echo "Login : ".$user->getUsername()."<br>";
        echo "Nom : ".$user->getNom()." ";
        echo "Prenom : ".$user->getPrenom()."<br>";
        echo "Role : ".$user->getRole()."<br>";

        if($_COOKIE['role'] == 'admin') {
            echo "<a href='modifUser.php?id=".$user->getId()."'>Modifier utilisateur</a>";
            echo "<input type='submit' value='Supprimer utilisateur'/>";
        }

        echo "<input type='hidden' name='action' value='deleteUser'/>";
        echo "<input type='hidden' name='id' value='".$user->getId()."'/>";

    ?>
</form>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>