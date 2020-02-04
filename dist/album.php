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
    <p>By <?php echo $artist->getName(); ?></p>
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
        <li onclick='setTrack(\"" . $albumSong->getID() . "\", tempPlaylist, true)' role='link' tabindex='0' class='track-list-row'>
          <div class='left-section'>
            <div class='track-count'>
              <i class='fas fa-play'></i>
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
              <i class='fas fa-ellipsis-h'></i>
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
      let tempSongIDs = '<?php echo json_encode($songArray); ?>';
      tempPlaylist = JSON.parse(tempSongIDs);
    </script>
  </ul>
</div>