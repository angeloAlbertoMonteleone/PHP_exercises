

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">

            <a class="nav-link" aria-current="page"href="homepage.php">
                HOME
            </a>

            <a class="nav-link" aria-current="page" href="chi-siamo.php">
              CHI SIAMO
            </a>

            <a class="nav-link" href="contattaci.php">
              CONTATTACI
            </a>

            <?php if(userIsAuthenticated() === true): ?>
              <?php echo $_SESSION["username"]; ?>
              ha fatto l`accesso

              <a class="nav-link" href="logout.php">
                LOGOUT
              </a>
            <?php else: ?>
              <a class="nav-link" href="login.php">
                LOGIN
              </a>

            <?php endif?>
          </div>
        </div>
      </div>
    </nav>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  </body>
</html>
