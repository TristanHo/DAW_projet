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
        $cours = ControllerCours::getCours($_GET['id']);
        $resp = ControllerUser::getUserLogin($cours->getResponsable());

        echo "<h1>Cours de ".$cours->getNom()."</h1>";
        echo " par <a href='../users/profilUser.php?id=".$resp->getId()."'>".$resp->getNom()." ".$resp->getPrenom()."</a><br><br>";

        //Ajouter QCM

        //Affiche les options de modification et de suppression si l'utilisateur est l'administrateur ou le responsable du cours
        if($_COOKIE['role'] == 'administrateur' || $_COOKIE['login'] == $cours->getResponsable()) {
            echo "<a href='modifCours.php?id=".$cours->getId()."'>Modifier le cours</a><br/><br/>";
            echo "<input type='submit' value='Supprimer le cours'/>";
        }

        //Retour vers l'accueil
        echo "<br><br/><a href='../users/accueil.php'>Revenir à l'accueil</a>";

        echo "<input type='hidden' name='action' value='deleteCours'/>";
        echo "<input type='hidden' name='id' value='".$cours->getId()."'/>";
    ?>
</form>

<?php
    require_once('../../controller/ControllerFichier.php');
    $cours = ControllerCours::getCours($_GET['id']);
    $resp = ControllerUser::getUserLogin($cours->getResponsable());
    

    //Affichage de lien cliquable pour télécharger les fichiers des cours
    $fichiers = ControllerFichier::getFichiersCours($cours->getNom());
    
    if(count($fichiers)>0){
        echo "Fichiers du cours (cliquer sur le lien pour le télécharger):</br></br>";
    }
    $i = 0;
    foreach($fichiers as $file){
        $path = $file->getPath();
        $i++;
        echo "<a href=".$path." download>Fichier $i</a></br>";
        if($_COOKIE['role'] == 'administrateur' || $_COOKIE['login'] == $cours->getResponsable()){

        }
    }

?>

<?php require("../css/footer.php");?>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>