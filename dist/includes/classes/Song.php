<?php

class Song
{
  private $con;
  private $id;
  private $data;
  private $title;
  private $artistID;
  private $albumID;
  private $genre;
  private $duration;
  private $path;

  public function __construct($con, $id)
  {
    $this->con = $con;
    $this->id = $id;

    $query = $this->con->prepare('SELECT * FROM songs WHERE id = :id');
    $query->execute([':id' => $this->id]);

    $this->data = $query->fetch(PDO::FETCH_ASSOC);
    $this->title = $this->data['title'];
    $this->artistID = $this->data['artist'];
    $this->albumID = $this->data['album'];
    $this->genre = $this->data['genre'];
    $this->duration = $this->data['duration'];
    $this->path = $this->data['path'];
  }

  public function getID()
  {
    return $this->id;
  }
  public function getTitle()
  {
    return $this->title;
  }
  public function getArtist()
  {
    return new Artist($this->con, $this->artistID);
  }
  public function getAlbum()
  {
    return new Album($this->con, $this->albumID);
  }
  public function getPath()
  {
    return $this->path;
  }
  public function getDuration()
  {
    return $this->duration;
  }
  public function getGenre()
  {
    return $this->genre;
  }
  public function getData()
  {
    return $this->data;
  }
}
