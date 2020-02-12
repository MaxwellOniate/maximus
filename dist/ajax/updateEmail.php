<?php

require('../includes/config.php');

if (!isset($_POST['username'])) {
  echo 'Error: Could NOT set username!';
  exit();
}
