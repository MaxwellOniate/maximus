<?php


require('includes/includedFiles.php');

?>


<h1 class="page-heading">You Might Also Like</h1>

<div class="albums">

  <?php
  $query = $con->prepare('SELECT * FROM albums ORDER BY RAND() LIMIT 10');
  $query->execute();

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