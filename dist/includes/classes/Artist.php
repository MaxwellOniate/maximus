<?php


class Artist
{
  private $con;
  private $id;

  public function __construct($con, $id)
  {
    $this->con = $con;
    $this->id = $id;
  }

  public function getID()
  {
    return $this->id;
  }

  public function getName()
  {
    $query = $this->con->prepare('SELECT name FROM artists WHERE id = :id');
    $query->execute([
      ':id' => $this->id
    ]);
    $artist = $query->fetch(PDO::FETCH_ASSOC);

    return $artist['name'];
  }
  public function getSongIDs()
  {
    $query = $this->con->prepare('SELECT id FROM songs WHERE artist = :id ORDER BY plays DESC');
    $query->execute([':id' => $this->id]);

    $array = [];

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
      array_push($array, $row['id']);
    }

    return $array;
  }
}
