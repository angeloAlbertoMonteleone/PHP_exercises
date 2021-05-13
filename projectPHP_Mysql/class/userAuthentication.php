<?php

require_once "userManager.php";

class userAuthentication
{
  private $userManager;


  function __construct() {
    $this->userManager = new userManager();
  }



  /**
  *@return bool
  *ritorna true se l`user e` loggato/autentificato*/
  public function userIsAuthenticated(): bool
  {
    return array_key_exists("username", $_SESSION);
  }



  /**
  *@return user
  *ritorna l user tramite l username*/
  public function getAuthenticatedUsername():user
  {
    if($this->userIsAuthenticated() === false) {
      throw new \Exception("L` utente non e` autenticato");
    }
    $username = $_SESSION["username"];

    return $this->userManager->findUserByUsername($username);
  }



  /**
  *@return bool
  fare un double check, dopo aver fatto il set up di php mail, per fare il controllo dell enable
  * - restituisce una stringa di errore se il login non e` andato a buon fine
  * restituisce true se il login e` andato a buon fine, controlla se l user esiste ritornando true
  */
  public function login(string $username, string $password): bool
  {
        $user = $this->userManager->findUser($username, $password);
        // if($user->getEnabled() !== true) {
        //   throw new \Exception("utente non trovato");
        // }

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

    /**
     * se l'utente esiste già, lancia un'eccezione
     */
    try {
        $userFoundInDatabase = $this->userManager->findUserByUsername($username);
    } catch (\Exception $exception) {
        $userFoundInDatabase = null;
    }

    if ($userFoundInDatabase !== null) {
        throw new \Exception('Utente già esistente');
    }

    $user = $this->userManager->addUserInDb(
      $username,
      $plainPassword,
      false
      );

    $this->sendConfirmationEmail($user);

    $this->userManager->printLog("L`utente ha effettuato la registrazione");

    return true;

  }



// funzione che manda un email di conferma di regristazione
public function sendConfirmationEmail(user $user):void
{
  $recipient = $user->getUsername();
  $header = "MIME-Version: 1.0 \r\n";
  $header .= 'Content-Type: text/html; charset=utf-8' . "\r\n";

  $url = sprintf('%s/confirm-registration.php?userId=%s', $_SERVER["HTTP_ORIGIN"], $user->getId());
  $message = "Conferma la tua email su questo link";

  mail($recipient, "Conferma la tua registrazione", $message, $header);
}




public function enableUser(int $userId)
{
  $user = $this->userManager->findUserById($userId);

  if($user->getEnabled === true) {
    throw new \Exception("utente gia` abilitato");
  }

  $user->setEnable(true);
  

  $this->userManager->updateUser($user);
}






// funzione per cambiare password
public function changePassword($oldPassword, $newPlainPassword):bool
{

    $this->userManager->updatePassword($_SESSION["username"], $oldPassword, $newPlainPassword);

    return true;
}



}

?>
