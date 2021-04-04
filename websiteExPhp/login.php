<?php require_once("common.php"); ?>

<?php


// instanzio le credenziali degli utenti, username e password, e salvo in una variabile di sessione l username, per utilizzarlo nel mio HTML
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $loginSuccessful = login($username, $password);

    if($loginSuccessful === true) {
      $_SESSION["username"] = $username;
    }
}
?>


<html>
    <body>
        <?php require_once 'menu.php';?>

        <div class="container">

          <form action="login.php" method="POST">
              <?php if (userIsAuthenticated() === true):?>
                <p>Sei gia loggato!</p>
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

    </body>

</html>
