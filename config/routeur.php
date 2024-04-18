<?php

spl_autoload_register(function ($controller) {
    require_once('../controller/'.$controller.'.php');
});
//$action = $_GET['action'];

/*switch($action) {
    case 'createUser' :
        {
            if(isset($_GET['login']) && isset($_GET['mdp']) && isset($_GET['prenom']) && isset($_GET['nom']) && isset($_GET['role']))
            {
                ControllerUser::insertUser($_GET['login'],$_GET['mdp'],$_GET['prenom'],$_GET['nom'],$_GET['role']);
            }
            break;
        }

    case 'deleteUser' :
        {
            ControllerUser::deleteUser($_GET['id']);
        }

    case 'modifUser' :
        {
            if(isset($_GET['id']) && isset($_GET['prenom']) && isset($_GET['nom']) && isset($_GET['role']))
            {
                ControllerUser::modifUser($_GET['id'],$_GET['prenom'],$_GET['nom'],$_GET['role']);
            }
        }
}

$_GET['action'] = null; //remettre à  l'action pour éviter des conflits ?
*/
if(isset($_POST['action']) && !is_null($_POST['action'])){
    $actionConnexion = $_POST['action'];
    switch ($actionConnexion){
        case 'connect' :  /*require_once 'ControllerUser.php';*/ControllerUser::connect();break;
        case 'creerCompte' :  /*require_once 'ControllerUser.php';*/ControllerUser::creerCompte();break;
    } 
};

$_POST['id'] = null;

if(isset($_POST['validerChangement']))
{
    echo $_GET['idqcm'];
    require_once '../controller/ControllerQCM.php'; ControllerQCM::modif_sauv_qcm();

}
//validation du QCM
if(isset($_POST['validerQCMintro']))
{
    echo 'traitement score intro';
    //passer id du qcm avec hidden ou _GET
    $idqcm="qcmintro";
    require_once '../controller/ControllerQCM.php'; 
    $tmp=new ControllerQCM;
   // $tmp->recupqcm($idqcm);
    
    $tmp->calcul_score_intro();


}
if(isset($_POST['validerQCM']))
{
    //echo 'traitement score';
    //passer id du qcm avec hidden ou _GET
    $idqcm="qcmcours2";
    require_once '../controller/ControllerQCM.php'; 
    $tmp=new ControllerQCM;
   // $tmp->recupqcm($idqcm);
    
    $tmp->calculerScore($idqcm);


}

?>