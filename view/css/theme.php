<?php
    $theme = $_COOKIE['theme'];
    echo '<button id="theme" value="theme">Changer le thème</button>';
    $href = "http://localhost/DAW-projet/css/$theme.css";
    echo "<link rel='stylesheet' href=$href>";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    const objetXHRtheme = new createXHR();
    function createXHR(){
            var resultat = null;
            try{ //Mozilla, Opera ...
                resultat = new XMLHttpRequest();
            }
            catch(Error){
                try{ //Internet Edge v > 5.0
                    resultat = new ActiveXObject("Msxm12.XMLHTTP");
                }
                catch(Error){
                    try{//Internet Edge v5.0
                        resultat = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    catch(Error){//Erreur
                        resultat = null;
                    }
                }
            }
            return resultat;
        }        
    $(document).ready(function(){
        objetXHRtheme.onreadystatechange = function(){
            if(objetXHRtheme.readyState == 4){
                if(objetXHRtheme.status >= 200 && objetXHRtheme.status <= 299){
                    var reponse = this.responseText;
                    $('link').attr('href',reponse);
                }
            }
        }  
        $("#theme").on("click", function(){
            var theme = $('link').attr('href');
            var request = '/DAW-projet/controller/changeTheme.php';
            objetXHRtheme.open("GET",request,true);
            objetXHRtheme.send(); 
        });
    });    
</script>
    