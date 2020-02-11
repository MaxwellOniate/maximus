<?php

require('../includes/config.php');

if (isset($_POST['playlistID']) && isset($_POST['songID'])) {
  $playlistID = $_POST['playlistID'];
  $songID = $_POST['songID'];

  $query = $con->prepare("DELETE FROM playlist_songs WHERE playlistID = :playlistID AND songID = :songID");
  $query->execute([
    ':playlistID' => $playlistID,
    ':songID' => $songID
  ]);
} else {
  echo 'PlaylistID or songID was NOT passed into removeFromPlaylist.php';
}
