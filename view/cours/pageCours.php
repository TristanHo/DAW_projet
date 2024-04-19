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
    
    //afficher tous les qcm pour l'etudiant en recuperent son niveau
    //besoin de fonction recupe lv accesible pour un etudiant (lv valider plus 1 )

        echo "<a href='../forum/forum_template.php?className=".$cours->getNom()."'>Forum</a>";

        echo "<input type='hidden' name='action' value='deleteCours'/>";
        echo "<input type='hidden' name='id' value='".$cours->getId()."'/>";

        if($_COOKIE['role'] == 'administrateur' || $_COOKIE['login'] == $cours->getResponsable()) {
            echo "<p>------------------Modification du cours------------------------</p>";
            echo "<a href='modifCours.php?id=".$cours->getId()."'>Modifier le cours</a><br/><br/>";
            echo "<input type='submit' value='Supprimer le cours'/>";
            echo "<p>---------------------------------------------------------</p>";
        }
?>
</form>
<?php
    echo "<p>------------------Partie QCM------------------------</p>";
    require_once('../../controller/ControllerCours.php');
    require_once('../../controller/ControllerUser.php');
    
    $cours = ControllerCours::getCours($_GET['id']);
    $resp = ControllerUser::getUserLogin($cours->getResponsable());
    //Afficher les QCM 
    require_once('../../controller/ControllerQCM.php');
    $lvetudiant=ControllerQCM::recuplvetu($cours->getNom(),$_COOKIE['login']);
    echo"<a href='../qcm/formulaireQcm.php?idqcm=". $cours->getNom() ."1'>Faire le QCM de niveau 1</a><br>";
    if ($lvetudiant>1 || $_COOKIE['role'] == 'professeur') {
        echo"<a href='../qcm/formulaireQcm.php?idqcm=". $cours->getNom() ."2'>Faire le QCM de niveau 2</a><br>";
    }
    if($lvetudiant> 2 || $_COOKIE['role'] == 'professeur') {
        echo"<a href='../qcm/formulaireQcm.php?idqcm=". $cours->getNom() ."3'>Faire le QCM de niveau 3</a><br>";
    } 
        //Affiche les options de modification et de suppression si l'utilisateur est l'administrateur ou le responsable du cours
        if($_COOKIE['role'] == 'administrateur' || $_COOKIE['login'] == $cours->getResponsable()) {
            //afficher la liste des cours avec la possibilité des mofifier
           
            echo"<br/><a href='../qcm/modifQcm.php?idqcm=". $cours->getNom() ."1'>Le QCM de niveau 1</a><br>";
            echo"<a href='../qcm/modifQcm.php?idqcm=". $cours->getNom() ."2'>Le QCM de niveau 2</a><br>";
            echo"<a href='../qcm/modifQcm.php?idqcm=". $cours->getNom() ."3'>Le QCM de niveau 3</a><br><br/>";
        }
    ?>
<p>---------------------------------------------------------</p>

<p>------------------Partie fichiers------------------------</p>
<?php
    require_once('../../controller/ControllerFichier.php');
    $cours = ControllerCours::getCours($_GET['id']);
    $resp = ControllerUser::getUserLogin($cours->getResponsable());
    

    if(isset($_GET['lvl']) && $_COOKIE['role'] == 'etudiant'){
        //Affichage de lien cliquable pour télécharger les fichiers des cours
        $fichiers = ControllerFichier::getFichiersCours($cours->getNom(),$_GET['lvl']);
        if(count($fichiers)>0){
            echo "Fichiers du cours (cliquer sur le lien pour le télécharger):</br></br>";
        }

        $i = 0;
        foreach($fichiers as $file){
            $path = $file->getPath();
            $nv = $file->getNvCours();
            $i++;
            echo "<a href=".$path." download>Fichier $i (niveau $nv)</a><br/><br/>";
        }
    }
    else{
        //Affichage de lien cliquable pour télécharger les fichiers des cours
        $fichiers = ControllerFichier::getFichiersCours($cours->getNom(),null);
        
        if(count($fichiers)>0){
            echo "Fichiers du cours (cliquer sur le lien pour le télécharger):</br></br>";
        }

        $i = 0;
        foreach($fichiers as $file){
            $path = $file->getPath();
            $nv = $file->getNvCours();
            $i++;
            echo "<a href=".$path." download>Fichier $i (niveau $nv)</a><br/>";
            if($_COOKIE['role'] == 'administrateur' || $_COOKIE['login'] == $cours->getResponsable()){
                //bouton pour supprimmer les fichiers
                $id_cours = $_GET['id'];
                echo "<form action='../../config/routeur.php' method='post'>
                <input type='hidden' name='action' value='supprimerFichier'/>
                <input type='hidden' name='path' value='$path'/>
                <input type='hidden' name='id_cours' value='$id_cours'/>
                <input type='submit' value='Supprimer ce fichier'/>
                </form></br>";
            }
        }
    }

    
    echo "<p>---------------------------------------------------------</p>";
    //Retour vers l'accueil
    echo "<br/><a href='../users/accueil.php'>Revenir à l'accueil</a>";

?>


<p id="infos"></p>
<?php require("../css/footer.php");?>



</body>
<?php require("../css/footer.php");?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>