<?php

require_once ('../config/config.php');
class Model
{
    static public $pdo;
    function __construct()
    {

        try {
            $config = new config();
            $this->pdo = new PDO("mysql:host={$config->getHost()};dbname={$config->getDbname()}",  $config->getLogin(), $config->getMdp());
            echo "ok";
        } catch (PDOException $e) {
            echo "Erreur!:" . $e->getMessage();
            die();
        }
    }
    public function getPdo()
    {
        return $this->pdo;
    }
    static public function connexion(){
        $host=config::getHost();
        $name=config::getDbname();
        $login=config::getLogin();
        $password=config::getMdp();
        try{
            self::$pdo=new  PDO("mysql:host=$host;dbname=$name",  $login, $password);
        }
        
            catch (PDOException $e) {
                echo "Erreur!:" . $e->getMessage();
                die();
        }
    }
}
?>