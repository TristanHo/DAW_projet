<?php
require_once(__DIR__.'/../model/ModelUser.php');

class ControllerUser {
    //Fonction du controller pour récupérer la liste de tous les utilisateurs dans la base de données
    static function listeUsers() {
        $liste = ModelUser::getUsers();
        return $liste;
    }

    //Fonction du controller pour récupérer un utilisateur avec son id
    public static function getUser($id) {
        $model = new Model();
        $pdo = $model->getPdo();

        $select = $pdo->query('SELECT * FROM Utilisateurs WHERE id='.$id);
        while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $user = new ModelUser($row['login'], $row['mdp'], $row['id'], $row['role'], $row['nom'], $row['prenom']);
            return $user;
        }
    }

    public static function getUserLogin($login) {
        $model = new Model();
        $pdo = $model->getPdo();

        $select = $pdo->query('SELECT * FROM Utilisateurs WHERE utilisateurs.login="'.$login.'"');
        while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $user = new ModelUser($row['login'], $row['mdp'], $row['id'], $row['role'], $row['nom'], $row['prenom']);
            return $user;
        }
    }

    //Fonction du controller pour ajouter un utilisateur à la table des utilisateurs
    public static function insertUser($login, $mdp, $prenom, $nom, $role) {    
        $model = new Model();
        $pdo = $model->getPdo();
        $recupID = $pdo->query("SELECT MAX(id) FROM Utilisateurs");
        $id = $recupID->fetchColumn() + 1;
        $insert = $pdo->query("INSERT INTO Utilisateurs VALUES('".$id."', '".$login."', '".$mdp."', '".$prenom."', '".$nom."', '".$role."')");
        //Redirection vers la liste des utilisateurs
        header("Location: http://localhost/DAW-projet/view/users/listeUsers.php");
        exit();
    }

    //Fonction du controller pour supprimer un utilisateur de la base de données
    public static function deleteUser($id) {
        $model = new Model();
        $pdo = $model->getPdo();

        $delete = $pdo->query('DELETE FROM Utilisateurs WHERE id='.$id);
        //Redirection vers la liste des utilisateurs
        header("Location: http://localhost/DAW-projet/view/users/listeUsers.php");
        exit();
    }

    //Fonction du controller pour modifier un utilisateur dans la table
    public static function modifUser($id, $prenom, $nom, $role) {
        $model = new Model();
        $pdo = $model->getPdo();

        $update = $pdo->query('UPDATE Utilisateurs SET prenom="'.$prenom.'", nom="'.$nom.'", role="'.$role.'" WHERE id='.$id);
        //Redirection vers la liste des utilisateurs
        header("Location: http://localhost/DAW-projet/view/users/listeUsers.php");
        exit();
    }

    //Fonction du controller pour la connexion d'un utilisateur
    public static function connect(){

        //Vérifier si le login et le mot de passe du formulaire de connexion sont bien définis
        if(isset($_POST['login']) && isset($_POST['mdp'])){ 
            //Récupérer les informations du formulaire
            $login = $_POST['login']; 
            $mdp = $_POST['mdp'];

            //Créer un objet ModelUser pour comparer les informations avec celle de la base de donnée
            $user = new ModelUser($login,$mdp);
            $infos = $user->checkConnexion();

            //En fonction de la vérification de la connexion
            if($infos != null){
                //Définition des cookies de l'utilisateur pour toute la session
                setcookie('login',$login, 0, '/');
                setcookie('role',$infos[0], 0, '/');
                setcookie('nom',$infos[1], time() + 3600*24*7, '/');
                setcookie('prenom',$infos[2], 0, '/');
                setcookie('id', $infos[3], 0, '/');

                //Redirection vers la page d'accueil
                header('Location:/DAW-projet/view/users/accueil.php');
                exit();
            }   
            else if($infos == null){
                //Si aucune information n'a été envoyée, on affiche un message d'erreur
                header('Location:/DAW-projet/index.php?infos=false');
            }
            else{
                //Si il y a une erreur durant l'exécution du code PHP
                Reader("Location : ../view/error.php");
            }
        }
        //Si il y a une erreur durant l'exécution du code PHP
        else{
            Reader("Location : ../view/error.php");
        }
    }

    //Fonction pour renvoyer sur la page d'accueil utilisateur
    public static function pageAccueilUser($login,$infos){
        
        //Définition des cookies de l'utilisateur pour toute la session
        setcookie('login',$login, 0, '/');
        setcookie('role',$infos[0], 0, '/');
        setcookie('nom',$infos[1], 0, '/');
        setcookie('prenom',$infos[2], 0, '/');
        setcookie('id', $infos[3], 0, '/');
        //Vérifier que les cookies ont bien été définis
        if(isset($_COOKIE['login']) && !is_null($_COOKIE['login'])){
            //Redirection vers la page d'accueil de l'utilisateur
            header('Location:/DAW-projet/view/users/accueil.php');
            exit();
        }
        //En cas d'erreur lors de l'exécution du code
        else{
            require '../view/error.php';
            exit();
        }
    }

    //Fonction pour créer un compte
    public static function creerCompte(){

        //Vérifier que toutes les informations du formulaire ont bien été remplies
        if(isset($_POST['login']) && isset($_POST['nom']) && isset($_POST['password']) && isset($_POST['prenom'])){

            //Récupérer les informations
            $login = $_POST['login'];
            $mdp = $_POST['password'];
            $nom = strtoupper($_POST['nom']); //Permet de forcer le nom en majuscule pour faciliter les traitements d'affichages par la suite
            $prenom = $_POST['prenom'];
            $role = $_POST['role'];

            //Créer un ModelUser pour traiter la création de compte et comparer avec les comtpes déjà existants de la base de données
            $user = new ModelUser($login,$mdp);
            //Si la fonction renvoie true, alors le compte peut être créé, sinon le compte n'est pas créé
            if($_FILES['photo']['error'] == UPLOAD_ERR_OK){
                $file = $_FILES['photo']['name'];
                $ok = $user->creationCompte($prenom,$nom,$role,$file);
                if($ok[0]){
                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $file = "$ok[1].$extension";
                    $dir_dest = "../BD/fichiers/images$file";
                    $dir_temp = $_FILES['photo']['tmp_name'];
                    move_uploaded_file($dir_temp,$dir_dest);
                }
            }
            else{
                $ok = $user->creationCompte($prenom,$nom,$role,null);
            }

            //Dans les deux cas, on renvoie sur la page de connexion avec le message correspondant à l'état de création du compte
            if($ok[0]){
                header('Location:/DAW-projet/index.php?infos=crea');
                exit();
            }
            else{
                header('Location:/DAW-projet/index.php?infos=ncrea');
                exit();
            }
        }
    }

    public static function deconnexion(){
        
        //Suppression des cookies
        setcookie('login','1', time()-3600, '/');
        setcookie('nom','1', time()-3600, '/');
        setcookie('prenom','1', time()-3600, '/');
        setcookie('id','1', time()-3600, '/');
        setcookie('role','1', time()-3600, '/');
        setcookie('theme','jour',0,'/');
        //Redirection vers la page de connexion du site
        header('Location:/DAW-projet');
        exit();
    }

    }
?>
