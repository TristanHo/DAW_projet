<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("../css/stylesheet.php");?>
    <title>Modifier un cours</title>
</head>
<body>

<?php require("../css/header.php");?>


<form action='../../config/routeur.php' method="post">
    
    <?php
        require_once('../../controller/ControllerCours.php');
        $cours = ControllerCours::getCours($_GET['id']);
        //Autorise l'accès si la personne qui accède à la page est l'administrateur ou le responsable du cours
        if($_COOKIE['role'] == 'administrateur' || $_COOKIE['login'] == $cours->getResponsable()) {

            echo "<label for='nom'>Nom du cours : </label>";
            echo "<input id='nom' name='nom' type='text' value='".$cours->getNom()."'><br>";

            //Ajouter les QCM

            echo "<input type='hidden' name='id' value='".$cours->getId()."'/>";
        }
        else { //Sinon refuse l'accès
            echo "<h1>Accès refusé</h1><br>";
            echo "<a href='accueil.php'>Revenir à la page d'accueil</a>";
        }
    ?>
        <input type='submit' id='valider' value='Valider'/>
        <input type='hidden' name='action' value='modifCours'/>
</form>

<?php require("../css/footer.php");?>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

</html>