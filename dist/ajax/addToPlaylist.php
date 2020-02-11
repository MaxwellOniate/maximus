<?php

require('../includes/config.php');

if (isset($_POST['playlistID']) && isset($_POST['songID'])) {
  $playlistID = $_POST['playlistID'];
  $songID = $_POST['songID'];

  $query = $con->prepare("SELECT IFNULL(MAX(playlistOrder) + 1, 1) as playlistOrder FROM playlist_songs WHERE playlistID = :playlistID");
  $query->execute([':playlistID' => $playlistID]);

  $row = $query->fetch(PDO::FETCH_ASSOC);
  $order = $row['playlistOrder'];

  $query2 = $con->prepare("INSERT INTO playlist_songs (songID, playlistID, playlistOrder) VALUES(:songID, :playlistID, :order)");
  $query2->execute([
    ':songID' => $songID,
    ':playlistID' => $playlistID,
    ':order' => $order
  ]);
} else {
  echo 'PlaylistID or songID was NOT passed into addToPlaylist.php';
}
