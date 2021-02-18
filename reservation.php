<form method="POST">
  <input type="text" name="vehiculeid" value="" placeholder="Id Vehicule">
  <input type="text" name="agenceid" value="" placeholder="Id agence">
  <input type="date" name="dateloc" value="" placeholder="Une date">
  <input type="text" name="mailClient" value="" placeholder="Un mail">
  <input type="submit" name="" value="Réserver">
</form>
<?php


if(isset($_POST['vehiculeid']) && isset($_POST['agenceid']) && isset($_POST['dateloc']) && isset($_POST['mailClient']) && filter_var(trim($_POST['mailClient']), FILTER_VALIDATE_EMAIL) ) {

  require_once('connect.php');
  // la connexion est stockée dans une variable nommée $conn;

  $identifiantvehicule = $_POST['vehiculeid'];
  $identifiantagence = $_POST['agenceid'];
  $datedebut = $_POST['dateloc'];
  $mail_client = $_POST['mailClient'];
  $date_v = date_create($datedebut);
  $date_v = $date_v ? date_format($date_v,"d/m/Y") : 'Inconnu';

  $req_details = "SELECT a_nom, m_nom, m_vignette FROM flotte
  INNER JOIN agence ON flotte.agence_id = agence.a_id
  INNER JOIN materiel_roulant ON flotte.modele_id = materiel_roulant.m_id
  WHERE  v_id = ? ";

  $sth2 = $conn->prepare($req_details);
  $sth2->bindValue(1,$identifiantvehicule, PDO::PARAM_INT);
  $sth2->execute();
  $res2 = $sth2->fetchAll(PDO::FETCH_NUM);

  list($nomAgence, $nomModele, $vignetteModele) = $res2[0];

  echo "<div class=\"recap-resa\"><span>$nomModele</span><span>$nomAgence</span><span>" . $date_v . "</span></div>";

      $reqresa = "CALL reservation(?,?,?,?,@resa);";

      $sth = $conn->prepare($reqresa);
      $sth->bindValue(1,$identifiantvehicule, PDO::PARAM_INT);
      $sth->bindValue(2,$identifiantagence, PDO::PARAM_INT);
      $sth->bindValue(3,$datedebut);
      $sth->bindValue(4,$mail_client,PDO::PARAM_STR);
      $sth->execute();
      $sth->closeCursor();
      $resanum = $conn->query("SELECT @resa AS resanumber");
      $jeu = $resanum->fetch();

      if ($jeu['resanumber']) {

        $resaNumber = $jeu['resanumber'];

        echo '<p class="alert alert-success">Réservation confirmée</p>';

        echo "<h3>Numéro de réservation #$resaNumber </h3><p>Votre email : <small>$mail_client</small></p>";

        $sujet = "Booking #$resaNumber - Ecotransport34";

        $ladate = date("d/m/Y à H:i");

        $message = "<html><head><title>Réservation</title></head>
        <body><h2 style=\"color: limegreen; border-bottom: 5px dotted limegreen; font-size: 26px;\">Une nouvelle réservation a été effectuée sur Ecotransport 34</h2>
        <small style=\"color: grey;\">Réalisé le $ladate</small>
        <p> Réservation #$resaNumber pour un véhicule de type <strong><u>$nomModele</u></strong> à l'<i>$nomAgence</i> </p>
        <p> Date de location : $datedebut </p>
        <p> Réservation réalisée depuis l'IP : {$_SERVER['REMOTE_ADDR']}</p></body></html>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        $headers .=  'Bcc: mat@kodz.pro' . "\r\n"  . 'From: booking@ecotransport34.fr' . "\r\n" . 'Reply-To: booking@ecotransport34.fr' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

        mail($mail_client,$sujet,$message,$headers);

        $sth->closeCursor();

      }

      else echo '<p class="alert alert-danger">La réservation n\'a pas pu aboutir, le véhicule demandé n\'est plus disponible</p>';


    //echo "Votre réservation n'a pas pu aboutir. <a class=\"btn btn-primary btn-block\" href=\"./\">Recommencer</a>";



}

else echo "Vous devez sélectionner un modèle de véhicule et une agence. <a href=\"availability.php\">Retour à la page de réservation</a>";
