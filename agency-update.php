<?php

if(isset($_GET['idagency']) && is_numeric($_GET['idagency'])) {

  // on vérifie que le paramètre idagency existe

  $idagence = $_GET['idagency'];

  require("connection.php");

  if(isset($_POST['modifierAgence'])) {
    $requete_maj = "UPDATE ec_agence SET a_nom = ?, a_tel = ? WHERE a_id = ?";
    $stmt = $conn->prepare($requete_maj);
    if ($stmt->execute(array($_POST['nomAgence'],$_POST['telAgence'],$idagence)))
    $msg = "<b>Modification prise en compte</b>";
  }


  $requete = "SELECT * FROM ec_agence WHERE a_id = ? ";
  // le ? correspond à l'id de l'agence sur laquelle on a cliqué


  $sth = $conn->prepare($requete);
  $sth->execute(array($_GET['idagency']));
  // on execute la requête en utilisant la valeur du paramètre idagency
  $agence_details = $sth->fetchAll(PDO::FETCH_ASSOC);
  $rows = $sth->rowCount();

  $conn = null;
}


include("header.php");


  if(isset($rows) && $rows) {
  // on retrouve dans $jeu des données qui correspondent aux caractéristiques de l'agence, on affiche ces données dans des champs de formulaire
  ?>

  <form action="" method="post">
    <div><label>Nom agence : </label><input type="text" name="nomAgence" value="<?php echo $agence_details[0]['a_nom']; ?>"></div>
    <div><label>Tel Agence : </label><input type="text" name="telAgence" value="<?php echo $agence_details[0]['a_tel']; ?>"></div>
    <!-- Compléter avec les autres champs nécessaires -->
    <input type="submit" name="modifierAgence" value="Modifier les informations">
  </form>

  <p>Dernière modif le : <?php echo $agence_details[0]['a_updated']; ?></p>
  <p><?php echo isset($msg) ? $msg : ""; ?></p>
  <?php
}

else echo "Aucune agence renseignée ou agence inconnue";

//else echo "Aucune agence renseignée";

include("footer.php");

?>
