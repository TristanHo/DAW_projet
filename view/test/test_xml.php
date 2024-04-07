<?php
//include model
error_reporting(E_ALL);
require_once("../../model/ModelXml.php");


// teste 
$test=new ModelXml();
$test->recupqcm("exemple.xml","../../BD/exemple.xml") ;
//test de recuperation du fichier ok
//test affichage des questions
echo"<br>test affichage qcm<br>";

$qcm=$test->getQCM() ;

$listequests=$qcm->getListeQuestions() ;
foreach($listequests as $quest) {
//recuperation de la question avec ces reponse possible
$quest->afficher();
echo"passage foreacch<br>";

}
//ajout d'une fonction 
echo "<br>testbis<br>";

$qcm->afficheQuestions() ;


echo "<h2>Test FORMULAIRE</h2>";
echo"<form action=\"traitement.php\" method=\"post\">";
foreach($listequests as $quest) {
    
    $quest->afficherquestionformulaire();
    }
    echo "<button type=\"submit\">Soumettre</button></form>";
    

?>