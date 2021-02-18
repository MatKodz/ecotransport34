<?php

if(isset($_GET['search']) && $_GET['search']) {

  header("Content-type: application/json");

  require("connection.php");

  $nomAgence = trim(strip_tags($_GET['search']));

  $nomAgence = "%" . $nomAgence . "%";

  $req = "SELECT a_nom FROM ec_agence WHERE a_nom LIKE :nom_agence ";
  $sth = $conn->prepare($req);
  $sth->bindValue(":nom_agence",$nomAgence,PDO::PARAM_STR);
  $sth->execute();
  $data = $sth->fetchAll(PDO::FETCH_COLUMN);
  echo json_encode($data);
}

else {

}


?>
