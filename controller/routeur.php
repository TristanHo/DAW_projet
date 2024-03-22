<?php
    require_once 'ControllerVoiture.php';
    $action = $_GET['action'];
    switch ($action){
        case 'connexion' : ModelConnexion::connexion();break;
    }
    
?>