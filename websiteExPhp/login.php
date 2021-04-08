<?php require_once("common.php"); ?>

<?php

$error = false;
$loginSuccessful = false;

// instanzio le credenziali degli utenti, username e password, e salvo in una variabile di sessione l username, per utilizzarlo nel mio HTML
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    try {
      $loginSuccessful = $authenticationProvider->login($username, $password);
    } catch (\Exception $e) {
      $error = $e->getMessage();
      $loginSuccessful = false;
    }
    if($loginSuccessful === true) {
        header("location: homepage.php");
    }
}
?>


<html>
      <?php require_once('bootstrap_css_link.php')?>
    <body>
        <?php require_once 'navbar.php';?>

        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <?php if ($loginSuccessful !== true): ?>
                <p style="color: red">
                  <?php echo $error ?>
                </p>
              <?php endif; ?>

              <form action="login.php" method="POST">
                  <?php if ($authenticationProvider->userIsAuthenticated() === true):?>
                    <p>Sei loggato!</p>
                  <?php endif; ?>


                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Username</label>
                  <input type="username" name="username" class="form-control" id="exampleInputUsername">
                </div>

                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>

    </body>

</html>
