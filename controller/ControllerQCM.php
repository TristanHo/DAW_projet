<?php
// Charger les questions du QCM depuis le modèle
require_once("../model/ModelXml.php");
$test=new ModelXml();
$test->recupqcm("exemple.xml","../BD/exemple.xml") ;
$qcm=$test->getQCM() ;
$score = 0;
$questions=$qcm->getListeQuestions() ;
//$questions = $modelQCM->getQuestions();

// Passer les questions à la vue qui affiche le formulaire
include('../views/test/formulaire_qcm.php');

// Vérifier les réponses soumises
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponse'])) {
    // Traiter les réponses soumises
    $score += $qcm->calculerScore($_POST['reponse']);
    
    // Passer le score à la vue qui affiche les résultats
    include('../views/test/resultat_qcm.php');
}
?>