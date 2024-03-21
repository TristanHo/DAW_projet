<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Question</title>
</head>
<body>

<form action='../controller/routeur.php' method="get">
    <input type="button" value="Ajouter un utilisateur"/><br>
    <?php
        $users = ModelUser::getUsers();
        foreach($users as $user) {
            echo $user->getUsername().' <input type="button" value="Modifier"/> <input type="button" value="Supprimer"/> <br>';
        }

    ?>
</form>

</body>
</html>