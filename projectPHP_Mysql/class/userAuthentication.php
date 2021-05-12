<?php

require_once "userManager.php";

class userAuthentication
{

  /**
  *@return bool
  *ritorna true se l`user e` loggato/autentificato*/
  public function userIsAuthenticated(): bool {
    return array_key_exists("username", $_SESSION);
  }


  public function getAuthenticatedUsername():user {
    if($this->userIsAuthenticated() === false) {
      throw new \Exception("L` utente non e` autenticato");
    }
    $username = $_SESSION["username"];

    $userManager = new userManager();
    return $userManager->findUserByUsername($username);
  }



  /**
  *@return bool
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
  *@param string $username
  *@param string $password
  * funzione che registra l` utente, aggiungendo un nuovo array dentro ad users array
  */
  public function register(string $username,string $plainPassword):bool
  {

    if(strlen($plainPassword) < 5) {
      throw new \Exception("Inserire una password piu` lunga!");
    }

    if(strpos($username, '@') === false) {
      throw new \Exception("Inserire un\' email valida");
    }

    $userManager = new userManager();
    /**
     * se l'utente esiste già, lancia un'eccezione
     */
    try {
        $userFoundInDatabase = $userManager->findUserByUsername($username);
    } catch (Exception $exception) {
        $userFoundInDatabase = null;
    }

    if ($userFoundInDatabase !== null) {
        throw new Exception('Utente già esistente');
    }


    $user = $userManager->addUserInDb(
      $username,
      $plainPassword,
      false
      );


    $email = $this->sendConfirmationEmail($user);

    $userManager->printLog("L`utente ha effettuato la registrazione");

    return true;

  }


public function sendConfirmationEmail(user $user):void
{
  $recipient = $user->getUsername();
  $header = "MIME-Version: 1.0 \r\n";
  $header .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
  $message = "Conferma la tua email su questo link";
  mail($recipient, "Conferma la tua registrazione", $message, $header);
}



// funzione per cambiare password
public function changePassword($oldPassword, $newPlainPassword):bool
{
    $userManager = new userManager();

    $userManager->updatePassword($_SESSION["username"], $oldPassword, $newPlainPassword);

    return true;
}



}

?>
