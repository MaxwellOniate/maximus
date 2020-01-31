<?php

require('includes/config.php');
require('includes/classes/Artist.php');
require('includes/classes/Album.php');
require('includes/classes/Song.php');

if (!isset($_SESSION["userLoggedIn"])) {
  header("Location: login.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Maximus | <?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>

  <section id="main">

    <div class="top-container">

      <?php include("includes/sideNav.php"); ?>

      <div id="main-view-container">
        <div id="main-content">