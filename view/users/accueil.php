<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <?php require_once("../css/theme.php");?>
  <title>Page d'accueil</title>
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
            case 'etudiant' : echo 'Je suis étudiant '; break;
            case "professeur" : echo 'Je suis professeur '; break;
            case "administrateur" : echo '<a href="listeUsers.php">Gérer la liste d\'utilisateurs</a> <a href="../cours/listeCours.php">Gérer la liste des cours</a>'; break;
        }
        echo '<a href="profilUser?id='.$_COOKIE['id'].'">Voir mon profil</a>';
    ?>
    </p>
    <script type="text/javascript">
        //window.location.replace($_SERVER['REQUEST_URI']);
    </script>
</body>
</html>