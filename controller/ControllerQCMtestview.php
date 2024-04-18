<?php
// Charger les questions du QCM depuis le modèle
require_once("../model/ModelXml.php");
$test=new ModelXml();
//test pour lire un qcm de cours cree
//$test->recupqcm("qcmcours1","../BD/exemple.xml") ;
//test pour lire le qcmintro
$test->recupqcmintro("../BD/exemple.xml");
$qcm=$test->getQCM() ;

$score = 0;
$questions=$qcm->getListeQuestions() ;
foreach($questions as $q){
    $question = $q->getQuestion();
}

echo "Chemin du script actuel : " . $_SERVER['PHP_SELF'];
//Passer les questions à la vue qui affiche le formulaire

include('../view/test/formulaire_qcm.php');
// Vérifier les réponses soumises
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponse'])) {
    $qcm->calcul_score_intro($_POST['reponse']);
    $score += $qcm->calculerScore($_POST['reponse']);
    
    // vue qui affiche les résultats
    include('../view/test/resultat_qcm.php');
} 
?>