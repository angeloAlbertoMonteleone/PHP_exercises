<?php require_once("../common.php"); ?>

<?php if($authenticationProvider->userIsAuthenticated() !== true) {
    header("location: login.php");
}
?>

<?php if($_SERVER["REQUEST_METHOD"] === "POST") {
  $message = $_POST["message"];
  if(empty($message) === false) {
    $emailIsSent = mail('angeloalbertomnt@gmail.com', 'saluto', sprintf('qualcuno di ha scritto: "%s"',$message));
    printLog(sprintf("L`utente %s ha inviato un email"), $_SESSION["username"]);


  }
}

?>
<html>
    <?php require_once('../bootstrap_css_link.php')?>
    <body>
        <?php require_once '../navbar.php';?>

        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <!-- la condizione controlla se l email esiste dando true, e se e` stata inviata  -->
              <?php if (isset($emailIsSent) && $emailIsSent === true): ?>

                Messaggio inviato <a href="contattaci.php">Invia un altro messaggio</a>

              <?php else: ?>

                <form action="contattaci.php" method="POST">

                  <p>Contattaci con questo form!</p>

                  <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" id="exampleInputMessage"></textarea>
                  </div>

                  <button type="submit" class="btn btn-primary">INVIA</button>
                </form>

              <?php endif; ?>

            </div>
          </div>
        </div>
    </body>
</html>
