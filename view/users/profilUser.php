<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("../css/theme.php");?>
    <title>Profil</title>
</head>
<body>

<form action='../../config/routeur.php' method="post">
    <?php
        require_once('../../controller/ControllerUser.php');
        require_once('../../controller/ControllerCours.php');
        $user = ControllerUser::getUser($_GET['id']);

        echo "<h1>Profil</h1>";
        echo "Nom : ".$user->getNom()."<br>";
        echo "Prenom : ".$user->getPrenom()."<br>";
        echo "Role : ".$user->getRole()."<br>";

        //Si c'est le profil d'un professeur, affiche la liste des cours qu'il a créé
        if($user->getRole() == 'professeur') {
            echo "<h1>Cours de ".$user->getNom()." ".$user->getPrenom()."</h1>";
            $listecours = ControllerCours::getCoursResponsable($user->getUsername());

            //Si la personne qui accède au profil est le bon professeur, affiche un bouton pour créer un cours
            if($_COOKIE['role'] == 'professeur' && $_COOKIE['login'] == $user->getUsername()) {
                echo "<a href='../cours/createCours.php'>Créer un cours</a><br>";
            }
            echo "<table border=1>";
            echo "<tr><td>Nom du cours</td><td></td></tr>";
            foreach($listecours as $cours) {
                echo "<tr>";
                echo "<td>".$cours->getNom()."</td>";
                echo "<td><a href='../cours/pageCours.php?id=".$cours->getId()."'>Voir page du cours</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        //Si le profil est celui d'un étudiant, affiche la liste des cours qu'il suit et son niveau
        if($user->getRole() == 'etudiant') {
            echo "<h1>Cours suivis par ".$user->getNom()." ".$user->getPrenom()."</h1>";
            //Ajouter niveaux des cours suivis par l'utilisateur
        }

        //Affiche les options de modification et de suppression si l'utilisateur est l'administrateur
        //Il n'est pas possible de modifier ou de supprimer l'administrateur
        if($_COOKIE['role'] == 'administrateur' && $user->getRole() != 'administrateur') {
            echo "<a href='modifUser.php?id=".$user->getId()."'>Modifier utilisateur</a>";
            echo "<input type='submit' value='Supprimer utilisateur'/>";
        }

        //Retour vers l'accueil
        echo "<br><a href='accueil.php'>Revenir à l'accueil</a>";

        echo "<input type='hidden' name='action' value='deleteUser'/>";
        echo "<input type='hidden' name='id' value='".$user->getId()."'/>";
    ?>
</form>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script  type="text/javascript" src="../js/theme.js"></script>

</html>