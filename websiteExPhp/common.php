<?php

session_start();

require_once("./class/userAuthentication.php");

require_once("utilities.php");

// nuovo oggetto instanziato dentro la classe userAuthentication
$uthenticationProvider = new userAuthentication();








/*esempio per restituisce l array di tutti gli utenti leggendo il file csv
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
*/
