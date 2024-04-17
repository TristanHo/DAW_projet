<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet">
</head>
<body>
    <h1>Bienvenue 
        <?php
            echo $_COOKIE['nom']." ".$_COOKIE['prenom'];
        ?>
    </h1>
    <p>
    <?php 
        switch ($_COOKIE['role']){
            case 'etudiant' : echo 'Je suis étudiant <a href="profilUser?id='.$_COOKIE['id'].'">Voir mon profil</a>'; break;
            case "professeur" : echo 'Je suis professeur <a href="profilUser?id='.$_COOKIE['id'].'">Voir mon profil</a>'; break;
            case "administrateur" : echo '<a href="listeUsers.php">Gérer la liste d\'utilisateurs</a> <a href="profilUser?id='.$_COOKIE['id'].'">Voir mon profil</a>'; break;
        }
    ?>
    </p>
    <script type="text/javascript">
        //window.location.replace($_SERVER['REQUEST_URI']);
    </script>
</body>
</html>