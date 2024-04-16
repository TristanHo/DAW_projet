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

        //Vérifier si le login et le mot de passe du formulaire de connexion sont bien définis
        if(isset($_POST['login']) && isset($_POST['mdp'])){ 
            setcookie('login','',1); 
            //Récupérer les informations du formulaire
            $login = $_POST['login']; 
            $mdp = $_POST['mdp'];

            //Créer un objet ModelUser pour comparer les informations avec celle de la base de donnée
            $user = new ModelUser($login,$mdp);
            $infos = $user->checkConnexion();

            //En fonction de la vérification de la connexion
            if($infos != null){
                //Si des infos ont été envoyés par la fonction de vérification, on se dirige vers la page d'accueil utilisateur
                self::pageAccueilUser($login,$infos);
            }
            else if($infos == null){
                //Si aucune information n'a été envoyée, on affiche un message d'erreur
                self::pageConnexionUser("Login ou mot de passe incorrect");
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

    //Fonction pour renvoyer sur une page d'erreur en cas de connexion incorrecte
    public static function pageConnexionUser($message){
        echo "<h3>$message</h3>";
        echo '<h3><a href="../index.php">Retour à la page de connexion</a></h3>';
    }

    //Fonction pour renvoyer sur la page d'accueil utilisateur
    public static function pageAccueilUser($login,$infos){
        
        //Définition des cookies de l'utilisateur pour toute la session
        setcookie('login',$login);
        setcookie('role',$infos[0]);
        setcookie('nom',$infos[1]);
        setcookie('prenom',$infos[2]);

        //Vérifier que les cookies ont bien été définis
        if(isset($_COOKIE['login']) && !is_null($_COOKIE['login'])){
            require_once(__DIR__.'/../view/users/accueil.php');
        }
        //En cas d'erreur lors de l'exécution du code
        else{
            require '../view/error.php';
        }
    }

    //Fonction pour créer un compte
    public static function creerCompte(){

        //Vérifier que toutes les informations du formulaire ont bien été remplies
        if(isset($_POST['login']) && isset($_POST['nom']) && isset($_POST['password']) && isset($_POST['prenom'])){

            //Récupérer les informations
            $login = $_POST['login'];
            $mdp = $_POST['password'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $role = $_POST['role'];

            //Créer un ModelUser pour traiter la création de compte et comparer avec les comtpes déjà existants de la base de données
            $user = new ModelUser($login,$mdp);
            //Si la fonction renvoie true, alors le compte peut être créé, sinon le compte n'est pas créé
            $ok = $user->creationCompte($prenom,$nom,$role);

            //Dans les deux cas, on renvoie sur la page de retour à la connexion avec le message correspondant à l'état de création du compte
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