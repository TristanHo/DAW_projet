<?php
    require_once '../model/ModelUser.php';
    class ControllerUser{


        //Fonction du controller pour la connexion d'un utilisateur
        public static function connect(){
            if(isset($_POST['login']) && isset($_POST['mdp'])){
                $login = $_POST['login'];
                $mdp = $_POST['mdp'];
                $user = new ModelUser($login,$mdp);
                $ok = $user->checkConnexion();
                if($ok){
                    self::pageAccueilUser();
                }
                else{
                    self::pageConnexionUser("Login ou mot de passe incorrect");
                }
            }
        }


        public static function pageConnexionUser($message){
            echo "<h3>$message</h3>";
            echo '<h3><a href="../view/connexion/connexion.php">Retour à la page de connexion</a></h3>';
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
                    alert('Compte crée');
                }
                else{
                    self::pageConnexionUser("Compte pas crée");
                }
            }
        }
    }
?>