<?php require_once("../common.php"); ?>

<?php

  $error = null;

  if($authenticationProvider->userIsAuthenticated() !== true) {
      header("location: login.php");
  }

  $user = $authenticationProvider->getAuthenticatedUsername();
  $post = $blogManager->findPost($_GET["id"]);

  if($post) {
    $blogManager->deletePost($user, $post);
  }

  header("location: post-index.php");
?>
