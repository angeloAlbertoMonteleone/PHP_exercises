<?php require_once("../common.php"); ?>

<?php
      printLog("L`utente " .  $_SESSION["username"] . " ha effettuato il logout");

      session_destroy();

      header("location: homepage.php");
?>
