<?php

/**
 *
 */
class DatabaseManager
{

  private $connection;
  /**
  *@return $connection
  *funzione che fa una richiesta a mysql,e che ritorna una connessione PDO
  */
  public function getConnection() {
    if($this->connection === null) {
      try {
        $connection = new PDO('mysql:host=localhost;dbname=posts', "root", "root");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
      }
      $this->connection = $connection;
    }
      return $this->connection;
  }




  /**
  *@return array
  *@param array $params
  *funzione che fa una connessione PDO,e che esegue una query ritornando un obj
  */
  public function (string $query, array $params = []): array
  {
    $connection = $this->getConnection();

     try {
         $statement = $connection->prepare($query);
         $statement->execute($params);
     } catch (PDOException $exception) {
         echo "Error!: " . $exception->getMessage();
         die();
     }

     return $statement->fetchAll(PDO::FETCH_ASSOC);
}



  /**
   * Esegue una query senza restituire un risultato
   * @param string $query
   * @param array $params
   */
public function executeQuery(string $query, array $params = []): void
    {
        $connection = $this->getConnection();

        try {
            $statement = $connection->prepare($query);
            $statement->execute($params);
        } catch (PDOException $exception) {
            echo "Error!: " . $exception->getMessage();
            die();
        }
    }



}
