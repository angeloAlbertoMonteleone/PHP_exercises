<?php

session_start();

// restituisce l array di tutti gli utenti leggendo il file csv
function loadUsers():array {
  if (($handle = fopen("users.csv", "r")) !== FALSE) {
    $users = [];
    while (($data = fgetcsv($handle)) !== FALSE) {
      $users[] = $data;
    }
    fclose($handle);
    return $users;
  }
}


// controlla se l user esiste ritornando true
function existsUser($username,$password):bool
{
  $users = loadUsers();
  foreach ($users as $user) {
    $currentUser = $user[0];
    $currentPassword = $user[1];

    if($username === $currentUser && $password === $currentPassword) {
      return true;
    }
  }
  return false;
}

// instanzio le credenziali degli utenti, username e password, e salvo in una variabile di sessione l username, per utilizzarlo nel mio HTML
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $existsUser = existsUser($username, $password);

    if($existsUser === true) {
      $_SESSION["username"] = $username;
    }
    var_dump($existsUser);
}
?>


<html>
    <body>
        <?php require_once 'menu.php';?>

        <div class="container">

          <?php echo $_SESSION["username"];
            echo " ha fatto l`accesso"
            ?>
          <form action="login.php" method="POST">
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
