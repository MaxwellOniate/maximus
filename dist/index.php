<?php

$pageTitle = 'Home';

require('includes/config.php');

if (!isset($_SESSION["userLoggedIn"])) {
  header("Location: login.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];

?>

<?php require('includes/header.php'); ?>

<section id="main">
  <div class="top-container">

  </div>

  <div id="play-bar-container" class="fixed-bottom">
    <div class="play-bar">
      <div class="row">

        <div class="col-md-3">
          <div class="album">

            <img src="https://www.ft.com/__origami/service/image/v2/images/raw/https%3A%2F%2Fs3-ap-northeast-1.amazonaws.com%2Fpsh-ex-ftnikkei-3937bb4%2Fimages%2F6%2F7%2F0%2F4%2F19124076-2-eng-GB%2FCropped-1548822934RTX6JR3L.jpg?source=nar-cms" alt="album" class="album-art img-fluid">

            <div class="track-info">
              <span class="tack-name d-block">
                <span>Livin' Prince</span>
              </span>
              <span class="artist-name d-block">
                <span>M. Prince</span>
              </span>
            </div>

          </div>
        </div>

        <div class="col-md-6">
          <div class="player-controls">

            <div class="buttons">

              <button class="control-btn shuffle" title="Shuffle">
                <i class="fas fa-random"></i>
              </button>

              <button class="control-btn previous" title="Previous">
                <i class="fas fa-step-backward"></i>
              </button>

              <button class="control-btn play" title="Play">
                <i class="far fa-play-circle"></i>
              </button>

              <button class="control-btn pause d-none" title="Pause">
                <i class="far fa-pause-circle"></i>
              </button>

              <button class="control-btn next" title="Next">
                <i class="fas fa-step-forward"></i>
              </button>

              <button class="control-btn repeat" title="Repeat">
                <i class="fas fa-retweet"></i>
              </button>



            </div>

            <div class="playback-bar">
              <span class="progress-time current">0.00</span>
              <div class="bar">
                <div class="bar-bg">
                  <div class="bar-progress"></div>
                </div>
              </div>
              <span class="progress-time remaining">0.00</span>
            </div>

          </div>
        </div>

        <div class="col-md-3">
          <div class="volume">

            <button class="control-btn volume-btn" title="Volume">
              <i class="fas fa-volume-up"></i>
            </button>

            <div class="bar">
              <div class="bar-bg">
                <div class="bar-progress"></div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>


<?php require('includes/footer.php'); ?>