<?php

class User
{
  private $con;
  private $username;

  public function __construct($con, $username)
  {
    $this->con = $con;
    $this->username = $username;
  }

  public function getUsername()
  {
    return $this->username;
  }
  public function getEmail()
  {
    $query = $this->con->prepare("SELECT email FROM users WHERE username = :username");
    $query->execute([':username' => $this->username]);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    return $row['email'];
  }
  public function getFirstAndLastName()
  {
    $query = $this->con->prepare("SELECT CONCAT(firstName, ' ', lastName) as 'name' FROM users WHERE username = :username");
    $query->execute([':username' => $this->username]);
    $row = $query->fetch(PDO::FETCH_ASSOC);
    return $row['name'];
  }
}
