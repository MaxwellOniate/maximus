<?php

require('../includes/config.php');

if (isset($_POST['albumID'])) {
  $albumID = $_POST['albumID'];

  $query = $con->prepare('SELECT * FROM albums WHERE id = :id');
  $query->execute([':id' => $albumID]);

  $resultArray = $query->fetch(PDO::FETCH_ASSOC);

  echo json_encode($resultArray);
}
