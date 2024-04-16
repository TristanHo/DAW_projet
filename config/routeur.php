<?php

spl_autoload_register(function ($controller) {
    require_once('../controller/'.$controller.'.php');
});
$action = $_GET['action'];

switch($action) {
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