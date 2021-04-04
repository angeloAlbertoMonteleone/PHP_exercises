<?php require_once("common.php"); ?>
<?php if(userIsAuthenticated() !== true) {
    header("location: login.php");
}
?>

<html>
    <body>
        <?php require_once 'menu.php';?>
    </body>
    <p>CONTATTACI</p>
</html>
