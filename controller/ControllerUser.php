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
                    self::pageConnexionUser();
                }
            }
        }


        public static function pageConnexionUser(){
            echo '<h3>Login ou mot de passe incorrect</h3>';
            echo '<h3><a href="../view/connexion/connexion.php">Retour à la page de connexion</a></h3>';
        }
    }
?>