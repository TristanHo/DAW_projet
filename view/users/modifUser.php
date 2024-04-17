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

        echo "<label for='nom'>Nom : </label>";
        echo "<input id='nom' name='nom' type='text' value='".$user->getNom()."'><br>";
        echo "<label for='prenom'>Prénom : </label>";
        echo "<input id='prenom' name='prenom' type='text' value='".$user->getPrenom()."'><br>";
        echo "<label for='role'>Rôle : </label>";
        echo "<input id='role' name='role' type='text' value='".$user->getRole()."'><br>";

        echo "<input type='submit' value='Valider'/>";
        echo "<input type='hidden' name='action' value='modifUser'/>";
        echo "<input type='hidden' name='id' value='".$user->getId()."'/>";
    ?>
</form>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>