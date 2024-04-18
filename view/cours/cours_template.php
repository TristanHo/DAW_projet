<!DOCTYPE html>

<html>

    <head>
        <?php require("../css/stylesheet.php");?>
    </head>


    <body>
        
        <?php require("../css/header.php");?>

        <?php
            include('../../controller/ControllerCours.php');
            ControllerCours::loadPage();
        ?>

        <?php require("../css/footer.php");?>

    </body>

</html>