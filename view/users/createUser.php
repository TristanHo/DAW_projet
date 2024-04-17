<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>

<form action='../../config/routeur.php' method="post">
    <?php
        if($_COOKIE['role'] = 'administrateur') {
            echo "<label for='login'>Login : </label>";
            echo "<input id='login' name='login' type='text'><br>";
            echo "<label for='mdp'>Mot de passe : </label>";
            echo "<input id='mdp' name='mdp' type='text'><br>";
            echo "<label for='nom'>Nom : </label>";
            echo "<input id='nom' name='nom' type='text'><br>";
            echo "<label for='prenom'>Prénom : </label>";
            echo "<input id='prenom' name='prenom' type='text'><br>";
            echo "<label for='etudiant'>Etudiant</label>";
            echo "<input type='radio' name='role' value='etudiant' checked/>";
            echo "<label for='professeur'>Professeur</label>";
            echo "<input type='radio' name='role' value='professeur'/><br/>";

            echo "<input type='submit' value='Valider'/>";
            echo "<input type='hidden' name='action' value='createUser'/>";
        }
        else {
            echo "<h1>Accès refusé</h1><br>";
            echo "<a href='accueil.php'>Revenir à la page d'accueil</a>";
        }
    ?>
</form>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>