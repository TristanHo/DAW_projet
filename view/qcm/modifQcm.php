<?php

//zone de modification du qcm
require_once("../../model/ModelXml.php");
$test=new ModelXml();
//test pour lire un qcm de cours cree
//$test->recupqcm("qcmcours1","../BD/exemple.xml") ;
//test pour lire le qcmintro
$test->recupqcmintro("../../BD/exemple.xml");
$qcm=$test->getQCM() ;

$score = 0;
$questions=$qcm->getListeQuestions() ;
$qcm->affiche_modif();

//affiche de celui-ci si il existe et bonton de validation qui effectue le changement dans le fichier xml


?>