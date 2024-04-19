<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Page d'accueil</title>
  <?php require("../css/stylesheet.php");?>
</head>
<body>
    <?php require("../css/header.php");?>
    <?php
        if(isset($_COOKIE['pp'])){
            $path = $_COOKIE['pp'];
            echo "<img src='$path' />";
        }
    ?>
    <h1>Bienvenue 
        <?php
            echo $_COOKIE['nom']." ".$_COOKIE['prenom'];
        ?>
    </h1>
    <p>
    <?php 
        switch ($_COOKIE['role']){
            case 'etudiant' : echo 'Je suis étudiant <br/>'; 
                require_once('../../controller/ControllerCours.php');
                require_once('../../controller/ControllerQCM.php');
                $cours = ControllerCours::listeCours();
                $cours_etu = [];
                $lvl_etu = -1;
                foreach($cours as $c){
                    $lvl_etu = ControllerQCM::recuplvetu($c->getNom(),$_COOKIE['login']);
                    $id_cours = $c->getId();
                    $nom_cours = $c->getNom();
                    if($lvl_etu != null){
                        if(($lvl_etu) < 3){
                            $nv_cours = $lvl_etu+1;
                            echo "<a href=/DAW-projet/view/cours/pageCours.php?id=$id_cours&lvl=$nv_cours>Cours de $nom_cours (niveau $nv_cours)</a><br/><br/>";
                        }
                        else{
                            echo "<a href=/DAW-projet/view/cours/pageCours.php?id=$id_cours&lvl=3>Cours de $nom_cours (niveau 3)</a><br/><br/>";
                        }
                    }
                    else{
                        echo "<a href=/DAW-projet/view/cours/pageCours.php?id=$id_cours&lvl=1>Cours de $nom_cours (niveau 1)</a><br/><br/>";
                    }
                }
                break;
            case "professeur" : echo 'Je suis professeur <br/>'; break;
            case "administrateur" : echo 'Je suis administrateur <br/> <a href="listeUsers.php">Gérer la liste d\'utilisateurs</a><br/> <a href="../cours/listeCours.php">Gérer la liste des cours</a><br/>'; break;
        }
        //if(isset($_GET['tab_cours']))
        if(isset($_GET['tab_cours']) /*&& $_GET['tab_cours'][0] != null*/)
        {
            echo '<br/><span> Vous avez validé les cours suivants : <br/>';
            foreach($_GET['tab_cours'] as $cours){
                echo $cours."<br/>";
            }
            echo '</span>';
        }
        echo '<br/><a href="profilUser?id='.$_COOKIE['id'].'">Voir mon profil</a>';
    ?>
    </p>
    <?php require("../css/footer.php");?>
</body>
</html>