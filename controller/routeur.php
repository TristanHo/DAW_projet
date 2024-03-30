<?php
    if(isset($_POST['action'])){
        $actionConnexion = $_POST['action'];
        switch ($actionConnexion){
            case 'connect' :  require_once 'ControllerUser.php';ControllerUser::connect();break;
            case 'creerCompte' :  require_once 'ControllerUser.php';ControllerUser::creerCompte();break;
        } 
    };
    if(isset($_GET['action'])) $action = $_GET['action'];



    if(isset($_GET['id']))
    {
        require_once './ControllerForum/ControllerSub.php';
        ControllerSub::loadSub($_GET['id']);
    }

    if(isset($_GET['thread']))
    {
        
        require_once './ControllerForum/ControllerThread.php';
        ControllerThread::loadThread($_GET['thread']);
    }

?>