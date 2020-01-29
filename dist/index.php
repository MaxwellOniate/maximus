<?php

$pageTitle = 'Home';

require('includes/config.php');

if (!isset($_SESSION["userLoggedIn"])) {
  header("Location: login.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];

?>

<?php require('includes/header.php'); ?>



<?php require('includes/footer.php'); ?>