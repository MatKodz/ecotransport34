<?php

include("header.php");

if(isset($_POST['chercher'])) {
  // je vérifie  que le formulaire a été cliqué
  if ( $_POST['bookingNumber'] && $_POST['usedEmail']) {
    // je vérifie que les champs ne sont pas vides
    $num_booking = strip_tags(trim($_POST['bookingNumber']));
    $mail_client = strip_tags(trim($_POST['usedEmail']));
    $req = "SELECT l_id, l_debut, l_id_vehicule, a_nom, m_nom FROM location L
    INNER JOIN flotte F ON F.v_id = L.l_id_vehicule
    INNER JOIN materiel_roulant M ON M.m_id = F.modele_id
    INNER JOIN agence A ON A.a_id = L.l_id_agence
    WHERE l_id = :locationId and l_user_mail = :userEmail LIMIT 1";
    // j'écris la requête qui permet 1. de trouver si une location correspond (WHERE) , 2. les détails de la location (INNER JOIN)
    require_once("connect.php");
    $sth = $conn->prepare($req);
    $sth->bindValue(":locationId",$num_booking, PDO::PARAM_INT);
    $sth->bindValue(":userEmail",$mail_client, PDO::PARAM_STR);
    $sth->execute();
    if($sth->rowCount()) {
      // SI $sth-rowCount() != 0, donc si il existe des résultats, donc une location correspondante, j'affiche les détails
      $resa = $sth->fetch(PDO::FETCH_ASSOC);
      $recap = "<h5>La réservation #{$resa['l_id']} </h5>";
      $date_resa = date_create($resa['l_debut']);
      $recap .= "<span>" . $resa['m_nom'] . " </span><span> " . $resa['a_nom'] . " </span><span> " . date_format($date_resa,"d/m/Y") . "</span>";
    }
    else $msg =  "Aucune réservation trouvée avec #$num_booking | Email - $mail_client ";
    // SINON j'indique à l'utilisateur qu'il n'y a pas de résa correspondant

  }
  else $msg =  "Renseigner les champs";
  }


?>

<div class="container">
  <h2 class="highlight"> Consulter votre réservation</h2>
  <div class="row">
    <div class="col-12">
      <form class="" action="" method="post">
        <div class="row my-3">
          <div class="col-sm-6">
            <label>Votre numéro de réservation : </label>
              <input class="p-2" type="text" name="bookingNumber" value="" placeholder="Référence">
          </div>
          <div class="col-sm-6">
            <label>Votre adresse mail : </label>
              <input class="p-2" type="mail" name="usedEmail" value="" placeholder="Email">
          </div>
          <div class="col-12 my-5">
            <input type="submit" name="chercher" value="Rechercher" class="btn btn-success w-100">
          </div>
        </div>
      </form>
      <?php echo isset($msg) ? '<p class="alert alert-warning">' . $msg . '</p>' : "" ; ?>
      <?php echo isset($recap) ? '<div class="recap-resa">' . $recap  . '</div>': "" ;
      // affichage des messages d'erreur ou détails de la location en fonction
      ?>
    </div>
  </div>
</div>


<?php

include("footer.php");

/* ############ Question 5 , expliquer ce que fait la requête  ######## */

/* Affiche le numéro de réservation, la date de début de location, la date de création de la location
, le mail de l'utilisateur rattaché à cette location, le nom de l'agence auquel est rattaché le véhicule concerné, le libellé du modèle de véhicule
Il s'agit de la liste du détail des réservations des 7 PROCHAINS JOURS ordonnées par date de début de location de la plus proche à la plus éloignée */

?>
