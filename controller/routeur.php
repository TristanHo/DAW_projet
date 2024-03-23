<?php
    if(isset($_POST['action'])){
        $actionConnexion = $_POST['action'];
        switch ($actionConnexion){
            case 'connect' :  require_once 'ControllerUser.php';ControllerUser::connect();break;
            case 'creerCompte' :  require_once 'ControllerUser.php';ControllerUser::creerCompte();break;
        } 
    };
    if(isset($_GET['action'])) $action = $_GET['action'];
?>