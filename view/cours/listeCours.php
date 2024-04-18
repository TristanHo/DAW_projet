<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("../css/stylesheet.php");?>
    <title>Liste des cours</title>
</head>
<body>
<?php require("../css/header.php");?>

<form action='../../config/routeur.php' method="post">
    <?php
        //Autorise l'accès si la personne qui accède à la page est l'administrateur
        if($_COOKIE['role'] == 'administrateur') {
            require_once(__DIR__.'/../../controller/ControllerCours.php');

            echo "<a href='createCours.php'>Ajouter un cours</a><br>";
            $listecours = ControllerCours::listeCours();

            echo "<table border=1>";
            echo "<tr><td>ID</td><td>Nom</td><td>Responsable</td><td></td></tr>";
            foreach($listecours as $cours) {
                echo "<tr>";
                echo "<td>".$cours->getId()."</td>";
                echo "<td>".$cours->getNom()."</td>";
                echo "<td>".$cours->getResponsable()."</td>";
                echo "<td><a href='pageCours.php?id=".$cours->getId()."'>Voir page du cours</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else { //Sinon refuse l'accès
            echo "<h1>Accès refusé</h1><br>";
            echo "<a href='accueil.php'>Revenir à la page d'accueil</a>";
        }
    ?>
</form>
<?php require("../css/footer.php");?>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>