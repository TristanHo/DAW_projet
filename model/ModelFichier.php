<?php

require_once("Model.php");

class ModelFichier{
    private $path;
    private $type;
    private $cours;
    private $nv_cours;
    private $login_user;
    private $id_file;

    function __construct($path = null, $type = null, $cours = null, $nv_cours=null, $login_user = null){
        if($path != null){
            $this->path = $path;
        }
        if($type != null){
            $this->type = $type;
        }
        if($cours != null){
            $this->cours = $cours;
        }
        if($nv_cours != null){
            $this->cours = $cours;
        }
        if($login_user != null){
            $this->login_user = $login_user;
        }
    }

    public function getPath(){
        return $this->path;
    }

    public function getType(){
        return $this->type;
    }

    public function getCours(){
        return $this->cours;
    }

    public function getNvCours(){
        return $this->nv_cours;
    }

    public function getLoginUser(){
        return $this->login_user;
    }

    public function getIdFile(){
        return $this->id_file;
    }

    public function setPath($path){
        $this->path = $path;
    }

    public function setType($type){
        $this->type = $type;
    }

    public function setLoginUser($login_user){
        $this->login_user = $login_user;
    }

    public static function getFichiersPP(){
        $model = new Model();
        $pdo = $model->getPdo();
        
        $select = $pdo->query('SELECT * FROM Fichiers WHERE type=\'pp\'');
        $fichiers = array();

        while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $file = new ModelFichier($row['path'], $row['type'], null, null, $row['login_user'], $row['id_file']);
            $fichiers[] = $file;
        }
        return $fichiers;
    }

    public static function getFichiersCours(){
        $model = new Model();
        $pdo = $model->getPdo();
        
        $select = $pdo->query('SELECT * FROM Fichiers WHERE type=cours');
        $fichiers = array();

        while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $file = new ModelFichier($row['path'], $row['type'], $row['cours'], $row['nv_cours'], $row['login_user'], $row['id_file']);
            $fichiers[] = $file;
        }
        return $fichiers;
    }

    public function saveFile(){
        //Cas où c'est une photo de profil
        if($this->type == 'pp' && $this->login_user !=null){
            $dir = "/DAW-projet/BD/fichiers/images"; //répertoire de stockage 
            //Commit des informations de l'image dans la base de données des fichiers 
            $sql='INSERT INTO fichiers(path,type,login_user) values(:path, :type, :login_user)';
            $sqlp = Model::$pdo->prepare($sql);
            $login = $this->login_user;
            $type = "pp";
            $dir = "$dir/$login-$type";
            $val = array('path'=>$dir, 'type'=>$type, 'login_user'=>$login);
            $succes = $sqlp->execute($val);
            return [$succes,"/$login-$type"];
        }

        //Cas où c'est un fichier de cours
        else if($this->type == 'cours'){
            return [false,''];
        }
    }

    public function getPP(){
        $res = null;
        if($this->getLoginUser() != null){
            $fichiers = $this->getFichiersPP();
            foreach($fichiers as $file){
                if($file->getLoginUser() == $this->getLoginUser()){
                    $res = $file->getPath();
                }
            }
        }
        $this->setPath($res);
    }
}