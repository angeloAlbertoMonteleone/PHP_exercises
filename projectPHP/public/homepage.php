<?php require_once("../common.php"); ?>

<html>
    <?php require_once('../bootstrap_css_link.php')?>
    <body>
        <?php require_once '../navbar.php';?>

        <div class="container">
          <p>HOME</p>
            <?php foreach($blogManager->getPost() as $post): ?>
              <div class="row mt-5">
                <div class="col-md-12">
                  <?php echo $post->getTitle() ?>
                </div>
                <div class="col-md-12">
                  <?php echo $post->getContent() ?>
                </div>
                <?php if ($post->getAuthorUsername() !== null): ?>
                  <div class="col-md-12">
                    Author: <?php echo $post->getAuthorUsername(); ?>
                  </div>
                <?php endif; ?>
                <div class="col-md-12">
                  Inserito il: <?php echo $post->getCreationDate()->format('Y-m-y H:i:s') ?>
                </div>
              </div>
            <?php endforeach; ?>
        </div>

    </body>

</html>
