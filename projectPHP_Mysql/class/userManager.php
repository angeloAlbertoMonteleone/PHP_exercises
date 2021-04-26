<?php

require_once "user.php";

class userManager
{



/**
*@return $connection
*funzione che fa una richiesta a mysql,e che ritorna una connessione PDO
*/

private function getConnection() {
  try {
    $connection = new PDO('mysql:host=localhost;dbname=usersdb', "root", "root");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
  return $connection;
}






/*memorizza l` user in database*/
public function addUserInDb(string $username, string $plainPassword) {
      // prendo una connessione al database

      // chiamo una query "INSERT INTO ..."
      $connection = $this->getConnection();

      $cryptedPassword = $this->cryptPasswordWithAlgorithm($plainPassword);

      $query = "INSERT INTO people (username, password) VALUES ('$username', '$cryptedPassword')";

      try {
        $statement = $connection->query($query);
      } catch (\Exception $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }

}




/**
TODO controllare se questa funzione e` usata altrove
*prende la path assoluta dell` users.json*/

public function getUsersPathAbsolute() {
  $root = $_SERVER["DOCUMENT_ROOT"];
  $userPath = sprintf('%s/websiteExPhp/users.json',$root);

  return $userPath;
}





/**
*@return user
*funzione che trova un user passando un username e password, e ritorna un oggetto user*/

public function findUser(string $username, string $plainPassword): user
{
  /* verifica se l utente esiste, se no lancia un eccezione*/
    $user = $this->findUserByUsername($username);

    if(password_verify($plainPassword, $user->getPassword())){
      return $user;
    };

    throw new \Exception(sprintf("Utente con username %s non trovato",$username));
}



/**
*@return user
*funzione che trova un user da un username passato come parametro, e ritorna un oggetto user*/

public function findUserByUsername(string $username): user {

  // avviare una connessione
  $connection = $this->getConnection();

  // fare una query per selezionare l` user
  $query = "SELECT * FROM people WHERE username = '$username'";

  try {
    $statement = $connection->query($query, PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }

  // fare il fetch del risultato della query
  $users = $statement->fetchAll();

  // aggiungere i dati dell user, nell oggetto user
  if(count($users) > 0) {
    return new user(
      $users[0]["username"],
      $users[0]["password"]
    );
  }

  throw new \Exception("Username non trovato");
}




/* aggiorna la password analizzando l array e passando la nuova password*/

public function updatePassword($username, string $oldPassword, string $newPlainPassword)
{
      $user = $this->findUser($username, $oldPassword);

      $cryptedNewPassword = $this->cryptPasswordWithAlgorithm($newPlainPassword);

      $user->setCryptedPassword($cryptedNewPassword);

      // $user->setAlgorithm($currentCryptAlgorithm);

      $this->updateUser($user);

    printLog("L` ". $username . " ha cambiato la password");
}




/* funzione che fa l update dell user nell array, prima di passare (l array) ad updateUsersFile*/

public function updateUser(user $user)
{
  // aggiornare la riga in database corrispondente all` user con username = user-getUsername()
  $connection = $this->getConnection();

  $username = $user->getUsername();
  $encryptedPassword = $user->getPassword();

  $query = "UPDATE people SET username = '$username', password = '$encryptedPassword' WHERE username = '$username'";

  try {
    $statement = $connection->query($query, PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }

  }




// funzione che cripta la password in base all` algortimo della password posseduta dall` utente

private function cryptPassword($password, $algorithm) {
  if($algorithm === "md5") {
    return md5($password);
  }
  if($algorithm === "sha1") {
    return sha1($password);
  }
  throw new \Exception("algorithm della password non trovato");
}





// funzione che crypta la password dell` utente e aggiunge un suo algoritmo;

public function cryptPasswordWithAlgorithm(string $plainPassword) {
  return password_hash($plainPassword, PASSWORD_DEFAULT);
}

}
?>
