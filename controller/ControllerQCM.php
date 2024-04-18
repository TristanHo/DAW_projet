<?php

error_reporting(E_ALL);

class ControllerForum
{

public static function getPDO()
{
    //recupere les element depuis confic pour conection a la bd

    try
    {        
        $dbh =  new PDO('mysql:host=localhost;dbname=DAW_Project', 'root', '');
        return $dbh;
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }

}

public static function valideQCM($nomcours,$lvcours,$loginetu){
    $dbh = ControllerForum::getPDO();
    // Utilisation de requête préparée pour éviter les injections SQL
    $query = 'INSERT INTO cours_valider (id, nomcours, lv, login) VALUES (null, :nomcours, :lvcours, :loginetu)';
    $requ = $dbh->prepare($query);
    $requ->bindParam(':nomcours', $nomcours);
    $requ->bindParam(':lvcours', $lvcours);
    $requ->bindParam(':loginetu', $loginetu);
    // evoie de la requete
    $requ->execute();

}


}
?>