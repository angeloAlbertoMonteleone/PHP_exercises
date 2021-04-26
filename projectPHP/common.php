<?php

session_start();

require_once("../class/userAuthentication.php");
require_once("../class/post.php");
require_once("../class/blogManager.php");
require_once("utilities.php");

// nuovo oggetto instanziato dentro la classe userAuthentication
$authenticationProvider = new userAuthentication();
$blogManager = new blogManager();



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
