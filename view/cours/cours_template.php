<?php require_once("../css/theme.php");?>
<!DOCTYPE html>

<html>

    <head>

    </head>


    <body>
        
        <?php
            include('../../controller/ControllerCours.php');
            ControllerCours::loadPage();
        ?>

    </body>

</html>