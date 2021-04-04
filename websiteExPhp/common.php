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


// controlla se l user esiste ritornando true
function login($username,$password):bool
{
  $users = loadUsers();
  foreach ($users as $user) {
    $currentUser = $user[0];
    $currentPassword = $user[1];

    if($username === $currentUser && $password === $currentPassword) {
      return true;
    }
  }
  return false;
}


/**
@bool
*ritorna true se l`user e` loggato/autentificato*/
function userIsAuthenticated(): bool {
  return array_key_exists("username", $_SESSION);
}
