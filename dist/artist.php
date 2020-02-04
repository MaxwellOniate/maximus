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
  <div class="artist-info text-center">
    <h1 class="artist-name"><?php echo $artist->getName(); ?></h1>
    <button class="btn my-3">Play</button>
  </div>

</section>