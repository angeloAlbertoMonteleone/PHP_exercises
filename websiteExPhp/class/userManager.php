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
      $user["password"],
      $user["crypt_algorithm"]
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
public function addUserInDb(string $username, string $password, string $algorithm) {

      $userPathAbsolute = $this->getUsersPathAbsolute();

      $users = $this->loadUsersFromJson();

      $users[] = new user(
        $username,
        $password,
        $algorithm
      );

      $this->updateUsersFile($users);
}




/*prende la path assoluta dell` users.json*/
public function getUsersPathAbsolute() {
  $root = $_SERVER["DOCUMENT_ROOT"];
  $userPath = sprintf('%s/websiteExPhp/users.json',$root);

  return $userPath;
}


/* aggiorna la password analizzando l array e passando la nuova password*/
public function updatePassword(array $users, $username, string $oldPassword, string $newPassword, $algorithm):array
{
  foreach ($users as $user) {
    if($user->getUsername() === $username){
      if($user->getPassword() === $oldPassword){
        // $users[$key]["password"] = $authenticationProvider->cryptPassword($newPassword, $authenticationProvider->registerPasswordAlgorithm());
        // $users[$key]["crypt_algorithm"] = $authenticationProvider->registerPasswordAlgorithm();

        $user->setCryptedPassword($newPassword);
        $user->setAlgorithm($algorithm);
        }
      }
    }

    $this->updateUsersFile($users);
    printLog("L` ". $username . " ha cambiato la password");

  return $users;
}


/*carica sul nostro database il nuovo users [],(users di array di istanze user) su file json */
private function updateUsersFile(array $array) {

  $userPathAbsolute = $this->getUsersPathAbsolute();

  $output = [];

  foreach ($array as $user) {
    $output[] = [
      "username" => $user->getUsername(),
      "password" => $user->getPassword(),
      "crypt_algorithm" => $user->getPasswordAlgorithm()
    ];

  }


  // convertiamo users in array, da un array di oggetti
  file_put_contents($userPathAbsolute, json_encode($output));

}


}
?>
