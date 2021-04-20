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

      $user = $userManager->findUser($username, $password);

      // users recuperati dal file users.json
      // $users = $userManager->loadUsersFromJson();
      // if($users === $usersFromJson) {
      //   var_dump(true);die;
      // }

        // imposto una variabile di sessione
        $_SESSION["username"] = $user->getUsername();

        // scrivo un log
        printLog(sprintf("l`utente %s ha effettuato il login", $user->getUsername()));
        return true;
      //     // potrei non mettere il return, e gestire due errori nel prossimo return, fuori
      //     throw new \Exception(sprintf("La password non e` corretta, riprova!"));
      // }
  }




  /**
  @param string $username
  @param string $password
  * funzione che registra l` utente, aggiungendo un nuovo array dentro ad users array */
  public function register(string $username,string $plainPassword):bool
  {

    if(strlen($plainPassword) < 5) {
      throw new \Exception("Inserire una password piu` lunga!");
    }

    $userManager = new userManager();
    $usersFromJson = $userManager->loadUsersFromJson();

    foreach ($usersFromJson as $user) {
      if($user->getUsername() === $username) {
        throw new \Exception("Username gia` esistente, prova con un altro!");
      }
    }

      $userManager->addUserInDb(
        $username,
        $plainPassword
        );

        printLog("L`utente ha effettuato la registrazione");

    return true;

  }





// funzione per cambiare password
public function changePassword($oldPassword, $newPlainPassword):bool
{

    $userManager = new userManager();
    $users = $userManager->loadUsersFromJson();


    $userManager->updatePassword($users, $_SESSION["username"], $oldPassword, $newPlainPassword);

    return true;
}



}

?>
