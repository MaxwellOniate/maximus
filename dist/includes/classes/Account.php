<?php

class Account
{
  private $con;
  private $errorArray = [];

  public function __construct($con)
  {
    $this->con = $con;
  }

  public function login($un, $pw)
  {
    $pw = hash('sha512', $pw);

    $query = $this->con->prepare('SELECT * FROM users WHERE username = :un AND password = :pw');

    $query->execute([
      ':un' => $un,
      ':pw' => $pw
    ]);

    if ($query->rowCount() == 1) {
      return true;
    }

    array_push($this->errorArray, Constants::$loginFailed);
    return false;
  }

  public function register($un, $fn, $ln, $em, $em2, $pw, $pw2)
  {
    $this->validateUsername($un);
    $this->validateFirstName($fn);
    $this->validateLastName($ln);
    $this->validateEmails($em, $em2);
    $this->validatePasswords($pw, $pw2);

    if (empty($this->errorArray)) {
      return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
    }

    return false;
  }

  private function insertUserDetails($un, $fn, $ln, $em, $pw)
  {
    $pw = hash('sha512', $pw);
    $profilePic = "assets/img/profile-pics/head_emerald.png";

    $query = $this->con->prepare("INSERT INTO users (username, firstName, lastName, email, password, profilePic) VALUES (:un, :fn, :ln, :em, :pw, :pp)");

    return $query->execute([
      ':un' => $un,
      ':fn' => $fn,
      ':ln' => $ln,
      ':em' => $em,
      ':pw' => $pw,
      ':pp' => $profilePic
    ]);
  }

  public function getInputValue($name)
  {
    if (isset($_POST[$name])) {
      echo $_POST[$name];
    }
  }

  public function validateUsername($un)
  {
    if (strlen($un) < 2 || strlen($un) > 25) {
      array_push($this->errorArray, Constants::$usernameCharacters);
      return;
    }

    $query = $this->con->prepare('SELECT * FROM users WHERE username = :un');

    $query->execute([':un' => $un]);

    if ($query->rowCount() != 0) {
      array_push($this->erroryArray, Constants::$usernameTaken);
    }
  }

  public function validateFirstName($fn)
  {
    if (strlen($fn) < 2 || strlen($fn) > 25) {
      array_push($this->errorArray, Constants::$firstNameCharacters);
    }
  }

  public function validateLastName($ln)
  {
    if (strlen($ln) < 2 || strlen($ln) > 25) {
      array_push($this->errorArray, Constants::$lastNameCharacters);
    }
  }

  public function validateEmails($em, $em2)
  {
    if ($em != $em2) {
      array_push($this->errorArray, Constants::$emailsDontMatch);
      return;
    }

    if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
      array_push($this->errorArray, Constants::$emailInvalid);
      return;
    }

    $query = $this->con->prepare('SELECT * FROM users WHERE email = :em');

    $query->execute([':em' => $em]);

    if ($query->rowCount() != 0) {
      array_push($this->errorArray, Constants::$emailTaken);
    }
  }

  public function validatePasswords($pw, $pw2)
  {
    if ($pw != $pw2) {
      array_push($this->errorArray, Constants::$passwordsDontMatch);
      return;
    }

    if (strlen($pw) < 8 || strlen($pw) > 99) {
      array_push($this->errorArray, Constants::$passwordLength);
    }
  }

  public function getError($error)
  {
    if (in_array($error, $this->errorArray)) {
      return "<span class='errorMessage'>$error</span>";
    }
  }
}
