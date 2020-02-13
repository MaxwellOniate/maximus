<?php

ob_start();
session_start();

$timezone = date_default_timezone_set("America/New_York");

$dsn = 'mysql:host=us-cdbr-iron-east-04.cleardb.net;dbname=heroku_4b028710cc60dae';
$user = 'baff4a82d1b1d0';
$pass = '7b9a79ae';

try {
  $con = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
  echo 'Connection Error: ' . $e;
}
