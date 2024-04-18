<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("../css/theme.php");?>
    <title>Créer un cours</title>
</head>
<body>

<form action='../../config/routeur.php' method="post">
    <?php
        //Autorise l'accès si la personne qui accède à la page n'est pas un étudiant
        if($_COOKIE['role'] != 'etudiant') {
            echo "<label for='nom'>Nom du cours : </label>";
            echo "<input id='nom' name='nom' type='text'><br>";

            echo "<input type='submit' value='Valider'/>";
            echo "<input type='hidden' name='action' value='createCours'/>";
        }
        else { //Sinon refuse l'accès
            echo "<h1>Accès refusé</h1><br>";
            echo "<a href='accueil.php'>Revenir à la page d'accueil</a>";
        }
    ?>
</form>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>