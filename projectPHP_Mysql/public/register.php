<?php require_once "../common.php" ;


$registrationIsSuccessful = false;
$error = false;

// instanzio le credenziali degli utenti, username e password, e salvo in una variabile di sessione l username, per utilizzarlo nel mio HTML
if($_SERVER["REQUEST_METHOD"] === "POST") {
  $error = false;
  try {
    $registrationIsSuccessful = $authenticationProvider->register($_POST["username"],$_POST["password"]);
  } catch (\Exception $e) {
    $error = $e->getMessage();
    $registrationIsSuccessful = false;
  }

  // if($registrationIsSuccessful === true) {
  //   try {
  //     $authenticationProvider->login($_POST["username"],$_POST["password"]);
  //   } catch (\Exception $e) {
  //
  //   }
  //   return header("location: homepage.php");
  // }

}
?>


<html>
      <?php require_once('../bootstrap_css_link.php')?>
    <body>
        <?php require_once '../navbar.php';?>

        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <?php if ($registrationIsSuccessful !== true): ?>
                <p style="color: red">
                  <?php echo $error ?>
                </p>
              <?php endif; ?>


              <?php if ($registrationIsSuccessful === true):?>
                La registrazione si e` conclusa! Clicca sul link di conferma

              <?php else: ?>
                <form action="register.php" method="POST">


                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="username" name="username" class="form-control" id="exampleInputUsername">
                  </div>

                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                  </div>

                  <button type="submit" class="btn btn-primary">Register</button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>

    </body>

</html>
