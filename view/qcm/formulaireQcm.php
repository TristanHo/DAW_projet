<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de QCM</title>
    <?php require("../css/stylesheet.php");?>
</head>

<body>
<?php require("../css/header.php");?>
    <form action="../../config/routeur.php" method="post">
        <?php
        //inclusion du controllerQCM pour pouvoir faire les ajout dans la BD avec la fonction calculerscore


        // pour afficher et repondre au QCM
        // Charger les questions du QCM depuis le modèle
        require_once("../../controller/ControllerQCM.php");
        $test = new ControllerQCM;
        //recuperer le cours selectionner dans l'url
        $idqcm=$_GET['idqcm'];
        if ($idqcm== null){$idqcm='qcmcours2';}
        $test->affiche_formulaire_qcm($_GET['idqcm']);
        //test pour lire un qcm de cours cree
        //$test->recupqcm("qcmcours1","../BD/exemple.xml") ;
        //test pour lire le qcmintro
        //$test->recupqcmintro("../../BD/exemple.xml");
        //$qcm = $test->getQCM();


        

        
        //mettre en hiden le login user pour pouvoir faire les ajout a la BD
        ?>
        <input type='submit' value='Valider le QCM' name='validerQCM'>
    </form>
    <?php require("../css/footer.php");?>
</body>

</html>