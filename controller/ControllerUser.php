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

        $select = $pdo->query('SELECT * FROM Utilisateur WHERE id='.$id);
        while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $user = new ModelUser($row['login'], $row['mdp'], $row['id'], $row['role'], $row['nom'], $row['prenom']);
            return $user;
        }
    }

    public static function insertUser($login, $mdp, $prenom, $nom, $role) {    
        $model = new Model();
        $pdo = $model->getPdo();
        $recupID = $pdo->query("SELECT MAX(id) FROM Utilisateur");
        $id = $recupID->fetchColumn() + 1;
        $insert = $pdo->query("INSERT INTO Utilisateur VALUES('".$id."', '".$login."', '".$mdp."', '".$prenom."', '".$nom."', '".$role."')");
        require_once(__DIR__.'/../view/users/listeUsers.php');
    }

    public static function deleteUser($id) {
        $model = new Model();
        $pdo = $model->getPdo();

        $delete = $pdo->query('DELETE FROM Utilisateur WHERE id='.$id);
        require_once(__DIR__.'/../view/users/listeUsers.php');
    }

    public static function modifUser($id, $prenom, $nom, $role) {
        $model = new Model();
        $pdo = $model->getPdo();

        $update = $pdo->query('UPDATE Utilisateur SET prenom="'.$prenom.'", nom="'.$nom.'", role="'.$role.'" WHERE id='.$id);
        require_once(__DIR__.'/../view/users/listeUsers.php');
    }
}

=======
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