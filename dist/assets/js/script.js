let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let audioElement;
let mouseDown = false;
let currentIndex = 0;
let repeat = false;
let shuffle = false;

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
