<?php require_once("../common.php"); ?>

<html>
    <?php require_once('../bootstrap_css_link.php')?>
    <body>
        <?php require_once '../navbar.php';?>

        <div class="container">
          <p>HOME</p>
            <?php foreach($blogManager->getPost() as $post): ?>
              <div class="row">
                <div class="col-md-12">
                  Title
                </div>
                <div class="col-md-12">
                  Content
                </div>
                <div class="col-md-12">
                  Date
                </div>
              </div>
            <?php endforeach; ?>
        </div>

    </body>

</html>
