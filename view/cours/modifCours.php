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
        $_SESSION['cours'] = $cours->getNom();
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

    <?php
        //Si l'utilisateur est l'administrateur ou le prof responsable du cours, il peut ajouter un fichier
        if($_COOKIE['role'] == 'administrateur' || $_COOKIE['login'] == $cours->getResponsable()) {
            
            $cours = $_SESSION['cours'];
            echo "<form action='../../config/routeur.php' method='post' enctype='multipart/form-data'>";
            echo "<fieldset>
                    <legend>Ajouter un fichier au cours</legend>";
            echo "<input type='file' id='fichier' name='fichier_cours' required='required' /><br/><br/>";
            echo "<label for='nv_fichier'>Choisissez le niveau du cours correspondant à ce fichier</label>
            <select id='nv_fichier' name='nv_fichier' required='required' >
                    <option value=1 >1</option>
                    <option value=2 >2</option>
                    <option value=3 >3</option>
            </select><br/><br/>";
            echo "<input type='submit' id='ajouter' value='Ajouter un fichier au cours'/><br/>";
            echo "<input type='hidden' name='cours' value='$cours' />";
            echo "<input type='hidden' name='id_cours' value=".$_GET['id']." />";
            echo "<input type='hidden' name='action' value='ajouterFichierCours'/>";
            echo "</fieldset>";
            echo "</form>";
        }
    ?>

<?php require("../css/footer.php");?>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

</html>