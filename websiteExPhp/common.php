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

function loadUsersFromJson():array
{
  $content = file_get_contents("users.json");
  $user = json_decode($content, true);

    if($user === null) {
      echo "Impossibile caricare gli utenti ", json_last_error_msg();
  }
  return $user;
}

// controlla se l user esiste ritornando true
/*
- restituisce una stringa di errore se il login non e` andato a buon fine
* restituisce true se il login e` andato a buon fine
*/
function login(string $username, string $password)
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
        return sprintf("La password non e` corretta, riprova!");
    }
  }
  return sprintf("L` Utente %s non e` stato trovato" , $username);
}

// funzione che registra l` utente, aggiungendo un nuovo array dentro ad users array
function register(string $username, string $password)
{
  $usersJson = loadUsersFromJson();
  if(strlen($password) > 5) {
    return "Inserire una password piu` lunga!";
  }
  foreach ($usersJson as $user) {
    if($user["username"] === $username) {
      return "Username gia` esistente, prova con un altro!";
    }
  }

  $usersJson[] = [
    "username" => $username,
    "password" => $password
  ];

  file_put_contents("users.json", json_encode($usersJson));
  return true;
}


function printLog($message) {
  $message = $message . " \n";

  $logFile = fopen("logs.txt", "a+");

  fwrite($logFile, $message);

  fclose($logFile);

}

/**
@bool
*ritorna true se l`user e` loggato/autentificato*/
function userIsAuthenticated(): bool {
  return array_key_exists("username", $_SESSION);
}
