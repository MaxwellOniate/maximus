<?php

include('includes/includedFiles.php');

if (isset($_GET['term'])) {
  $term = urldecode($_GET['term']);
} else {
  $term = "";
}

?>



<section id="search">

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

<div class="track-list-container vertical-borders">

  <h2 class="heading-md">Songs</h2>

  <ul class="track-list">
    <?php
    $query = $con->prepare("SELECT id FROM songs WHERE title LIKE CONCAT('%',:term, '%') LIMIT 10");
    $query->execute([':term' => $term]);

    if ($query->rowCount() == 0) {
      echo "<span class='noResults'>No songs found matching \"$term\"</span>";
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

<div class="artists-container">
  <h2 class="heading-md">Artists</h2>
  <?php

  $query = $con->prepare("SELECT id FROM artists WHERE name LIKE CONCAT('%', :term, '%')");
  $query->execute([':term' => $term]);

  if ($query->rowCount() == 0) {
    echo "<span class='noResults'>No artists found matching \"$term\"</span>";
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

<div class="vertical-borders">
  <h2 class="heading-md">Albums</h2>
  <div class="albums pb-5">
    <?php
    $query = $con->prepare("SELECT * FROM albums WHERE title LIKE CONCAT('%', :term, '%') LIMIT 10");
    $query->execute([':term' => $term]);


    if ($query->rowCount() == 0) {
      echo "<span class='noResults'>No albums found matching \"$term\"</span>";
    }

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