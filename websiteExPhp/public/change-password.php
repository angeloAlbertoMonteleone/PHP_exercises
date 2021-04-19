<?php require_once("../common.php"); ?>

<?php
$changeSuccessful = false;
$username = false;

if($_SERVER["REQUEST_METHOD"] === "POST") {
  // instanzio le credenziali degli utenti, oldPassword e newPassword, e salvo in una variabile di sessione la nuova password
    try {
      $username = $authenticationProvider->getAuthenticatedUsername();
    } catch (\Exception $e) {
      $error = $e->getMessage();
    }

    $changeSuccessful = $authenticationProvider->changePassword($_POST["oldPassword"], $_POST["newPassword"]);

    if($changeSuccessful === true) {
        header("location: homepage.php");
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
              <?php if($changeSuccessful === true):?>

                <p>Password aggiornata correttamente!</p>

                <?php else: ?>

              <form action="change-password.php" method="POST">

                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Vecchia Password</label>
                  <input type="password" name="oldPassword" class="form-control" id="exampleInputPassword1">
                </div>

                <div class="mb-3">
                  <label for="exampleInputPassword2" class="form-label">Nuova Password</label>
                  <input type="password" name="newPassword" class="form-control" id="exampleInputPassword2">
                </div>

                <button type="submit" class="btn btn-primary">Cambia Password</button>
              </form>

            <?php endif ?>

            </div>
          </div>
        </div>

    </body>

</html>
