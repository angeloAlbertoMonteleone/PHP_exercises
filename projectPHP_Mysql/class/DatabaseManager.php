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
      $connection = new PDO('mysql:host=localhost;dbname=posts', "root", "root");
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
    return $connection;
  }


  /**
  *@return array
  *@param array $params
  *funzione che fa una connessione PDO,e che esegue una query ritornando un obj
  */
  public function executeQuery(string $query, array $params = []): array
  {

    $connection = $this->getConnection();

    try {
      $statement = $connection->prepare($query);
      $statement->execute($params);
    } catch (\Exception $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die;
    }

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

}
