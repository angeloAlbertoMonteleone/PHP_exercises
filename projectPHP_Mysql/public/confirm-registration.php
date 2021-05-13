<?php require_once "../common.php";


try {
  $authenticationProvider->enableUser($_GET["userId"])
} catch (\Exception $e) {
  header("location: homepage.php")
}



?>


<html>
      <?php require_once('../bootstrap_css_link.php')?>
    <body>
        <?php require_once '../navbar.php';?>

        <div class="container">
          <div class="row">
            <div class="col-md-12">
              La tua registrazione e` andata a buon fine!!

              <a href="/homepage.php">
                VAI ALLA HOMEPAGE
              </a>
            </div>
          </div>
        </div>

    </body>

</html>
