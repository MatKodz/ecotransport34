<?php

include("header.php"); // à créer


$requete = "SELECT a_id, a_nom, a_adresse FROM ec_agence";

require("connection.php");

foreach ($conn->query($requete) as $agence) {
echo "<div><a href=\"agency-detail.php?idagency={$agence['a_id']}\">". $agence['a_nom'] . "-" . $agence['a_adresse'] . "</a><a class=\"btn btn-success mx-2\" href=\"agency-update.php?idagency={$agence['a_id']}\">Modifier agence </a><hr></div>";

}

// renvoie un jeu de résultats en s'appuyant sur la $conn et en éxécutant la requête SQL $req
// pour chaque ligne de résultats, j'affiche la valeur de la colonne qui se nomme dans la base de données 'colonne_1_nom_agence'

// On peut aussi procéder par étape , le résultat est le même

$sth = $conn->query($requete);
$jeu = $sth->fetchAll();
foreach($jeu as $agence) {
  // ...
}

// $jeu contient un tableau PHP avec toutes les entrées correspondant au jeu de résultats de la requête

$conn = null; // permet de fermer la connection à la bdd

?>

Rechercher une agence
<input type="text" name="" value="" placeholder="3 lettres" id="searchAgency">
<input type="button" name="" value="Chercher" id="launchSearch">
<div id="agencesRecherchees">
</div>

<script>
let urlBase = "agency-search.php";
let url;
let listeAgences = document.querySelector("#agencesRecherchees");

let options = {method : 'GET', headers : {'Content-Type': 'application/json'}};
let agencyValue;

document.querySelector("#searchAgency").onkeydown = function () {
  agencyValue = document.querySelector("#searchAgency").value;
}
document.querySelector("#launchSearch").onclick = function () {
  if (agencyValue.length > 2 )
  { url = urlBase +  "?search=" + agencyValue;
    fetch(url,options)
    .then(data =>  data.json() )
    .then(d => {
      let agences = "";
      d.forEach( element =>
        agences += "<p>" + element + "</p>"
      )
      console.log({agences})
      listeAgences.innerHTML = agences ? agences : "Aucune agence trouvée";
    })
  }  //console.log(d))
}
</script>


<?php

include("footer.php"); // à créer


?>
