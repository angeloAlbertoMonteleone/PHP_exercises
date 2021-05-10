<?php

/**
 *
 */
class DatabaseManager
{
  /**
  *@return $connection
  *funzione che fa una richiesta a mysql,e che ritorna una connessione PDO
  */
  public function getConnection() {
    try {
      $connection = new PDO('mysql:host=localhost;dbname=usersdb', "root", "root");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
    return $connection;
  }


  public function executeQuery($query) {
    $connection = $this->getConnection();

    try {
      $statement = $connection->query($query);
    } catch (\Exception $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
  }


}
