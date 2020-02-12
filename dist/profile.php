<?php

require('includes/includedFiles.php');

?>

<section id="profile">
  <header class="heading-btn">
    <h1><?php echo $userLoggedIn->getFirstName() . " " . $userLoggedIn->getLastName(); ?></h1>
    <button onclick="openPage('updateDetails.php')" class="btn btn-main btn-alt m-2">User Details</button>
    <a href='logout.php' class="btn btn-main btn-alt m-2">Log Out</a>
  </header>

</section>