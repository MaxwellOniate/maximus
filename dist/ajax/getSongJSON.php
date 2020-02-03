<?php

require('../includes/config.php');

if (isset($_POST['songID'])) {
  $songID = $_POST['songID'];

  $query = $con->prepare('SELECT * FROM songs WHERE id = :id');
  $query->execute([':id' => $songID]);

  $resultArray = $query->fetch(PDO::FETCH_ASSOC);

  echo json_encode($resultArray);
}
