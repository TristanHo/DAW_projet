<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("../../view/css/stylesheet.php");?>
    <title>Liste des utilisateurs</title>
</head>
<body>
<?php require("../css/header.php");?>
<form action='../../config/routeur.php' method="post">
    <?php
        if($_COOKIE['role'] == 'administrateur') {
            require_once(__DIR__.'/../../model/ModelUser.php');
            echo "<a href='createUser.php'>Ajouter un utilisateur</a><br>";
            $users = ModelUser::getUsers();
            echo "<table border = 1>";
            echo "<tr><td>ID</td><td>Nom</td><td>Prénom</td><td>Rôle</td><td>Login</td><td>Mot de passe</td><td></td></tr>";
            foreach($users as $user) {
                echo "<tr>";
                echo "<td>".$user->getId()."</td>";
                echo "<td>".$user->getNom()."</td>";
                echo "<td>".$user->getPrenom()."</td>";
                echo "<td>".$user->getRole()."</td>";
                echo "<td>".$user->getUsername()."</td>";
                echo "<td>".$user->getPassword()."</td>";
                echo "<td><a href='profilUser.php?id=".$user->getId()."'>Voir profil</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else {
            echo "<h1>Accès refusé</h1><br>";
            echo "<a href='accueil.php'>Revenir à la page d'accueil</a>";
        }
    ?>
</form>

<?php require_once("../css/footer.php");?>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>