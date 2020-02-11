let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let audioElement;
let mouseDown = false;
let currentIndex = 0;
let repeat = false;
let shuffle = false;
let timer;

$(document).on('change', '.form-check-input', function() {
  let playlistID = $(this).val();
  let songID = $(this)
    .parents('.modal-body')
    .prev('.songID')
    .val();

  $.post('ajax/addToPlaylist.php', {
    playlistID: playlistID,
    songID: songID
  }).done();
});

function removeFromPlaylist(playlistID, songID) {
  $.post('ajax/removeFromPlaylist.php', {
    playlistID: playlistID,
    songID: songID
  }).done(function() {
    openPage('playlist.php?id=' + playlistID);
  });
}

function openPage(url) {
  if (timer != null) {
    clearTimeout(timer);
  }

  if (url.indexOf('?') == -1) {
    url += '?';
  }

  let encodedURL = encodeURI(url + '&userLoggedIn=' + userLoggedIn);

  $('#main-content').load(encodedURL);

  $('body').scrollTop(0);

  history.pushState(null, null, url);
}

function createPlaylist() {
  let playlistName = prompt('Enter the playlist name.');

  if (playlistName != '') {
    $.post('ajax/createPlaylist.php', {
      name: playlistName,
      username: userLoggedIn
    }).done(function() {
      openPage('yourMusic.php');
    });
  } else {
    alert('No name entered!');
  }
}

function deletePlaylist(playlistID) {
  let prompt = confirm('Are you sure you want to delete this playlist?');

  if (prompt) {
    $.post('ajax/deletePlaylist.php', {
      playlistID: playlistID,
      username: userLoggedIn
    }).done(function() {
      openPage('yourMusic.php');
    });
  }
}

function formatTime(seconds) {
  let time = Math.round(seconds);
  let minutes = Math.floor(time / 60);
  seconds = time - minutes * 60;
  let extraZero = seconds < 10 ? '0' : '';
  return minutes + ':' + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
  $('.progress-time.current').text(formatTime(audio.currentTime));
  $('.progress-time.remaining').text(
    formatTime(audio.duration - audio.currentTime)
  );
  let progress = (audio.currentTime / audio.duration) * 100;
  $('.playback-bar .bar-progress').css('width', progress + '%');
}

function updateVolumeProgressBar(audio) {
  let volume = audio.volume * 100;
  $('.volume .bar-progress').css('width', volume + '%');
}

function playFirstSong() {
  setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {
  this.currentlyPlaying;
  this.audio = document.createElement('audio');

  this.audio.addEventListener('ended', function() {
    nextSong();
  });

  this.audio.addEventListener('canplay', function() {
    let duration = formatTime(this.duration);
    $('.progress-time.remaining').text(duration);
  });

  this.audio.addEventListener('timeupdate', function() {
    if (this.duration) {
      updateTimeProgressBar(this);
    }
  });

  this.audio.addEventListener('volumechange', function() {
    updateVolumeProgressBar(this);
  });

  this.setTrack = function(track) {
    this.currentlyPlaying = track;
    this.audio.src = track.path;
  };
  this.play = function() {
    this.audio.play();
  };
  this.pause = function() {
    this.audio.pause();
  };
  this.setTime = function(seconds) {
    this.audio.currentTime = seconds;
  };
}
