<?php

include('includes/includedFiles.php');

if (isset($_GET['term'])) {
  $term = urldecode($_GET['term']);
} else {
  $term = "";
}

?>



<section id="search" class="border-bottom border-light">

  <p class="lead">Search for an artist, album, or song.</p>
  <div class="form-group">
    <input type="text" class="form-control search-input" placeholder="Type here..." value="<?php echo $term; ?>" onfocus="this.selectionStart = this.selectionEnd = this.value.length">
  </div>

</section>

<script>
  $('.search-input').focus();
  $(function() {
    $('.search-input').keyup(function() {
      clearTimeout(timer);

      timer = setTimeout(function() {
        let val = $('.search-input').val();
        openPage('search.php?term=' + val);
      }, 500);
    });
  });
</script>

<?php if ($term == "") exit(); ?>

<div class="track-list-container border-bottom border-light">

  <h2 class="heading-md">Songs</h2>

  <ul class="track-list">
    <?php
    $query = $con->prepare("SELECT id FROM songs WHERE title LIKE CONCAT('%',:term, '%') LIMIT 10");
    $query->execute([':term' => $term]);

    if ($query->rowCount() == 0) {
      echo "<p class='noResults'>No songs found matching \"$term\"</p>";
    }

    $songArray = [];

    $i = 1;
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

      if ($i > 15) {
        break;
      }

      array_push($songArray, $row['id']);

      $albumSong = new Song($con, $row['id']);
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

            <div class='dropdown-menu'>
              <a role='link' tabindex='0'  class='dropdown-item' data-toggle='modal' data-target='#playlists-modal'>Add to Playlist</a>
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

    <div class="modal fade" id="playlists-modal" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Add to...</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <?php echo Playlist::getPlaylistsList($con, $userLoggedIn->getUsername()); ?>
          </div>
        </div>
      </div>
    </div>

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

<div class="artists-container border-bottom border-light">
  <h2 class="heading-md">Artists</h2>
  <?php

  $query = $con->prepare("SELECT id FROM artists WHERE name LIKE CONCAT('%', :term, '%')");
  $query->execute([':term' => $term]);

  if ($query->rowCount() == 0) {
    echo "<p class='noResults'>No artists found matching \"$term\"</p>";
  }

  while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $artistFound = new Artist($con, $row['id']);
    echo "
      <div role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getID() . "\")' class='search-result-row'>
       
          " . $artistFound->getName() . "
  
      </div>
    ";
  }


  ?>
</div>

<h2 class="heading-md">Albums</h2>
<div class="albums">
  <?php
  $query = $con->prepare("SELECT * FROM albums WHERE title LIKE CONCAT('%', :term, '%') LIMIT 10");
  $query->execute([':term' => $term]);

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

</div>


<?php
if ($query->rowCount() == 0) {
  echo "<p class='noResults'>No albums found matching \"$term\"</p>";
}
?>