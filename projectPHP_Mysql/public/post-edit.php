<?php require_once("../common.php"); ?>

<?php

$error = null;

if($authenticationProvider->userIsAuthenticated() !== true) {
    header("location: login.php");
}

$post = $blogManager->findPost($_GET["id"]);

// instanzio le credenziali degli utenti, username e password, e salvo in una variabile di sessione l username, per utilizzarlo nel mio HTML
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $newTitle = $_POST["title"];
    $newContent = $_POST["post"];

    // $user = $authenticationProvider->getAuthenticatedUsername();
    try {
      $post = $blogManager->updatePost(
        $post,
        $newTitle,
        $newContent
        );
    } catch (\Exception $e) {
      $error = $e->getMessage();
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
              MODIFICA POST
            </div>
            <br>
            <div class="col-md-12">

              <form action="post-edit.php?id=<?php echo $_GET["id"]; ?>" method="POST">

                  <div class="mb-3">
                    <label for="exampleInputText" class="form-label">Inserisci il titolo del post</label>
                    <input type="text" name="title" class="form-control" id="exampleInputTitle" value="<?php echo $post->getTitle()?>">
                  </div>

                  <div class="mb-3">
                    <label for="exampleInputText" class="form-label">Inserisci il testo del tuo post</label>
                    <textarea type="text" name="post" class="form-control" id="exampleInputPost"><?php echo $post->getContent()?></textarea>
                  </div>

                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>

            </div>
          </div>
        </div>

    </body>

</html>
