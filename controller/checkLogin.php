<?php
    require_once("ControllerUser.php");
    if(isset($_REQUEST['login'])){
        $login = $_REQUEST['login'];
        $liste = ControllerUser::listeUsers();
        $ok = true;
        foreach($liste as $user){
            if($user->getUsername() == $login && $ok){
                $ok = false;
            }
        }
        if($ok){
            echo "Login disponible";
        }
        else{
            echo "Login déjà utilisé";  
        }
    }  
    else{
        echo "Login invalide";
    }
?>