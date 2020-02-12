<?php

class User
{
  private $con;
  private $username;
  private $sqlData;

  public function __construct($con, $username)
  {
    $this->con = $con;
    $this->username = $username;

    $query = $con->prepare("SELECT * FROM users WHERE username = :username");
    $query->execute([':username' => $username]);

    $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
  }

  public function getUsername()
  {
    return $this->username;
  }
  public function getFirstName()
  {
    return $this->sqlData['firstName'];
  }
  public function getLastName()
  {
    return $this->sqlData['lastName'];
  }
  public function getEmail()
  {
    return $this->sqlData['email'];
  }
}
