<?php

require('includes/config.php');
require('includes/classes/Artist.php');
require('includes/classes/Album.php');
require('includes/classes/Song.php');

if (isset($_SESSION["userLoggedIn"])) {
  $userLoggedIn = $_SESSION["userLoggedIn"];
  echo "<script>let userLoggedIn = '$userLoggedIn'</script>";
} else {
  header("Location: login.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Maximus</title>
  <script src="https://kit.fontawesome.com/52d1564875.js" crossorigin="anonymous"></script>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>
  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/main.css">

</head>

<body>

  <section id="main">

    <div class="top-container">

      <?php include("includes/sideNav.php"); ?>

      <div id="main-view-container">
        <div id="main-content">