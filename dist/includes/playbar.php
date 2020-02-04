<?php

$query = $con->prepare('SELECT id FROM songs ORDER BY RAND() LIMIT 10');
$query->execute();

$resultArray = [];

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);

?>

<!-- BOTTOM PLAY BAR -->
<div id="play-bar-container" class="fixed-bottom">
  <div class="play-bar">
    <div class="row">

      <div class="col-md-3">
        <div class="album">

          <img src="" alt="" class="album-art img-fluid">

          <div class="track-info">
            <span class="track-name d-block">
              <span></span>
            </span>
            <span class="artist-name d-block">
              <span></span>
            </span>
          </div>

        </div>
      </div>

      <div class="col-md-6">
        <div class="player-controls">

          <div class="buttons">

            <button onclick="setShuffle()" class="control-btn shuffle" title="Shuffle">
              <i class="fas fa-random"></i>
            </button>

            <button onclick="previousSong()" class="control-btn previous" title="Previous">
              <i class="fas fa-step-backward"></i>
            </button>

            <button onclick="playSong()" class="control-btn play" title="Play">
              <i class="far fa-play-circle"></i>
            </button>

            <button onclick="pauseSong()" class="control-btn pause" title="Pause">
              <i class="far fa-pause-circle"></i>
            </button>

            <button onclick="nextSong()" class="control-btn next" title="Next">
              <i class="fas fa-step-forward"></i>
            </button>

            <button onclick="setRepeat()" class="control-btn repeat" title="Repeat">
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

          <button onclick="setMute()" class="control-btn volume-btn" title="Volume">
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

<script>
  $(document).ready(function() {
    let newPlaylist = <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeProgressBar(audioElement.audio);

    $("#play-bar-container").on("mousedown touchstart mousemove touchmove", function(e) {
      e.preventDefault();
    });

    $('.playback-bar .bar-bg').mousedown(function() {
      mouseDown = true;
    });

    $('.playback-bar .bar-bg').mousemove(function(e) {
      if (mouseDown) {
        timeFromOffset(e, this);
      }
    });

    $('.playback-bar .bar-bg').mouseup(function(e) {
      timeFromOffset(e, this);
    });

    $('.volume .bar-bg').mousedown(function() {
      mouseDown = true;
    });

    $('.volume .bar-bg').mousemove(function(e) {
      if (mouseDown) {
        let percentage = e.offsetX / $(this).width();
        if (percentage >= 0 && percentage <= 1) {
          audioElement.audio.volume = percentage;
        }
      }
    });

    $('.volume .bar-bg').mouseup(function(e) {
      let percentage = e.offsetX / $(this).width();
      if (percentage >= 0 && percentage <= 1) {
        audioElement.audio.volume = percentage;
      }
    });

    $(document).mouseup(function() {
      mouseDown = false;
    });

  });

  function timeFromOffset(mouse, progressBar) {
    let percentage = mouse.offsetX / $(progressBar).width() * 100;
    let seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds);
  }

  function previousSong() {
    if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
      audioElement.setTime(0);
    } else {
      currentIndex--;
      setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
  }

  function nextSong() {
    if (repeat) {
      audioElement.setTime(0);
      playSong();
      return;
    }

    if (currentIndex == currentPlaylist.length - 1) {
      currentIndex = 0;
    } else {
      currentIndex++;
    }

    let trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackToPlay, currentPlaylist, true);
  }

  function setShuffle() {
    shuffle = !shuffle;
    shuffle ? $('.control-btn.shuffle').addClass('active') : $('.control-btn.shuffle').removeClass('active');

    if (shuffle) {
      shuffleArray(shufflePlaylist);
      currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
    } else {
      currentIndex = currentlyPlaylist.indexOf(audioElement.currentlyPlaying.id);
    }
  }

  function shuffleArray(a) {
    let j, x, i;
    for (i = a.length; i; i--) {
      j = Math.floor(Math.random() * i);
      x = a[i - 1];
      a[i - 1] = a[j];
      a[j] = x;
    }
  }

  function setRepeat() {
    repeat = !repeat;
    repeat ? $('.control-btn.repeat').addClass('active') : $('.control-btn.repeat').removeClass('active');
  }

  function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    if (audioElement.audio.muted) {
      $('.control-btn.volume-btn i').removeClass('fas fa-volume-up');
      $('.control-btn.volume-btn i').addClass('fas fa-volume-mute');
    } else {
      $('.control-btn.volume-btn i').removeClass('fas fa-volume-mute');
      $('.control-btn.volume-btn i').addClass('fas fa-volume-up');
    }
  }

  function setTrack(trackID, newPlaylist, play) {

    if (newPlaylist != currentPlaylist) {
      currentPlaylist = newPlaylist;
      shufflePlaylist = currentPlaylist.slice();
      shuffleArray(shufflePlaylist);
    }

    if (shuffle) {
      currentIndex = shufflePlaylist.indexOf(trackID);
    } else {
      currentIndex = currentPlaylist.indexOf(trackID);
    }

    pauseSong();

    $.post("ajax/getSongJSON.php", {
      songID: trackID
    }, function(data) {

      let track = JSON.parse(data);

      $('.track-name span').text(track.title);

      $.post("ajax/getArtistJSON.php", {
        artistID: track.artist
      }, function(data) {
        let artist = JSON.parse(data);
        $('.artist-name span').text(artist.name);
      });

      $.post("ajax/getAlbumJSON.php", {
        albumID: track.album
      }, function(data) {
        let album = JSON.parse(data);
        $('img.album-art').attr('src', album.artworkPath);
        $('img.album-art').attr('alt', album.title);
      });

      audioElement.setTrack(track);

      if (play) {
        playSong();
      }
    });
  }

  function playSong() {
    if (audioElement.audio.currentTime == 0) {
      $.post('ajax/updatePlays.php', {
        songID: audioElement.currentlyPlaying.id
      });
    }
    audioElement.play();
    $(".play").hide();
    $(".pause").show();
  }

  function pauseSong() {
    audioElement.pause();
    $(".play").show();
    $(".pause").hide();

  }
</script>