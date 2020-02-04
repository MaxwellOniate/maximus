<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
  require('includes/config.php');
  require('includes/classes/Artist.php');
  require('includes/classes/Album.php');
  require('includes/classes/Song.php');
} else {
  require("includes/header.php");
  require("includes/footer.php");

  $url = $_SERVER['REQUEST_URI'];
  echo "<script>openPage('$url')</script>";
  exit();
}
