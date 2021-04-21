<?php

require_once "user.php";

class userManager
{

/**
@return array
* estrapola gli utenti dal file users.json e ritorna gli users in un array di oggetti(decodificati in arrays)
*/
public function loadUsersFromJson():array
{
  $userPathAbsolute = $this->getUsersPathAbsolute();

  if(!file_exists($userPathAbsolute)){
    return [];
  }

  $content = file_get_contents($userPathAbsolute);
  $users = json_decode($content, true);

  if($users === null) {
    echo "Impossibile caricare gli utenti ", json_last_error_msg();
  }

  $output = [];

  foreach ($users as $key => $user) {
    $output[] = new user(
      $user["username"],
      $user["password"]
      // $user["crypt_algorithm"]
    );
    // // $output = new user(
    // //   $user["username"],
    // //   $user["password"],
    // //   $user["crypt_algorithm"]
    // // );
    // //
    // $users[$key] = $output;
  }

  return $output;
}



/*memorizza l` user in database*/
public function addUserInDb(string $username, string $plainPassword) {

      $userPathAbsolute = $this->getUsersPathAbsolute();

      $users = $this->loadUsersFromJson();

      $cryptPassword = $this->cryptPasswordWithAlgorithm($plainPassword);

      $users[] = new user(
        $username,
        $cryptPassword
      );

      $this->updateUsersFile($users);
}




/*prende la path assoluta dell` users.json*/
public function getUsersPathAbsolute() {
  $root = $_SERVER["DOCUMENT_ROOT"];
  $userPath = sprintf('%s/websiteExPhp/users.json',$root);

  return $userPath;
}




/*carica sul nostro database il nuovo users [],(users di array di istanze user) su file json */
private function updateUsersFile(array $array) {

  $userPathAbsolute = $this->getUsersPathAbsolute();

  $output = [];

  foreach ($array as $user) {
    $output[] = [
      "username" => $user->getUsername(),
      "password" => $user->getPassword()
    ];

  }


  // convertiamo users in array, da un array di oggetti
  file_put_contents($userPathAbsolute, json_encode($output));
}




public function findUser(string $username, string $plainPassword): user
{
  /* verifica se l utente esiste, se no lancia un eccezione*/
    $user = $this->findUserByUsername($username);


    if(password_verify($plainPassword, $user->getPassword())){
      return $user;
    };

    // $cryptedAlgorithm = $this->registerPasswordAlgorithm();
    // $cryptPassword = $this->cryptPassword($plainPassword, $cryptedAlgorithm);
    // if($cryptPassword === $user->getPassword()) {
    // }

    throw new \Exception(sprintf("Utente con username %s non trovato",$username));

}



public function findUserByUsername(string $username): user {
  $users = $this->loadUsersFromJson();
  foreach($users as $user) {
    if($username === $user->getUsername()){
      return $user;
    }
  }
  throw new \Exception(sprintf("L Username %s non e` stato trovato", $username));

}




/* aggiorna la password analizzando l array e passando la nuova password*/
public function updatePassword(array $users, $username, string $oldPassword, string $plainPassword)
{
      $user = $this->findUser($username, $oldPassword);

      // $currentCryptAlgorithm = $this->registerPasswordAlgorithm();
      // $oldPasswordCrypted = $this->cryptPasswordWithAlgorithm($oldPassword);
      //
      // foreach ($users as $user) {
      //   if($user->getUsername() === $username){
      //     if($user->getPassword() === $oldPassword){
            // $users[$key]["password"] = $authenticationProvider->cryptPassword($newPassword, $authenticationProvider->registerPasswordAlgorithm());
            // $users[$key]["crypt_algorithm"] = $authenticationProvider->registerPasswordAlgorithm();

      $cryptNewPassword = $this->cryptPasswordWithAlgorithm($plainPassword);

      $user->setCryptedPassword($cryptNewPassword);

      // $user->setAlgorithm($currentCryptAlgorithm);

      $this->updateUser($user);

    printLog("L` ". $username . " ha cambiato la password");
}


/* funzione che fa l update dell user nell array, prima di passare (l array) ad updateUsersFile*/
public function updateUser(user $user)
{
  $users = $this->loadUsersFromJson();
  foreach ($users as $key => $value) {
    if($value->getUsername() === $user->getUsername()){
      $users[$key] = $user;
    }
  }
  $this->updateUsersFile($users);
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




// funzione che registra su ogni utente l`algoritmo della password;
// private function registerPasswordAlgorithm() {
//   return "sha1";
// }

public function cryptPasswordWithAlgorithm(string $plainPassword) {
  return password_hash($plainPassword, PASSWORD_DEFAULT);
}

}
?>
