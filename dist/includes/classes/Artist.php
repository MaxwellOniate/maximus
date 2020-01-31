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

  public function getName()
  {
    $query = $this->con->prepare('SELECT name FROM artists WHERE id = :id');
    $query->execute([
      ':id' => $this->id
    ]);
    $artist = $query->fetch(PDO::FETCH_ASSOC);

    return $artist['name'];
  }
}
