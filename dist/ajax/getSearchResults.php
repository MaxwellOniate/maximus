<?php

require('../includes/config.php');

$query = $con->prepare("SELECT id FROM songs WHERE title LIKE :term LIMIT 10");
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
