<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de QCM</title>
</head>

<body>
    
        <?php
        //inclusion du controllerQCM pour pouvoir faire les ajout dans la BD avec la fonction calculerscore


        // pour afficher et repondre au QCM
        // Charger les questions du QCM depuis le modèle
        require_once("../../controller/ControllerQCM.php");
        $test = new ControllerQCM;
        $test->affiche_modif();
        //test pour lire un qcm de cours cree
        //$test->recupqcm("qcmcours1","../BD/exemple.xml") ;
        //test pour lire le qcmintro
        //$test->recupqcmintro("../../BD/exemple.xml");
        //$qcm = $test->getQCM();

    
        ?>
        
    
</body>

</html>