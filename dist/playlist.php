<?php

require('includes/includedFiles.php');

if (isset($_GET['id'])) {
  $playlistID = $_GET['id'];
} else {
  header("Location:index.php");
}

$playlist = new Playlist($con, $playlistID);
$owner = new User($con, $playlist->getOwner());

?>

<section id="playlist">
  <div class="playlist-container">
    <div class="entity">
      <img src="assets/img/playlist.png" class="img-fluid playlist-img">
      <div class="entity-info">
        <h2><?php echo $playlist->getName(); ?></h2>
        <p>Playlist by <?php echo $playlist->getOwner(); ?></p>
        <p><?php echo $playlist->getNumberOfSongs(); ?> Songs</p>
        <button onclick="deletePlaylist('<?php echo $playlistID; ?>')" class="btn btn-main btn-alt">Delete Playlist</button>
      </div>
    </div>

    <div class="track-list-container">
      <ul class="track-list">
        <?php
        $songArray = $playlist->getSongIDs();
        $i = 1;
        foreach ($songArray as $songID) {
          $playlistSong = new Song($con, $songID);
          $songArtist = $playlistSong->getArtist();

          echo "
            <li onclick='setTrack(\"" . $playlistSong->getID() . "\", tempPlaylist, true)' role='link' tabindex='0' class='track-list-row'>
              <div class='left-section'>
                <div class='track-count'>
                  <i class='fas fa-play'></i>
                  <span class='track-number'>
                    $i
                  </span>
                </div>
                <div class='track-info'>
                  <span class='track-name'>"
            . $playlistSong->getTitle() .
            "</span>
                  <span class='artist-name'>"
            . $songArtist->getName() .
            "</span>
                </div>
              </div>
    
              <div class='right-section'>
                <div class='track-options'>
                  <i class='fas fa-ellipsis-h'></i>
                </div>
                <div class='track-duration'>
                  <span class='duration'>" . $playlistSong->getDuration() . "</span>
                </div>
              </div>
            </li>
          ";

          $i++;
        }
        ?>



        <script>
          if (typeof tempSongIDs == undefined) {
            let tempSongIDs = '<?php echo json_encode($songArray); ?>';
            tempPlaylist = JSON.parse(tempSongIDs);
          } else {
            tempSongIDs = '<?php echo json_encode($songArray); ?>';
            tempPlaylist = JSON.parse(tempSongIDs);
          }
        </script>
      </ul>
    </div>

  </div>

</section>