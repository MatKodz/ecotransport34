<?php

include("header.php");
// on vérifie que le paramètre idagency existe
if( isset($_GET['idagency']) && is_numeric($_GET['idagency']) ) {
  $requete = "SELECT f_id, m_titre FROM ec_flotte INNER JOIN ec_modele ON ec_flotte.f_fk_modele = ec_modele.m_id   WHERE f_fk_agence = ? ";
  // le ? correspond à l'id de l'agence sur laquelle on a cliqué
  require("connection.php");
  $sth = $conn->prepare($requete);
  $sth->execute(array($_GET['idagency']));
  // on execute la requête en utilisant la valeur du paramètre idagency
  $jeu = $sth->fetchAll();






  echo "<ul>";
  foreach ($jeu as $vehicule) {
    echo "<li>" . $vehicule['f_id'] . " - " .  $vehicule['m_titre'] .  "</li>";
  }
  echo "</ul>";
  $conn = null;
}

else echo "Aucune agence ne correspond";

include("footer.php");

?>
