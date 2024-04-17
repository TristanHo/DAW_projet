<?php
    require_once("ControllerUser.php");
    //header("Content-Type : text/plain");
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
            echo "<span style='color:green;'>Login disponible</span>";
        }
        else{
            echo "<span style='color:red'>Login déjà utilisé</span>";  
        }
    }  
    else{
        echo "Login invalide";
    }
?>