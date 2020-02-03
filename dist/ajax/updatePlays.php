<?php

require('../includes/config.php');

if (isset($_POST['songID'])) {
  $songID = $_POST['songID'];

  $query = $con->prepare('UPDATE songs SET plays = plays + 1 WHERE id = :id');
  $query->execute([':id' => $songID]);
}
