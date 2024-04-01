<?php

require_once("Model.php");

class ModelUser{
    private $username;
    private $password;

    function __construct($username = null, $password = null)
    {
        if($username != null) {$this->username=$username;}
        if($password != null) {$this->password=$password;}
    }

    public function getUsername() {return $this->username;}
    public function setUsername($username) {$this->username=$username;}
    public function getPassword() {return $this->password;}
    public function setPassword($password) {$this->password = $password;}

    public static function getUsers() {
        $model = new Model();
        $pdo = $model->getPdo();
        
        $select = $pdo->query('SELECT * FROM Utilisateurs');
        $users = array();

        while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $user = new ModelUser($row['login'], $row['mdp']);
            $users[] = $user;
        }

        return $users;
    }

    public function checkConnexion(){
        $liste_users = self::getUsers();
        foreach($liste_users as $user){
            if ($user->getUsername() == $this->getUsername()){
                if($user->getPassword() == $this->getPassword()){
                    return true;
                }
            }
        }
        return false;
    }

    public function creationCompte($prenom,$nom,$role){
        $liste_users = self::getUsers();
        foreach($liste_users as $user){
            if ($user->getUsername() == $this->getUsername()){
                return false;
            }
        }
        try{
            $sql='INSERT INTO utilisateurs(login,mdp,prenom,nom,role) values(:login, :mdp, :prenom, :nom, :role)';
            $sqlp = Model::$pdo->prepare($sql);
            $login = $this->username;
            $mdp = $this->password;
            $val = array('login'=>$login, 'mdp'=>$mdp, 'prenom'=>$prenom, 'nom'=>$nom, 'role'=>$role);
            return $sqlp->execute($val);
        }catch(PDOException $e){
            echo "\nFailed :".$e->getMessage();
            echo $login." ".$mdp."cc";
            die();
            return false;
        }
    }
}
?>