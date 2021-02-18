<?php

include("header.php");

?>

<form action="" method="post" id="AgencyCreate">
  <input type="text" name="agenceName" value="" placeholder="Saisir un nom d'agence">
  <input type="text" name="agenceAdresse" value="" placeholder="Saisir une adresse ">
  <input type="text" name="agenceHoraires" value="" placeholder="Saisir un horaire">
  <input type="text" name="agenceTel" value="" placeholder="Saisir un téléphone">
  <input type="text" name="agenceMail" value="" placeholder="Saisir mail">
  <!-- à compléter avec les autres champs-->
  <input type="submit" id="creerAgence" name="envoyer" value="Créer une agence">
</form>

<?php





if (isset($_POST['envoyer'])) {
  $erreurform = false;
  foreach ($_POST as $value) {
    if(trim($value)) {

    }
    else $erreurform = true;
  }
  // if ( $_POST['agenceName'] != "" && $_POST['agenceAdresse'] != "" )
  if ( $erreurform == false )
  {
    $req = "INSERT INTO ec_agence VALUES (NULL,:agence_nom,:agence_adresse,:agence_horaire,:agence_email,:agence_telephone,DEFAULT) ";
    require("connection.php");
    $sth = $conn->prepare($req);
    $sth->bindValue(":agence_nom",$_POST['agenceName'],PDO::PARAM_STR);
    $sth->bindValue(":agence_adresse",$_POST['agenceAdresse'],PDO::PARAM_STR);
    $sth->bindValue(":agence_horaire",$_POST['agenceHoraires'],PDO::PARAM_STR);
    $sth->bindValue(":agence_telephone",$_POST['agenceTel'],PDO::PARAM_INT);
    $sth->bindValue(":agence_email",$_POST['agenceMail'],PDO::PARAM_STR);
    if ( $sth->execute() ) {
      echo "Insertion effective dans la BDD";
    }
    $conn = null;
  }
  else echo "Formulaire incomplet";
}

?>

<script>

let form = document.querySelector("#AgencyCreate");
form.onsubmit = function (event) {
  let erreur = false; // erreur initialisée à faux
  for (const elt of form.elements) {
    if(!elt.value.trim()) {
      elt.classList.add("fail")
      // on vérifie que chaque élément n'est pas vide
      erreur = true
    }
    else elt.classList.remove("fail")
  }
  if(erreur == true) {
    event.preventDefault();
    // le formulaire n'est pas validé si une erreur est rencontrée
  }

}

</script>

<?php

include("footer.php");

?>
