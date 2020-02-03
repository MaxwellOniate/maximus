<?php

require('../includes/config.php');

if (isset($_POST['artistID'])) {
  $artistID = $_POST['artistID'];

  $query = $con->prepare('SELECT * FROM artists WHERE id = :id');
  $query->execute([':id' => $artistID]);

  $resultArray = $query->fetch(PDO::FETCH_ASSOC);

  echo json_encode($resultArray);
}
