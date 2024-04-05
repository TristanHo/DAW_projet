<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>

<form action='../controller/routeur.php' method="get">
    <?php
        require_once('../../model/ModelUser.php');
        $user = ModelUser::getUser($_GET['id']);

        echo "Login : ".$user->getUsername()."<br>";
        echo "Nom : ".$user->getNom()." ";
        echo "Prenom : ".$user->getPrenom()."<br>";
        echo "Role : ".$user->getRole()."<br>";

        if($_GET['role'] == 'admin') {
            echo "<a href='modifier.php?id=".$user->getId()."'>Modifier utilisateur</a>";
            echo "<input type='button' value='Supprimer utilisateur'/>";
        }

    ?>
    <br><br> <input type="button" id="theme" value="Mode nuit"/>
</form>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>