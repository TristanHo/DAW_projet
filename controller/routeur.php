<?php
    session_start();

    if(isset($_POST['action'])){
        $actionConnexion = $_POST['action'];
        switch ($actionConnexion){
            case 'connect' :  require_once 'ControllerUser.php';ControllerUser::connect();break;
            case 'creerCompte' :  require_once 'ControllerUser.php';ControllerUser::creerCompte();break;
        } 
    };
    if(isset($_GET['action'])) $action = $_GET['action'];


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