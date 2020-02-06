<?php

require('../includes/config.php');

if (isset($_POST['playlistID'])) {

  $playlistID = $_POST['playlistID'];

  $query = $con->prepare("DELETE FROM playlists WHERE id = :id");
  $query->execute([':id' => $playlistID]);

  $query2 = $con->prepare("DELETE FROM playlist_songs WHERE playlistID = :id");
  $query2->execute([':id' => $playlistID]);
} else {
  echo "playlistID was not passed into deletePlaylist.php";
}
