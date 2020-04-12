<?php

ob_start();
session_start();

$timezone = date_default_timezone_set("America/New_York");

$dsn = 'mysql:host=localhost;dbname=maximus';
$user = 'root';
$pass = '';

try {
  $con = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
  echo 'Connection Error: ' . $e;
}
