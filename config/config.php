<?php
class config{
    static private $data=array(
        'dbhost'=>'localhost',
        'dbname'=>'DAW_Project',
        'login'=>'root',
        'password'=>''
    );
    


    // Constructeur
    

    // Getter pour dbname
    static public function getDbname() {
        return self::$data['dbname'];
    }


    // Getter pour host
    static public function getHost() {
        return self::$data['dbhost'];
    }

  
    // Getter pour login
    static public function getLogin() {
        return self::$data['login'];    }

   

    // Getter pour mdp
    static public function getMdp() {
        return self::$data['password'];    }

}
?>