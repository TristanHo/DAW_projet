<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet">
</head>
<body>
    <h1>Bienvenue 
        <?php 
        echo "".$_COOKIE['username'];?>
    </h1>
    <a href="../view/users/list.php">liste users</a>
    <script type="text/javascript">
        //window.location.replace($_SERVER['REQUEST_URI']);
    </script>
</body>
</html>