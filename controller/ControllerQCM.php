<<<<<<< Updated upstream
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
=======
<?php

error_reporting(E_ALL);

class ControllerQCM
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
    $dbh = ControllerQCM::getPDO();
    // Utilisation de requête préparée pour éviter les injections SQL
    $query = 'INSERT INTO cours_valider (id, nomcours, lv, login) VALUES (null, :nomcours, :lvcours, :loginetu)';
    $requ = $dbh->prepare($query);
    $requ->bindParam(':nomcours', $nomcours);
    $requ->bindParam(':lvcours', $lvcours);
    $requ->bindParam(':loginetu', $loginetu);
    // evoie de la requete a la BD
    $requ->execute();

}
//
//fonction de modification dans le fichier xml ou sauvgarde si il n'existe pas encore
public static function modif_sauv_qcm() {
    $xmlFile = "../../BD/exemple.xml";
    $xml = simplexml_load_file($xmlFile); 
    $idqcm=$_POST['idqcm'];   
    // Rechercher le QCM à modifier en fonction de son ID
    foreach ($xml->qcm as $qcm) {
        if ($qcm->idqcm == $idqcm) {
            // Mettre à jour les questions et réponses du QCM en fonction des données soumises dans le formulaire
            foreach ($qcm->questions->question as $question) {
                // Récupérer l'index de la question dans le formulaire
                $index = (int)$_POST['index'];

                // Mettre à jour la question et les réponses
                $question->questionposer = $_POST['question'][$index];
                $question->reponse = $_POST['reponse'][$index];
            }
            // Enregistrer les modifications dans le fichier XML
            $xml->asXML($xmlFile);
            return true; // Modification réussie
        }
    }

    // Si le QCM n'a pas été trouvé
    return false;
}

}
>>>>>>> Stashed changes
?>