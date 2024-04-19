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
       

        require_once("../../controller/ControllerQCM.php");
        $tmp = new ControllerQCM;
        $tmp->affiche_formulaire_qcm("qcmintro","d'introduction",0);

        //mettre en hiden le login user pour pouvoir faire les ajout a la BD via le cookie
        ?>
        <input type='submit' value='Valider le QCM' name='validerQCMintro'>
    </form>
    
</body>

</html>