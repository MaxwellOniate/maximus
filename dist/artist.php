<?php

include('includes/includedFiles.php');

if (isset($_GET['id'])) {
  $artistID = $_GET['id'];
} else {
  header('Location: index.php');
}

$artist = new Artist($con, $artistID);

?>

<section id="artist">

  <div class="text-center pb-3">
    <h1><?php echo $artist->getName(); ?></h1>
    <button onclick="playFirstSong()" class="btn my-3">Play</button>
  </div>


  <div class="track-list-container vertical-borders">

    <h2 class="heading-md">Popular</h2>

    <ul class="track-list">
      <?php
      $songArray = $artist->getSongIDs();
      $i = 1;
      foreach ($songArray as $songID) {

        if ($i > 5) {
          break;
        }

        $albumSong = new Song($con, $songID);
        $albumArtist = $albumSong->getArtist();

        echo "
        <li onclick='setTrack(\"" . $albumSong->getID() . "\", tempPlaylist, true)' class='track-list-row' role='link' tabindex='0'>
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

  <h2 class="heading-md">Albums</h2>
  <div class="albums">
    <?php
    $query = $con->prepare('SELECT * FROM albums WHERE artist = :id');
    $query->execute([':id' => $artistID]);

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      echo "

      <div class='album'>
        <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
          <img src='" . $row['artworkPath'] . " ' alt='" . $row['title'] . "' class='img-fluid'>

          <div class='album-info'>" . $row['title'] . "</div>
        </span>

      </div>
    
    ";
    }

    ?>

</section>