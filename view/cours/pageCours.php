<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("../css/theme.php");?>
    <title>Page du cours</title>
</head>
<body>

<form action='../../config/routeur.php' method="post">
    <?php
        require_once('../../controller/ControllerCours.php');
        require_once('../../controller/ControllerUser.php');


        $_COOKIE['role'] = "administrateur";
        $_COOKIE['login'] = "administrateur";


        $cours = ControllerCours::getCours($_GET['id']);
        $resp = ControllerUser::getUserLogin($cours->getResponsable());

        echo "<h1>Cours de ".$cours->getNom()."</h1>";
        echo " par <a href='../users/profilUser.php?id=".$resp->getId()."'>".$resp->getNom()." ".$resp->getPrenom()."</a><br><br>";

        //Ajouter QCM

        //Affiche les options de modification et de suppression si l'utilisateur est l'administrateur ou le responsable du cours
        if($_COOKIE['role'] == 'administrateur' || $_COOKIE['login'] == $cours->getResponsable()) {
            echo "<a href='modifCours.php?id=".$cours->getId()."'>Modifier le cours</a>";
            echo "<input type='submit' value='Supprimer le cours'/><br>";
        }

        echo "<a href='../forum/forum_template.php?className=".$cours->getNom()."'>Forum</a>";

        //Retour vers l'accueil
        echo "<br><a href='../users/accueil.php'>Revenir à l'accueil</a>";

        echo "<input type='hidden' name='action' value='deleteCours'/>";
        echo "<input type='hidden' name='id' value='".$cours->getId()."'/>";
    ?>
</form>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>