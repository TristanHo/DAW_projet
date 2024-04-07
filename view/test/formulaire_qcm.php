<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de QCM</title>
</head>
<body>
    <form action="QCMController.php" method="post">
        <?php
        // Afficher les questions du QCM
        foreach ($questions as $question) {
            $question->afficherquestionformulaire();
        }
        ?>
        <button type="submit">Soumettre</button>
    </form>
</body>
</html>
