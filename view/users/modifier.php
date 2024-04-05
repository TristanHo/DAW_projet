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

        echo "<label for='nom'>Nom : </label>";
        echo "<input id='nom' type='text' value='".$user->getNom()."'><br>";
        echo "<label for='prenom'>Prénom : </label>";
        echo "<input id='prenom' type='text' value='".$user->getPrenom()."'><br>";
        echo "<label for='role'>Rôle : </label>";
        echo "<input id='role' type='text' value='".$user->getRole()."'><br>";

        echo "<input type='submit' value='Valider'/>"
    ?>
    <br><br> <input type="button" id="theme" value="Mode nuit"/>
</form>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>