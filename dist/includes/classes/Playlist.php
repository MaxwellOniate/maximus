<?php

class Playlist
{
  private $con;
  private $id;
  private $name;
  private $owner;

  public function __construct($con, $data)
  {

    if (!is_array($data)) {
      $query = $con->prepare("SELECT * FROM playlists WHERE id = :data");
      $query->execute([':data' => $data]);
      $data = $query->fetch(PDO::FETCH_ASSOC);
    }

    $this->con = $con;
    $this->id = $data['id'];
    $this->name = $data['name'];
    $this->owner = $data['owner'];
  }

  public function getID()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getOwner()
  {
    return $this->owner;
  }

  public function getNumberOfSongs()
  {
    $query = $this->con->prepare("SELECT songID FROM playlist_songs WHERE playlistID = :id");
    $query->execute([':id' => $this->id]);

    return $query->rowCount();
  }

  public function getSongIDs()
  {
    $query = $this->con->prepare('SELECT songID FROM playlist_songs WHERE playlistID = :id ORDER BY playlistOrder ASC');
    $query->execute([':id' => $this->id]);

    $array = [];

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      array_push($array, $row['songID']);
    }

    return $array;
  }
}
