<?php
// Charger les questions du QCM depuis le modèle
require_once("../model/ModelXml.php");
$test=new ModelXml();
$test->recupqcm("qcmintro","../BD/exemple.xml") ;
$qcm=$test->getQCM() ;
$score = 0;
$questions=$qcm->getListeQuestions() ;
foreach($questions as $q){
    $question = $q->getQuestion();
}

echo "Chemin du script actuel : " . $_SERVER['PHP_SELF'];
//Passer les questions à la vue qui affiche le formulaire
//include('/views/test/test_xml.php');
include('../view/test/formulaire_qcm.php');
// Vérifier les réponses soumises
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponse'])) {
    // Traiter les réponses soumises
    $score += $qcm->calculerScore($_POST['reponse']);
    
    // Passer le score à la vue qui affiche les résultats
    include('../view/test/resultat_qcm.php');
} 
?>