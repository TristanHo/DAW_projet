<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <?php require_once("../css/theme.php");?>
</head>
<body>
    <div style="margin-left:auto;margin-right:auto;width:700px;">
        <h1>Créer son compte</h1>
        <p>Merci de remplir l'ensemble des informations suivantes afin de créer un compte.</p>
    </div>
    <form action="../../controller/routeur.php" method='post' style="width:700px;margin-left:auto;margin-right:auto;input{width=1000px;}">
        <fieldset>
            <legend>Inscription</legend>
            
            <label for="login">Nom d'utilisateur (Login)</label>
            <input type="text" name ="login" id="login" required="required"/>
            <span id="check-login"></span><br>
            
            <label for="nom">Nom</label>
            <input type="text" name ="nom" placeholder="Dupont" required="required"/><br>
            
            <label for="prenom">Prénom</label>
            <input type="text" name ="prenom" placeholder="Jacques" required="required"/><br>
            
            <label for="password">Mot de passe</label>
            <input type="text" id="passwd" name ="password" required="required"/>
            <input type="checkbox" checked="checked" onclick="affPassword()" /><span> Afficher le mot de passe </span><br>
            
            <label style="margin-right:20px;">Rôle</label>
            <label for="etudiant">Etudiant</label>
            <input type="radio" name ="role" value="etudiant" checked="checked" required="required"/>
            <label for="professeur">Professeur</label>
            <input type="radio" name ="role" value="professeur" required="required"/><br/>         
            
            <input type="submit" value="Valider l'inscription"/>
            <input type='hidden' name='action' value='creerCompte'/>
        </fieldset>
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>

        //Fonction pour afficher le mot de passe en clair
        function affPassword(){
            let x = document.getElementById("passwd");
            if(x.type === "password"){
                x.type = "text";
            }
            else{
                x.type = "password";
            }
        }

        //Fonction pour créer la requête afin d'utiliser Ajax
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
        const objetXHR = new createXHR();        
        $(document).ready(function(){
            objetXHR.onreadystatechange = function(){
                if(objetXHR.readyState == 4){
                    if(objetXHR.status >= 200 && objetXHR.status <= 299){
                        var reponse = this.responseText;
                        document.getElementById("check-login").innerHTML = reponse;
                    }
                }
            }  
            $("#login").on("input", function(){
                var login = document.getElementById("login").value;
                var request = "../../controller/checkLogin.php?login=" + login;
                objetXHR.open("GET",request,true);
                objetXHR.send(); 
            });
        });    
    </script>
</body>
</html>