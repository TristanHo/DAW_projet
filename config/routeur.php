<?php

session_start();

spl_autoload_register(function ($controller) {
    require_once('../controller/'.$controller.'.php');
});


/*
PARTIE CONNEXION, CREATION DE COMPTE, GESTION D'UTILISATEUR
*/
if(isset($_POST['action']) && !is_null($_POST['action'])){
    $action = $_POST['action'];

    switch($action) {
        case 'createUser' :
            {
                if(isset($_POST['login']) && isset($_POST['mdp']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['role']))
                {
                    ControllerUser::insertUser($_POST['login'],$_POST['mdp'],$_POST['prenom'],$_POST['nom'],$_POST['role']);
                }
                break;
            }

        case 'deleteUser' :
            {
                ControllerUser::deleteUser($_POST['id']);
                break;
            }

        case 'modifUser' :
            {
                if(isset($_POST['id']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['role']))
                {
                    ControllerUser::modifUser($_POST['id'],$_POST['prenom'],$_POST['nom'],$_POST['role']);
                }
                break;
            }

        case 'connect' :
            {
                ControllerUser::connect();
                ControllerFichier::afficherPP();
                break;
            }
        
        case 'creerCompte' :
            {
                ControllerUser::creerCompte();
                ControllerFichier::savePP();
                break;
            }

        case 'createCours' :
            {
                if(isset($_POST['nom'])) {
                    ControllerCours::insertCours($_COOKIE['login'], $_POST['nom']);
                    break;
                }
            }

        case 'modifCours' :
            {
                if(isset($_POST['nom']) && isset($_POST['id'])) {
                    ControllerCours::modifCours($_COOKIE['login'], $_POST['nom'], $_POST['id']);
                }
                break;
            }

        case 'deleteCours' :
            {
                ControllerCours::deleteCours($_POST['id']);
                break;
            }

        case 'ajouterFichierCours' :
            {
                ControllerFichier::saveFichierCours();
                break;
            }
        case 'supprimerFichier' :
            {
                ControllerFichier::deleteFichierCours();
                break;
            }
    }

$_POST['action'] = null;
}

else if(isset($_GET['action']) && !is_null($_GET['action'])){
    $action = $_GET['action'];

    switch($action) {
        case 'disconnect' :
            {
                ControllerUser::deconnexion();
                break;
            }
       
    }


$_GET['action'] = null;
}

$_POST['id'] = null;

if(isset($_POST['validerChangement']))
{
   
    //echo $_GET['idqcm'];
    //echo'je fait la modif';
    require_once '../controller/ControllerQCM.php';
    ControllerQCM::modif_sauv_qcm();



}
//validation du QCM
if(isset($_POST['validerQCMintro']))
{
    //echo 'traitement score intro';
    //passer id du qcm avec hidden ou _GET
    $idqcm="qcmintro";
    require_once '../controller/ControllerQCM.php'; 
    $tmp=new ControllerQCM;
   // $tmp->recupqcm($idqcm);
    
    $tmp->calcul_score_intro();


}
if(isset($_POST['validerQCM']))
{
    
    //passer id du qcm avec hidden ou _GET
    $idqcm=$_POST['idqcm'];
    require_once '../controller/ControllerQCM.php'; 
    $tmp=new ControllerQCM;
    
   // $tmp->recupqcm($idqcm);
    
    $tmp->calculerScore($idqcm,$_POST['cours'],$_POST['nv']);
    

}

/*
PARTIE FORUM
PARTIE FORUM
PARTIE FORUM
*/
if(isset($_POST['messageInput']))
{
    require_once '../controller/ControllerForum.php'; ControllerForum::addMessage($_GET['topic_id'], $_GET['topic_title']);
}

if(isset($_POST['btnDeleteMessage']) && isset($_GET['id_message']))
{
    require_once '../controller/ControllerForum.php'; ControllerForum::removeMessage($_GET['id_message']);
}


if(isset($_POST['btnDeleteTopic']))
{
    require_once '../controller/ControllerForum.php'; ControllerForum::removeTopic($_GET['id_cours']);
}

if(isset($_POST['topicInput']))
{
    require_once '../controller/ControllerForum.php'; ControllerForum::addTopic();
}

/*
PARTIE QCM
*/

/* if(isset($_POST['idqcm']))
{
    require_once '../controller/ControllerQCM.php'; ControllerQCM::modif_sauv_qcm();
} */


?>
