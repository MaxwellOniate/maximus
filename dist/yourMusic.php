<?php

require('includes/includedFiles.php');

?>

<section id="your-music">
  <div class="your-music-container">

    <header class="heading-btn">
      <h1>Playlists</h1>
      <button onclick="createPlaylist()" class="btn btn-main">New Playlist</button>
    </header>

    <div class="albums">
      <?php
      $username = $userLoggedIn->getUsername();

      $query = $con->prepare("SELECT * FROM playlists WHERE owner = :username ");
      $query->execute([':username' => $username]);

      if ($query->rowCount() == 0) {
        echo "<span class='noResults'>No playlists found.</span>";
      }

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

        $playlist = new Playlist($con, $row);

        echo "
        <div onclick='openPage(\"playlist.php?id=" . $playlist->getID() . "\")' role='link' tabindex='0' class='album'>
            <img src='assets/img/playlist.png' class='img-fluid playlist-img'>

          <div class='album-info'>" . $playlist->getName() . "</div>
        </div>   
      ";
      }

      ?>

    </div>

  </div>
</section>