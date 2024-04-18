<?php
    if($_COOKIE['theme'] == 'jour'){
        setcookie('theme','nuit', 0, '/');
        echo "/DAW-projet/css/nuit.css";
       
    }
    else{
        setcookie('theme','jour', 0, '/');
        echo "/DAW-projet/css/jour.css";
    }
    
?>