<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <?php require("../../view/css/stylesheet.php");?>
  <title>Créer son compte</title>
</head>
<body id=index>
    <div id="div-crea">
        <h1>Créer son compte</h1>
        <p>Merci de remplir l'ensemble des informations suivantes afin de créer un compte.</p>
    </div>
    <form id="form-crea" action="../../config/routeur.php" method='post' enctype="multipart/form-data">
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
            
            <label for="photo">Choisissez une photo de profil (optionnel)</label>
            <input type="file" id="photo" name="photo" value="photo"/><br>
            <input type="button" id="effacer-photo" value="Effacer le fichier sélectionné"/>
            <span id="check-photo"></span>

        </fieldset>
        <div>
            <input type="submit" id="valider" value="Valider l'inscription"/>
            <input type='hidden' name='action' value='creerCompte'/>
            <input type="reset" value="Vider le formulaire"/>
        </div>
    </form>
    <a href="../../index.php">Retourner à la page de connexion</a>
    <?php require_once("../css/footer.php");?>
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
        const objetXHR = new createXHR();//création de la requête pour vérifier le login
        
        $(document).ready(function(){
            //Interroger la base de données pour l'existence du login
            objetXHR.onreadystatechange = function(){
                if(objetXHR.readyState == 4){
                    if(objetXHR.status >= 200 && objetXHR.status <= 299){
                        var reponse = this.responseText;
                        document.getElementById("check-login").innerHTML = reponse;
                       
                        //Affichage du message en fonction du login
                        if(reponse == "Login déjà utilisé"){
                            $("#valider").prop('disabled',true);
                            $("#check-login").css('color','red');
                        }
                        else{
                            $("#valider").prop('disabled',false);
                            $("#check-login").css('color','#00AA00');
                        }
                    }
                }
            }  

            //Appel de la fonction à chaque écriture dans l'input pour le login
            $("#login").on("input", function(){
                var login = document.getElementById("login").value;
                var request = "../../controller/checkLogin.php?login=" + login;
                objetXHR.open("GET",request,true);
                objetXHR.send(); 
            });

            $("#photo").on("change", function(){
                var filename = document.getElementById("photo").value;
                var extension = filename.split('.').pop().toLowerCase();
                var liste_ext_ok = ['jpg','png','jpeg'];
                var i = 0;
                var ok = true;
                while(i < liste_ext_ok.length && ok){
                    if(liste_ext_ok[i] == extension) ok = false;
                    i++;
                }
                if(ok != false){
                    document.getElementById("check-photo").innerHTML = "Fichier non valide (format jpg, png, jpeg) !";
                    $("#check-photo").css('color','red');
                    $("#valider").prop('disabled',true);
                }
                else{
                    document.getElementById("check-photo").innerHTML = "";
                    $("#valider").prop('disabled',false);
                }
            });

            $("#effacer-photo").on("click", function(){
                document.getElementById("photo").value = '';
                document.getElementById("check-photo").innerHTML = "";
                $("#valider").prop('disabled',false);
            });
        });    
    </script>
</body>
</html>