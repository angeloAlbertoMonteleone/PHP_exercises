<?php


/* funzione che aggiunge ad ogni login e logout dell utente, un messaggio nel file logs.txt(database accessi)*/
function printLog($message) {
  $message = $message . " \n";
  $path = $_SERVER["DOCUMENT_ROOT"];
  $absolutePath = sprintf("%s/websiteExPhp/logs.txt", $path);

  $logFile = fopen($absolutePath, "a+");

  fwrite($logFile, $message);

  fclose($logFile);

}
