<?php

class userAuthentication
{

  /**
  return @bool
  *ritorna true se l`user e` loggato/autentificato*/
  public function userIsAuthenticated(): bool {
    return array_key_exists("username", $_SESSION);
  }



  /**
  return @bool
  * - restituisce una stringa di errore se il login non e` andato a buon fine
  * restituisce true se il login e` andato a buon fine, controlla se l user esiste ritornando true
  */
  public function login(string $username, string $password): bool
  {
    // users recuperati dal file users.csv
    // $users = loadUsers();

    // users recuperati dal file users.json
    $users = loadUsersFromJson();
    // if($users === $usersFromJson) {
    //   var_dump(true);die;
    // }
    foreach ($users as $user) {
      $currentUser = $user["username"];
      $currentPassword = $user["password"];

      if($username === $currentUser) {
          if($password === $currentPassword) {
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
  public function register(string $username, string $password):bool
  {
    $usersJson = loadUsersFromJson();
    if(strlen($password) < 5) {
      throw new \Exception("Inserire una password piu` lunga!");
    }
    foreach ($usersJson as $user) {
      if($user["username"] === $username) {
        throw new \Exception("Username gia` esistente, prova con un altro!");
      }
    }

    $usersJson[] = [
      "username" => $username,
      "password" => $password
    ];

    file_put_contents("users.json", json_encode($usersJson));
    return true;
  }
}
