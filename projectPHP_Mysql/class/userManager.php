<?php

require_once "user.php";
require_once "DatabaseManager.php";

class userManager
{

private $databaseManager;

function __construct() {
    $this->databaseManager = new DatabaseManager();
}




/**
*@return user
*memorizza l` user in database*/
public function addUserInDb(string $username, string $plainPassword, bool $enabled = false):user
{
      // prendo una connessione al database

      // $connection = $this->databaseManager->getConnection();
      // chiamo una query "INSERT INTO ..."

      $cryptedPassword = $this->cryptPasswordWithAlgorithm($plainPassword);

      $query = "INSERT INTO usersdb.people (username, password, enabled) VALUES (:username, :cryptedPassword, :enabled)";

      $result = $this->databaseManager->executeQuery($query,
      ['username' => $username,
       'cryptedPassword' => $cryptedPassword,
       'enabled' => ($enabled === true) ? 1 : 0
     ]);

      return $this->findUserByUsername($username);
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
*@return array
*funzione che trova gli users nel database e ritorna un array di users*/
public function loadUsers():array
{
  $query = "SELECT * FROM usersdb.people";
  $users = $this->databaseManager->executeQuery($query);

  return $users;
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
public function findUserByUsername(string $username): user
{
  // avviare una connessione
  // $connection = $this->databaseManager->getConnection();

  // fare una query per selezionare l` user
  $query = "SELECT * FROM usersdb.people WHERE username = :username";

  // fare il fetch del risultato della query
  $result = $this->databaseManager->executeSelectQuery($query,
  ['username' => $username]);

  // aggiungere i dati dell user, nell oggetto user
  if(count($result) > 0) {
    return new user(
      $result[0]["id"],
      $result[0]["username"],
      $result[0]["password"]
    );
  }

  throw new \Exception(sprintf("Username con l` username %s non e` stato trovato", $username));
}




public function findUserById(int $id)
{
  // fare una query per selezionare l` user
  $query = "SELECT * FROM usersdb.people WHERE id = :id";

  $result = $this->databaseManager->executeSelectQuery($query,
  ['id' => $id]);

  // aggiungere i dati dell user, nell oggetto user
  if(count($result) > 0) {
    return new user(
      $result[0]["id"],
      $result[0]["username"],
      $result[0]["password"]
    );
  }

  throw new \Exception(sprintf("Username con l` id %s non e` stato trovato", $id));
}






/* aggiorna la password analizzando l array e passando la nuova password*/

public function updatePassword($username, string $oldPassword, string $newPlainPassword):void
{
      $user = $this->findUser($username, $oldPassword);

      $cryptedNewPassword = $this->cryptPasswordWithAlgorithm($newPlainPassword);

      $user->setCryptedPassword($cryptedNewPassword);

      // $user->setAlgorithm($currentCryptAlgorithm);

      $this->updateUser($user);

    printLog("L` ". $username . " ha cambiato la password");
}




/* funzione che fa l update dell user nell array, prima di passare (l array) ad updateUsersFile*/
public function updateUser(user $user):void
{
  // aggiornare la riga in database corrispondente all` user con username = user-getUsername()
  $connection = $this->databaseManager->getConnection();

  $username = $user->getUsername();
  $encryptedPassword = $user->getPassword();
  $enabled = $user->getEnabled();

  $query = "UPDATE usersdb.people SET username = :username, password = :encryptedPassword, enabled = :enabled WHERE username = :username";

  $result = $this->databaseManager->executeQuery($query,
  ['username' => $username,
   'encryptedPassword' => $encryptedPassword,
   'enabled' => ($enabled === true) ? 1 : 0
  ]);
  }




// funzione che cripta la password in base all` algortimo della password posseduta dall` utente
private function cryptPassword($password, $algorithm)
{
  if($algorithm === "md5") {
    return md5($password);
  }
  if($algorithm === "sha1") {
    return sha1($password);
  }
  throw new \Exception("algorithm della password non trovato");
}



// funzione che mi ritorna un obj di tipo user, e mi setta evenutualmente utente abilitato
public function buildUserFromSingleResult(array $result):user
 {
  $user = new user(
    $result[0]["id"],
    $result[0]["username"],
    $result[0]["password"]
  );


  if($result["enabled"] === '1'){
    $user->setEnabled(true);
  }
  return $user;
}


// funzione che crypta la password dell` utente e aggiunge un suo algoritmo;

public function cryptPasswordWithAlgorithm(string $plainPassword) {
  return password_hash($plainPassword, PASSWORD_DEFAULT);
}

}
?>
