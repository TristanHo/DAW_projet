<?php

require_once("Model.php");

class ModelFichier{
    private $path;
    private $type;
    private $cours;
    private $nv_cours;
    private $login_user;
    private $id_file;

    function __construct($path = null, $type = null, $cours = null, $nv_cours=null, $login_user=null){
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
            $this->nv_cours = $nv_cours;
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


    //Récupérer les photos de profil des utilisateurs
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


    //Récupérer les fichiers d'un cours en fonction du nom du cours et du niveau de cours correspondant au fichier
    public static function getFichiersCours($cours, $nv_cours){
        $model = new Model();
        $pdo = $model->getPdo();
        
        if($cours != null && $nv_cours != null){
            $query = 'SELECT * FROM fichiers WHERE type=\'cours\' AND cours=\''.$cours.'\''.' AND nv_cours<='.$nv_cours; 
        }
        else if($cours != null){
            $query = 'SELECT * FROM fichiers WHERE cours=\''.$cours.'\'';
        }
        else{
            $query = 'SELECT * FROM Fichiers WHERE type=\'cours\''; 
        }
        
        $select = $pdo->query($query);
        $fichiers = array();

        while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $file = new ModelFichier($row['path'], $row['type'], $row['cours'], $row['nv_cours'], $row['login_user'], $row['id_file']);
            $fichiers[] = $file;
        }
        return $fichiers;
    }

    public function saveFile($nom){
        //Cas où c'est une photo de profil
        if($this->type == 'pp' && $this->login_user !=null){
            try{
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
            }catch(PDOException $e){
                echo "\nFailed :".$e->getMessage();
                die();
                return false;
            }
        }

        //Cas où c'est un fichier de cours
        else if($this->type == 'cours'){

            $dir = "/DAW-projet/BD/fichiers/cours"; //répertoire de stockage 
            $login = $this->login_user;
            $type = "cours";
            $cours = $this->getCours();
            $nv_cours = $this->getNvCours();
            //Savoir combien de fichiers de ce cours existent déjà
            $fichiers_existants = $this->getFichiersCours($cours,null);
            $num = 0;
            foreach($fichiers_existants as $file){
                $num++;
            }
            $dir = "$dir/$cours-$nv_cours-$num-$nom";
            try{
                //Commit des informations de l'image dans la base de données des fichiers 
                $sql='INSERT INTO fichiers(path,type,cours,nv_cours,login_user) values(:path, :type, :cours, :nv_cours, :login_user)';
                $sqlp = Model::$pdo->prepare($sql);

                //Sauvegarder les données sur le fichier de cours dans la base de données
                $val = array('path'=>$dir, 'type'=>$type, 'cours'=>$cours, 'nv_cours'=>$nv_cours, 'login_user'=>$login);
                $succes = $sqlp->execute($val);
                return [$succes,"/$cours-$nv_cours-$num-$nom"];
            }catch(PDOException $e){
                echo "\nFailed :".$e->getMessage();
                die();
                return [false,''];
            }
        }
    }

    //Fonction pour supprimer un fichier
    public function deleteFile(){
        if(!is_null($this->getPath())){
            $path = $this->getPath();
            try{
                /*$sql ='DELETE FROM fichiers WHERE path='.$path;
                echo $sql;
                //$sqlp = Model::$pdo->prepare($sql);
                //$succes = $sqlp->exec($sql);
                $succes = Model::$pdo->exec($sql);
                */
                $model = new Model();
                $pdo = $model->getPdo();
                $delete = $pdo->query('DELETE FROM fichiers WHERE fichiers.path=\''.$path.'\'');
                return $delete;
            }catch(PDOException $e){
                echo "\nFailed :".$e->getMessage();
                die();
                return false;
            }
        }
    }

    //Récupérer la photo de profil de l'utilisateur
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