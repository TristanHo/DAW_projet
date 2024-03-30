<!DOCTYPE html>

<html>
    <head>

    </head>

    <body>
        <h1>Forum</h1>
        <h2>Liste des disciplines</h2>

        <?php

            echo '<ul>';

            include '../../controller/ControllerForum/ControllerForum.php';

            $subsArray = new ControllerForum();
            $subsArray->fillFromCSV();
            $subsArray->fillHomepage();

            echo '</ul>';
  
        ?>

    </body>
</html>