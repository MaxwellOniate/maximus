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

  <header class="heading-btn">
    <h1><?php echo $artist->getName(); ?></h1>
    <button onclick="playFirstSong()" class="btn btn-main">Play</button>
  </header>


  <div class="track-list-container border-bottom border-light">

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