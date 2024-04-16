<?php

require_once("Model.php");

class ModelUser{
    private $username;
    private $password;
    private $id;
    private $role;
    private $nom;
    private $prenom;

    function __construct($username = null, $password = null, $id = null, $role = null, $nom = null, $prenom = null)
    {
        if($username != null) {$this->username=$username;}
        if($password != null) {$this->password=$password;}
        if($id != null) {$this->id=$id;}
        if($role != null) {$this->role=$role;}
        if($nom != null) {$this->nom=$nom;}
        if($prenom != null) {$this->prenom=$prenom;}
    }

    public function getUsername() {return $this->username;}
    public function setUsername($username) {$this->username=$username;}
    public function getPassword() {return $this->password;}
    public function setPassword($password) {$this->password = $password;}
    public function getId() {return $this->id;}
    public function setId($id) {$this->id=$id;}
    public function getRole() {return $this->role;}
    public function setRole($role) {$this->role = $role;}
    public function getNom() {return $this->nom;}
    public function setNom($nom) {$this->nom=$nom;}
    public function getPrenom() {return $this->prenom;}
    public function setPrenom($prenom) {$this->prenom = $prenom;}

    public static function getUsers() {
        $model = new Model();
        $pdo = $model->getPdo();
        
        $select = $pdo->query('SELECT * FROM Utilisateur');
        $users = array();

        while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $user = new ModelUser($row['login'], $row['mdp'], $row['id'], $row['role'], $row['nom'], $row['prenom']);
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