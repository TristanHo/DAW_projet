<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("../css/stylesheet.php");?>
    <title>Page du cours</title>
</head>
<body>

<?php require("../css/header.php");?>

<form action='../../config/routeur.php' method="post">
    <?php
        require_once('../../controller/ControllerCours.php');
        require_once('../../controller/ControllerUser.php');
        require_once('../../controller/ControllerQCM.php');
        $cours = ControllerCours::getCours($_GET['id']);
        $resp = ControllerUser::getUserLogin($cours->getResponsable());

        echo "<h1>Cours de ".$cours->getNom()."</h1>";
        echo " par <a href='../users/profilUser.php?id=".$resp->getId()."'>".$resp->getNom()." ".$resp->getPrenom()."</a><br><br>";
    
    //afficher tous les qcm pour l'etudiant en recuperent son niveau
    //besoin de fonction recupe lv accesible pour un etudiant (lv valider plus 1 )


        //Afficher le cours 
    $lvetudiant=ControllerQCM::recuplvetu($cours,$_COOKIE['login']);
    echo"Faire le QCM de niveau 1<a href='../qcm/formulaireQcm.php?idqcm=". $cours ."1'</a><br>";
    if ($lvetudiant>1) {
        echo"Faire le QCM de niveau 1<a href='../qcm/formulaireQcm.php?idqcm=". $cours ."2'</a><br>";
    }
    if ($lvetudiant> 2) {
        echo"Faire le QCM de niveau 3<a href='../qcm/formulaireQcm.php?idqcm=". $cours ."3'</a><br>";
    }

        //Affiche les options de modification et de suppression si l'utilisateur est l'administrateur ou le responsable du cours
        if($_COOKIE['role'] == 'administrateur' || $_COOKIE['login'] == $cours->getResponsable()) {
            //afficher la liste des cours avec la posibiliter des mofifier
           


            
            echo"Le QCM de niveau 1<a href='../qcm/modifQcm.php?idqcm=". $cours ."1'</a><br>";
            echo"Le QCM de niveau 2<a href='../qcm/modifQcm.php?idqcm=". $cours ."2'</a><br>";
            echo"Le QCM de niveau 3<a href='../qcm/modifQcm.php?idqcm=". $cours ."3'</a><br>";

            echo "<a href='modifCours.php?id=".$cours->getId()."'>Modifier le cours</a>";
            echo "<input type='submit' value='Supprimer le cours'/>";
        }

        //Retour vers l'accueil
        echo "<br><a href='../users/accueil.php'>Revenir à l'accueil</a>";

        echo "<input type='hidden' name='action' value='deleteCours'/>";
        echo "<input type='hidden' name='id' value='".$cours->getId()."'/>";
    ?>
</form>

<?php require("../css/footer.php");?>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>