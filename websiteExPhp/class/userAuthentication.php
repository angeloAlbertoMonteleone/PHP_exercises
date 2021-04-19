<?php

require_once "userManager.php";

class userAuthentication
{

  /**
  return @bool
  *ritorna true se l`user e` loggato/autentificato*/
  public function userIsAuthenticated(): bool {
    return array_key_exists("username", $_SESSION);
  }


public function getAuthenticatedUsername():string {
  if(!$this->userIsAuthenticated()) {
    throw new \Exception("L` utente non e` autenticato");
  }
  return $_SESSION["username"];
}



  /**
  return @bool
  * - restituisce una stringa di errore se il login non e` andato a buon fine
  * restituisce true se il login e` andato a buon fine, controlla se l user esiste ritornando true
  */
  public function login(string $username, string $password): bool
  {

    $userManager = new userManager();
    // users recuperati dal file users.csv
    // $users = loadUsers();

    // users recuperati dal file users.json
    $users = $userManager->loadUsersFromJson();
    // if($users === $usersFromJson) {
    //   var_dump(true);die;
    // }
    foreach ($users as $key => $user) {
      $currentUser = $user->getUsername();
      $currentCryptedPassword = $user->getPassword();


      if($username === $currentUser) {
          if($this->cryptPassword($password, $user->getPasswordAlgorithm()) === $currentCryptedPassword) {
          // imposto una variabile di sessione
          $_SESSION["username"] = $username;

          // scrivo un log
          printLog(sprintf("l`utente %s ha effettuato il login", $username));
          return true;
        }
          // potrei non mettere il return, e gestire due errori nel prossimo return, fuori
          throw new \Exception(sprintf("La password non e` corretta, riprova!"));
      }
    }
    throw new \Exception(sprintf("L` Utente %s non e` stato trovato" , $username));
  }


  /**
  @param string $username
  @param string $password
  * funzione che registra l` utente, aggiungendo un nuovo array dentro ad users array */
  public function register(string $username,string $password):bool
  {

    if(strlen($password) < 5) {
      throw new \Exception("Inserire una password piu` lunga!");
    }

    $userManager = new userManager();
    $usersFromJson = $userManager->loadUsersFromJson();

    foreach ($usersFromJson as $user) {

      if($user->getUsername() === $username) {
        throw new \Exception("Username gia` esistente, prova con un altro!");
      }
    }

      $passwordAlgorithm = $this->registerPasswordAlgorithm();
      $cryptPassword = $this->cryptPassword($password, $passwordAlgorithm);

      $userManager->addUserInDb(
        $username,
        $cryptPassword,
        $passwordAlgorithm
        );

        printLog("L`utente ha effettuato la registrazione");

    return true;

  }


// funzione che registra su ogni utente l`algoritmo della password;
private function registerPasswordAlgorithm() {
  return "sha1";
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


// funzione per cambiare password
public function changePassword($oldPassword, $newPassword) {

    $userManager = new userManager();
    $users = $userManager->loadUsersFromJson();

    $algorithm =  $this->registerPasswordAlgorithm();
    $newCryptedPassword = $this->cryptPassword($newPassword, $algorithm);
    $oldPasswordCrypted = $this->cryptPassword($oldPassword, $algorithm);

    $userManager->updatePassword($users, $_SESSION["username"], $oldPasswordCrypted, $newCryptedPassword, $algorithm);

    return true;
}



}

?>
