<?php

session_start();

spl_autoload_register(function ($controller) {
    require_once('../controller/'.$controller.'.php');
});

if(isset($_POST['action']) && !is_null($_POST['action'])) {
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
                break;
            }
        
        case 'creerCompte' :
            {
                ControllerUser::creerCompte();
                break;
            }
    }

$_POST['action'] = null;
}

/*
    PARTIE FORUM
    */
    if(isset($_GET['messageInput']))
    {
        /* 
        A REMPLACER PAR COOKIE
        A REMPLACER PAR COOKIE
        A REMPLACER PAR COOKIE
        */
        $_SESSION['login'] = "famous_singer";
        /* 
        A REMPLACER PAR COOKIE
        A REMPLACER PAR COOKIE
        A REMPLACER PAR COOKIE
        */


        require_once 'ControllerForum.php'; ControllerForum::addMessage();
    }

    if(isset($_POST['btnDeleteMessage']) && isset($_GET['id_message']))
    {
        require_once 'ControllerForum.php'; ControllerForum::removeMessage($_GET['id_message']);
    }
?>