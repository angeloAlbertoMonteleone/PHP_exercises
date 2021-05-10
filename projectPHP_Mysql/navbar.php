    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">

            <a class="nav-link" aria-current="page" href="homepage.php">
                HOME
            </a>

            <a class="nav-link" aria-current="page" href="chi-siamo.php">
              CHI SIAMO
            </a>

            <a class="nav-link" href="contattaci.php">
              CONTATTACI
            </a>

            <?php if($authenticationProvider->userIsAuthenticated() === true): ?>
              <a class="nav-link" href="logout.php">
                <?php echo $_SESSION["username"]; ?> ha fatto l`accesso (LOGOUT)
              </a>
              <a class="nav-link" href="change-password.php">
                CAMBIA PASSWORD
              </a>

              <a class="nav-link" href="create-post.php">
                SCRIVI POST
              </a>

              <a class="nav-link" href="post-index.php">
                I MIEI POSTS
              </a>

            <?php else: ?>
              <a class="nav-link" href="login.php">
                LOGIN
              </a>

              <a class="nav-link" href="register.php">
                REGISTER
              </a>
            <?php endif?>
          </div>
        </div>
      </div>
    </nav>
