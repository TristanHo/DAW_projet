<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Question</title>
</head>
<body>

<form action='../controller/routeur.php' method="get">
    <label for="idquestion">ID Question :</input>
    <input type='text' name="idquestion"> <br>

    <label for="question">Question :</input>
    <input type='text' name="question" required> <br>

    <label for="choix1">Choix 1 :</input>
    <input type='text' name="choix1">
    <input type="checkbox" name="check[]" value=""><br>

    <label for="choix2">Choix 2 :</input>
    <input type='text' name="choix2">
    <input type="checkbox" name="check[]"><br>

    <label for="choix3">Choix 3 :</input>
    <input type='text' name="choix3">
    <input type="checkbox" name="check[]"><br>

    <label for="choix4">Choix 4 :</input>
    <input type='text' name="choix4">
    <input type="checkbox" name="check(]"><br>

    <input type ='hidden' name="action" value="add"/>
    <input type="submit"/>
</form>

</body>
</html>