<?php

function checkthedate($x) {
    return ( date('Y-m-d', strtotime($x)) == $x && $x >= date("Y-m-d"));
}

include("header.php");
?>

    <div class="container my-4">
            <form class="" action="" method="get">
              <div class="row">
                <div class="col-sm">
              <input type="date" name="s_date" value="<?php echo (isset($_GET['s_date'])) ? $_GET['s_date'] : "";?>" class="ladate">
              </div>
              <div class="col-sm">
              <select class="agence" name="s_agence">
                <option value="">Choisir une agence</option>
                <?php
                $requeteagence = "SELECT DISTINCT a_nom, a_id FROM agence ORDER BY a_nom";
                require_once('connect.php');
                // la connexion est stockée dans une variable nommée $conn;
                foreach ($conn->query($requeteagence) as $agence) {
                $selectionne = ( isset($_GET['s_agence']) && $_GET['s_agence'] == $agence['a_id'] ) ? "selected" : "";
                echo "<option $selectionne value=\"".$agence['a_id']."\">".$agence['a_nom']."</option>";
                }
                ?>
              </select>
            </div>
            </div>
          <input type="submit" name="envoyer" class="btn btn-success btn-block my-3" value="Rechercher">
        </form>
    </div>


      <?php
      $requetechercher = "SELECT a_id, a_nom, m_nom, m_vignette,m_autonomie,m_nbroue,m_prix_location_jour, m_electrique,v_id, IF(v_id NOT IN (SELECT l_id_vehicule FROM location WHERE l_debut = ?),'dispo','indispo') AS DISPONIBILITE FROM flotte
      INNER JOIN agence ON flotte.agence_id = agence.a_id
      INNER JOIN materiel_roulant ON flotte.modele_id = materiel_roulant.m_id
      WHERE  a_id = ?
      ORDER BY DISPONIBILITE";


      if (isset($_GET['s_date']) and isset($_GET['s_agence']) && $_GET['s_date'] && $_GET['s_agence'] && checkthedate(trim($_GET['s_date'])) )

      {



      echo '<div class="container">';
      $agencedetails = "SELECT * FROm agence WHERE a_id = ?";
      $ag = $conn->prepare($agencedetails);
      $ag->execute(array($_GET['s_agence']));
      $agenceinfo = $ag->fetch();
      //print_r($agenceinfo);
        echo '<div class="agencechoisie py-3">';
        echo  '<h3>'.$agenceinfo['a_nom'].'</h3>';
        echo  '<p>';
        $open = unserialize($agenceinfo['a_ouverture']);
        foreach ($open as $key => $value) {
          echo "<span>".$key . " : ". $value."</span>";
        }
        echo '</p>';
        echo  '<p><a href="#">'.$agenceinfo['a_email'].'</a></p>';
        echo '</div>';

      echo '<form action="reserver.php" method="post">';
      echo (isset($_GET['s_date'])) ? '<input type="hidden" name="dateloc" value="'.$_GET['s_date'].'">' : "";
      echo '<div class="row vehicules">';


      $smth = $conn->prepare($requetechercher);
      $smth->bindValue(1,trim($_GET['s_date']),PDO::PARAM_STR);
      $smth->bindValue(2,$_GET['s_agence'],PDO::PARAM_STR);
      $smth->execute();
      $donnees = $smth->fetchAll();


      foreach ($donnees as $vehicule) {
        echo '<div class="col-xs-12 col-sm-6">';
        if($vehicule['DISPONIBILITE'] == "dispo")
          echo '<input type="radio" name="vehiculeid" value="'.$vehicule['v_id'].'" id="vehicule-'.$vehicule['v_id'].'">';
          echo '<label for="vehicule-'.$vehicule['v_id'].'" class="'.$vehicule['DISPONIBILITE'].'"><div class="row vehicule">';
          echo '<div class="col-xs-12 col-sm-4"><img src="'.$vehicule['m_vignette'].'" alt=""></div>';
          echo '<div class="col-xs-12 col-sm-8">
          <h3>'. $vehicule['m_nom'] . '</h3>
          <div class="caracteristiques-vehicule">';
          echo "<div class=\"btn btn-outline-success\">Autonomie: ". $vehicule['m_autonomie'] ."h</div>
          <div class=\"btn btn-outline-secondary\">". $vehicule['m_nbroue'] ." roues</div>";
          $electrique = ($vehicule['m_electrique'] == "oui") ? "Electrique" : "Manuel";
          echo "<span class=\"btn btn-outline-primary\">". $electrique ."</span>
          <span class=\"btn btn-outline-secondary\">".  $vehicule['m_prix_location_jour'] ."€/jour</span>";
          echo "</div></div>";

      echo "</div></label></div>";
      }

      echo '</div>';
      echo '<input type="hidden" name="agenceid" value="'.$donnees[0]['a_id'].'">';
      echo '<div class="text-center"><label>Votre email : </label> <input type="mail" name="mailClient" value="" placeholder="Renseigner votre email" class="w-50 p-2"></div>';
      echo '<input type="submit" name="reserver" class="btn btn-success btn-block my-3" value="Réserver">
      </form></div>';
    }

      else echo '<div class="container">
                <p class="alert alert-warning"> Vous devez sélectionner une date et une agence en respectant le format aaaa-mm-jj et pour une date supérieure ou égale à la date du jour</p>
                </div>';

    include('footer.php');


?>
