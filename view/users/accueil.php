<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet">
</head>
<body>
    <h1>Bienvenue 
        <?php 
        echo "".$_COOKIE['prenom'];
        echo " ".$_COOKIE['nom'];
        ?>
    </h1>
    <p>
    <?php 
        switch ($_COOKIE['role']){
            case "etudiant" : echo
            'Je suis étudiant
            ';break;
            case "professeur" : echo
            'Je suis professeur
            ';break;

            case "administrateur" : echo 
            '<a href="../view/users/listeUsers.php">Gérer la liste d\'utilisateurs</a>
            <br/>
            <a href="../view/users/createUser.php">Créer un utilisateur</a>
            <br/>
            ';break;
        }
    ?>
    </p>
    <script type="text/javascript">
        //window.location.replace($_SERVER['REQUEST_URI']);
    </script>
</body>
</html>