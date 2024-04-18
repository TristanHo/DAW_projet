<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <?php require("view/css/stylesheet.php");?>
  <title>Site des apprentis de Dijon</title>
</head>
<body id="index">

    <?php
    if(!isset($_COOKIE['theme'])){
        setcookie('theme','jour', 0, '/');
    }?>
    
    <h1>Bienvenue sur le site des apprentis de Dijon</h1>
    <form id="form-co" action="config/routeur.php" method='post' style="width:700px;margin-left:auto;margin-right:auto">
        <fieldset>
            <legend>Connexion</legend>
            <label for="login">Login</label>
            <input type="text" name ="login" required="required"/><br>
            <br>
            <label for="mdp">Mot de passe</label>
            <input type="password" name ="mdp" required="required"/>
            <input type='hidden' name='action' value='connect'/>
            <input type="submit" value="Se connecter"/>
        </fieldset>
    </form>
    <div style="margin-top:20px;width:700px;margin-left:auto;margin-right:auto">
        <span>Pas de compte ?</span>
        <a href='view/connexion/creerCompte.php'><button type=submit style="margin-left:10px;">Créer un compte</button></a>
        <span id="error"></span>
    </div>
    
    <?php
    require_once("view/css/footer.php");
    ?>
    <?php
        if(isset($_GET['infos'])){ 
            if($_GET['infos']=='false'){
                echo "<script>
                    $(document).ready(function(){
                        document.getElementById('error').innerHTML = 'Informations de connexion incorrectes';
                        $('#error').css('border','solid red');
                        $('#error').css('color','red');
                    });
                    </script>";
            }
            else if($_GET['infos']=='crea'){
                echo "<script>
                    $(document).ready(function(){
                        document.getElementById('error').innerHTML = 'Compte créé avec succès';
                        $('#error').css('border','solid green');
                        $('#error').css('color','green');
                    });
                    </script>";
            }
            else if($_GET['infos']=='ncrea'){
                echo "<script>
                    $(document).ready(function(){
                        document.getElementById('error').innerHTML = 'Une erreur est survenue lors de la création du compte';
                        $('#error').css('border','solid red');
                        $('#error').css('color','red');
                    });
                    </script>";
                }
        $_GET['infos']=null;
        }
    ?>
</body>
</html>