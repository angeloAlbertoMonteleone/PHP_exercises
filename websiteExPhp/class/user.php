<?php
/**
 * classe che mi restituisce tutte le proprieta` dell` user
 */
class user
{

  private $username;
  private $password;
  // private $passwordalgorithm;

  public function __construct(string $username, string $password)
  {
    $this->username = $username;
    $this->password = $password;
    // $this->passwordalgorithm = $passwordalgorithm;
  }

  public function getUsername() {
    return $this->username;
  }

  public function getPassword() {
    return $this->password;
  }
  //
  // public function getPasswordAlgorithm() {
  //   return $this->passwordalgorithm;
  // }

  public function setCryptedPassword(string $cryptedPassword) {
    $this->password = $cryptedPassword;
  }
  //
  // public function setAlgorithm(string $algorithm) {
  //   $this->passwordalgorithm = $algorithm;
  // }


}
