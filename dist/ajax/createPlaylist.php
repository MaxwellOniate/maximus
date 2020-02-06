<?php

require('../includes/config.php');

if (isset($_POST['name']) && isset($_POST['username'])) {
  $name = $_POST['name'];
  $username = $_POST['username'];
  $date = date('Y-m-d');

  $query = $con->prepare("INSERT INTO playlists (name, owner, dateCreated) VALUES(:name, :username, :date)");
  $query->execute([
    ':name' => $name,
    ':username' => $username,
    ':date' => $date
  ]);
} else {
  echo "Name or username parameters not passed into file.";
}
