<?php
require_once(__DIR__.'/../model/ModelUser.php');

class ControllerUser {
    static function listeUsers() {
        $liste = ModelUser::getUsers();
        require_once(__DIR__.'/../view/users/listeUsers.php');
    }

    public static function getUser($id) {
        $model = new Model();
        $pdo = $model->getPdo();

        $select = $pdo->query('SELECT * FROM Utilisateurs WHERE id='.$id);
        while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $user = new ModelUser($row['login'], $row['mdp'], $row['id'], $row['role'], $row['nom'], $row['prenom']);
            return $user;
        }
    }

    public static function insertUser($login, $mdp, $prenom, $nom, $role) {    
        $model = new Model();
        $pdo = $model->getPdo();
        $recupID = $pdo->query("SELECT MAX(id) FROM Utilisateurs");
        $id = $recupID->fetchColumn() + 1;
        $insert = $pdo->query("INSERT INTO Utilisateur VALUES('".$id."', '".$login."', '".$mdp."', '".$prenom."', '".$nom."', '".$role."')");
        require_once(__DIR__.'/../view/users/listeUsers.php');
    }

    public static function deleteUser($id) {
        $model = new Model();
        $pdo = $model->getPdo();

        $delete = $pdo->query('DELETE FROM Utilisateurs WHERE id='.$id);
        require_once(__DIR__.'/../view/users/listeUsers.php');
    }

    public static function modifUser($id, $prenom, $nom, $role) {
        $model = new Model();
        $pdo = $model->getPdo();

        $update = $pdo->query('UPDATE Utilisateurs SET prenom="'.$prenom.'", nom="'.$nom.'", role="'.$role.'" WHERE id='.$id);
        require_once(__DIR__.'/../view/users/listeUsers.php');
    }
//Fonction du controller pour la connexion d'un utilisateur
public static function connect(){
    if(isset($_POST['login']) && isset($_POST['mdp'])){
        setcookie('login','',1);
        $login = $_POST['login'];
        $mdp = $_POST['mdp'];
        $user = new ModelUser($login,$mdp);
        $infos = $user->checkConnexion();
        if($infos != null){
            self::pageAccueilUser($login,$infos);
        }
        else if($infos == null){
            self::pageConnexionUser("Login ou mot de passe incorrect");
        }
        else{
            Reader("Location : ../view/error.php");
        }
    }
    else{
        Reader("Location : ../view/error.php");
    }
}


public static function pageConnexionUser($message){
    echo "<h3>$message</h3>";
    echo '<h3><a href="../index.php">Retour à la page de connexion</a></h3>';
}

public static function pageAccueilUser($login,$infos){
    setcookie('login',$login);
    setcookie('role',$infos[0]);
    setcookie('nom',$infos[1]);
    setcookie('prenom',$infos[2]);
    if(isset($_COOKIE['login']) && !is_null($_COOKIE['login'])){
        require_once(__DIR__.'/../view/users/accueil.php');
    }
    else{
        require '../view/error.php';
    }
}

public static function creerCompte(){
    if(isset($_POST['login']) && isset($_POST['nom']) && isset($_POST['password']) && isset($_POST['prenom'])){
        $login = $_POST['login'];
        $mdp = $_POST['password'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $role = $_POST['role'];
        $user = new ModelUser($login,$mdp);
        $ok = $user->creationCompte($prenom,$nom,$role);
        if($ok){
            self::pageConnexionUser("Compte crée avec succès !");
        }
        else{
            self::pageConnexionUser("Compte pas crée");
        }
    }
}
}
?>