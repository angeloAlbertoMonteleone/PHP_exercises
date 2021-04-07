<?php


/* funzione che aggiunge ad ogni login e logout dell utente, un messaggio nel file logs.txt(database accessi)*/
function printLog($message) {
  $message = $message . " \n";

  $logFile = fopen("logs.txt", "a+");

  fwrite($logFile, $message);

  fclose($logFile);

}
