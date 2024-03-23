<?php

require_once("Model.php");

class ModelUser{
    private $username;
    private $password;

    function __construct($username = null, $password = null)
    {
        if($username != null) {$this->username=$username;}
        if($password != null) {$this->username=$username;}
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
            $user = new ModelUser($row['username'], $row['password']);
            $users[] = $user;
        }

        return $users;
    }

    public function checkConnexion(){
        //$liste_users = self::getUsers();
        $username = $this->username;
        if($username=="ok") return true;
        else return false;
    }
}
?>