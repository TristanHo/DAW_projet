<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>

<form action='../../config/routeur.php' method="post">
    <?php
        if($_COOKIE['role'] == 'administrateur') {
            require_once('../../controller/ControllerUser.php');
            $user = ControllerUser::getUser($_GET['id']);

            echo "<label for='nom'>Nom : </label>";
            echo "<input id='nom' name='nom' type='text' value='".$user->getNom()."'><br>";
            echo "<label for='prenom'>Prénom : </label>";
            echo "<input id='prenom' name='prenom' type='text' value='".$user->getPrenom()."'><br>";
            echo "<label for='role'>Rôle : </label>";
            echo "<input id='role' name='role' type='text' value='".$user->getRole()."'><br>";

            echo "<input type='hidden' name='id' value='".$user->getId()."'/>";
        }
        else {
            echo "<h1>Accès refusé</h1><br>";
            echo "<a href='accueil.php'>Revenir à la page d'accueil</a>";
        }
    ?>
        <input type='submit' id='valider' value='Valider'/>
        <input type='hidden' name='action' value='modifUser'/>
</form>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

</html>