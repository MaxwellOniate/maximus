<?php

class Album
{
  private $con;
  private $id;
  private $title;
  private $artistID;
  private $genre;
  private $artworkPath;

  public function __construct($con, $id)
  {
    $this->con = $con;
    $this->id = $id;

    $query = $this->con->prepare('SELECT * FROM albums WHERE id = :id');
    $query->execute([':id' => $this->id]);
    $album = $query->fetch(PDO::FETCH_ASSOC);

    $this->title = $album['title'];
    $this->artistID = $album['artist'];
    $this->genre = $album['genre'];
    $this->artworkPath = $album['artworkPath'];
  }

  public function getTitle()
  {
    return $this->title;
  }
  public function getArtworkPath()
  {
    return $this->artworkPath;
  }
  public function getArtist()
  {
    return new Artist($this->con, $this->artistID);
  }
  public function getGenre()
  {
    return $this->genre;
  }
  public function getNumberOfSongs()
  {
    $query = $this->con->prepare('SELECT id FROM songs WHERE album = :id');
    $query->execute([':id' => $this->id]);

    return $query->rowCount();
  }
  public function getSongIDs()
  {
    $query = $this->con->prepare('SELECT id FROM songs WHERE album = :id ORDER BY albumOrder ASC');
    $query->execute([':id' => $this->id]);

    $array = [];

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      array_push($array, $row['id']);
    }

    return $array;
  }
}
