<?php require_once("common.php"); ?>

<?php
if(userIsAuthenticated() === true) {
        header("location: homepage.php");
}

// instanzio le credenziali degli utenti, username e password, e salvo in una variabile di sessione l username, per utilizzarlo nel mio HTML
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $registrationIsSuccessful = register($_POST["username"],$_POST["password"]);

    if($registrationIsSuccessful === true) {
        header("location: login.php");
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
              <?php if ($registrationIsSuccessful !== true): ?>
                <p style="color: red">
                  <?php echo $registrationIsSuccessful ?>
                </p>
              <?php endif; ?>

              <form action="register.php" method="POST">
                  <!-- <?php if ($registrationIsSuccessful === true):?>
                    <p>Sei registrato!</p>
                  <?php endif; ?> -->


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
            </div>
          </div>
        </div>

    </body>

</html>
