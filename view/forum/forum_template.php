<!DOCTYPE html>

<html>
    <head>

    </head>

    <body>

        <?php

            error_reporting(E_ALL);

            include('../../controller/ControllerForum.php');
            ControllerForum::retrieveTopics('Mécanique');

        ?>

    </body>
</html>