
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="external/qunit.css">
</head>
<body>
    <div style="color:blue;margin-left:auto;margin-right:auto;width:700px;">
        <h1>Bienvenue sur le site des apprentis de Dijon</h1>
    </div>
    <form action="/controller/controllerConnexion.php" style="width:1000px;margin-left:auto;margin-right:auto">
        <fieldset>
            <legend>Connexion</legend>
            <label for="login">Login</label>
            <input type="text" name ="login" required="required"/><br>
            <br>
            <label for="mdp">Mot de passe</label>
            <input type="password" name ="mdp" required="required"/>
            <input type="submit" value="Se connecter"/>
        </fieldset>
    </form>
</body>
</html>