<?php

$pageTitle = 'Album';

require('includes/includedFiles.php');

if (isset($_GET['id'])) {
  $albumID = $_GET['id'];
} else {
  header("Location:index.php");
}

$album = new Album($con, $albumID);
$artist = $album->getArtist();

?>

<div class="entity">
  <img src="<?php echo $album->getArtworkPath(); ?>" alt="<?php echo $album->getTitle(); ?>" class="img-fluid">
  <div class="entity-info">
    <h2><?php echo $album->getTitle(); ?></h2>
    <p role="link" tabindex="0" onclick="openPage('artist.php?id=<?php echo $artist->getID(); ?>')">By <span><?php echo $artist->getName(); ?></span></p>
    <p><?php echo $album->getNumberOfSongs(); ?> Songs</p>
  </div>
</div>

<div class="track-list-container">
  <ul class="track-list">
    <?php
    $songArray = $album->getSongIDs();
    $i = 1;
    foreach ($songArray as $songID) {
      $albumSong = new Song($con, $songID);
      $albumArtist = $albumSong->getArtist();

      echo "
      <li class='track-list-row'>
        <div class='left-section'>
          <div class='track-count'>
            <i role='link' tabindex='0' onclick='setTrack(\"" . $albumSong->getID() . "\", tempPlaylist, true)' class='fas fa-play'></i>
            <span class='track-number'>
              $i
            </span>
          </div>
          <div class='track-info'>
            <span class='track-name'>"
        . $albumSong->getTitle() .
        "</span>
            <span class='artist-name'>"
        . $albumArtist->getName() .
        "</span>
          </div>
        </div>

        <div class='right-section'>
          <div class='track-options'>  
          
            <div class='dropdown'>

              <span role='link' tabindex='0' id='dropdownMenuButton' data-toggle='dropdown'>
                <i class='fas fa-ellipsis-h'></i>
              </span>

              <div class='dropdown-menu dropdown-menu-right'>
                <a role='link' tabindex='0'  class='dropdown-item' data-toggle='modal' data-target='#playlists-modal-" . $albumSong->getID() . "'>Add to Playlist</a>
              </div>

            </div>

          </div>

          <div class='modal fade' id='playlists-modal-" . $albumSong->getID() . "' role='dialog'>
            <div class='modal-dialog' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h3 class='modal-title'>Add to...</h3>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <input type='hidden' class='songID' value='" . $albumSong->getID() . "'>
                <div class='modal-body'>
                  " . Playlist::getPlaylistsList($con, $userLoggedIn->getUsername(), $albumSong->getID()) . "
                </div>
              </div>
            </div>
          </div>
          
      

          <div class='track-duration'>
            <span class='duration'>" . $albumSong->getDuration() . "</span>
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