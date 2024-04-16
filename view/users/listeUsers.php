<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
</head>
<body>

<form action='../../config/routeur.php' method="get">
    <?php
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
            echo "<td><a href='profilUser.php?id=".$user->getId()."&role=admin'>Voir profil</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    ?>
</form>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>