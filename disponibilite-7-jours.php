<?php

include("header.php");

?>


        <div class="container" id="agence-selectionnee">

      <?php
      if (isset($_GET['agence']) and $_GET['agence'])

      {
      require_once('connect.php');
      // la connexion est stockée dans une variable nommée $conn;
      $agenceselectionnee = $_GET['agence'];

      $agencedetails = "SELECT * FROM agence WHERE a_id = ?";
      $ag = $conn->prepare($agencedetails);
      $ag->execute(array($_GET['agence']));
      $agenceinfo = $ag->fetch();
      if($agenceinfo) {

      //print_r($agenceinfo);
        echo '<div class="agencechoisie py-3">';
        echo  '<h3 id="agence_selectionnee" data-id-agence="'.$agenceinfo['a_id'].'">'.$agenceinfo['a_nom'].'</h3>';
        echo  '<p>';
        $open = unserialize($agenceinfo['a_ouverture']);
        foreach ($open as $key => $value) {
          echo "<span>".$key . " : ". $value."</span>";
        }
        echo '</p>';
        echo  '<p><a href="#">'.$agenceinfo['a_email'].'</a></p>';
        echo '</div>';
        }
        else echo "Aucune agence trouvée";
      }

      else {
        require_once('connect.php');
        ?>
        <form class="" action="" method="get">
          <div class="row py-5">
          <div class="col-sm">
          <select class="agence" name="agence">
            <option value="">Choisir une agence</option>
            <?php
            $requeteagence = "SELECT DISTINCT a_nom, a_id FROM agence ORDER BY a_nom";
            foreach ($conn->query($requeteagence) as $agence) {
            echo "<option value=\"".$agence['a_id']."\">".$agence['a_nom']."</option>";
            }
            ?>
          </select>
        </div>
        </div>
      <input type="submit" name="envoyer" class="btn btn-success btn-block my-3" value="Rechercher">
    </form>
    <?php
      }
      ?>

    </div>

    <div class="container">

    <div class="row">


    <?php

    $req_dispo = 'SELECT l_debut FROM location WHERE l_debut >= DATE(NOW()) and l_id_vehicule = ?';

    $startdate = date("");

    $sreq= "SELECT * FROM materiel_roulant INNER JOIN flotte ON materiel_roulant.m_id = flotte.modele_id WHERE agence_id = ?";

    $smth = $conn->prepare($sreq);
    //$smth->execute(array($agenceselectionnee));
    $smth->bindParam(1,$agenceselectionnee,PDO::PARAM_INT);
    $smth->execute();
    $data = $smth->fetchAll();

    foreach ($data as $vehicule) {

      echo '<div class="col-xs-12 col-sm-6">';
      echo '<div class="vehicule">';
      echo '<article>';

      echo '<h3 class="d-flex align-items-center"><img class="mr-sm-4" src="'.$vehicule['m_vignette'].'" alt="">'. $vehicule['m_nom'] . '</h3>';

      echo '<div class="caracteristiques-vehicule">';
      echo "<div class=\"btn btn-outline-success\">Autonomie: ". $vehicule['m_autonomie'] ."h</div>
      <div class=\"btn btn-outline-secondary\">". $vehicule['m_nbroue'] ." roues</div>";
      $electrique = ($vehicule['m_electrique'] == "oui") ? "Electrique" : "Manuel";
      echo "<span class=\"btn btn-outline-primary\">". $electrique ."</span>
      <span class=\"btn btn-outline-secondary\">".  $vehicule['m_prix_location_jour'] ."€/jour</span>";
      echo "</div>";
        echo '<div class="disponibilite"><h4>Disponibilités</h4>';
        $sth = $conn->prepare($req_dispo);
        $sth->execute(array($vehicule['v_id']));
        $jeu= $sth->fetchAll();
        $no = [];
        foreach ($jeu as $indispo) {
          $no[] = $indispo[0];
        }
        setlocale(LC_TIME, 'fr_FR.utf8','fra'); // FR
        //echo strftime($startdate,"%A");
      for ($i = 0; $i < 7; $i++)
      { $ladatef = strftime( "%a <span class=\"btn-month\"> %d </span>%b" , strtotime("$startdate +$i days"));
        $ladate = date("Y-m-d",strtotime("$startdate +$i days")) ;
        if (in_array($ladate,$no))
        echo "<button class=\"btn btn-light\" disabled>". $ladatef ."</button>";
        else
        echo "<button class=\"btn btn-success reserver\" data-date-selected=\"".$ladate."\" data-vehicule-id=\"".$vehicule['v_id']."\" data-vehicule-modele=\"".$vehicule['m_nom']."\">". $ladatef."</button>";
      }
        echo "</div>";
    echo "</div></div></article>";
  //echo "</div>";
    }


    ?>
  </div>
  </div>

        <?php

          // $conn = null;
    ?>

<div id="modal-reservation">
  <div class="inner-reservation">
  <div class="reservation">
    <button class="close-resa">[ X ]</button>
    <div class="choix_user">
      <div class="d-flex recap-ve-ag justify-content-between align-items-baseline"><h2></h2><p id="agse"></p></div>
      <div class="my-4">
        <label for="userEmail">Renseigner vos informations </label>
        <input id="userEmail" type="mail" placeholder="Votre email" class="w-100">
      </div>
      <button class="btn btn-light btn-block" id="reservation" disabled>Réserver</button>
    </div>
    <hr>
    <button id="close" class="btn btn-light btn-block">ANNULER</button>
  </div>
</div>
</div>
<script>
$( function() {
  $("#close").click( function () {
    $("#modal-reservation").hide();
    $(".choix_user h2, .choix_user a, .choix_user #agse").text("");
    datechoisie = "";
    vid = "";
    aid = "";

  });
  $(".close-resa").on('click', function () {
    $("#close").trigger("click");
    $("#modal-reservation .inner-reservation").removeClass("show");
   });
  $(".reserver").click( function () {
    datechoisie = $( this ).attr("data-date-selected");
    $("#modal-reservation").show(0, function () {
      $(this).children().addClass("show");
    });
    $("#agse").text ( $("#agence_selectionnee").text() );
    datef = $ ( this ).text();
    $("#userEmail").on('change', function() {
      let userMailCheck = $(this).val().trim();
      if ( userMailCheck && /\S+@\S+\.\S+/.test(userMailCheck) ) {
        $(this).addClass("mail-valid");
        mailValidate = true; userMail = userMailCheck;
          $("#reservation").attr("disabled",false).removeClass("btn-light").addClass("btn-success")
      } else {
        $("#userEmail").addClass("mail-failed").toggleClass("mail-valid",false);
        mailValidate = false;
        $("#reservation").attr("disabled",true).removeClass("btn-success")
      }
    })
    $("#modal-reservation .reservation .choix_user button#reservation").text('Réserver le ' + datef );
    var nom =  $( this). attr("data-vehicule-modele");
    $("#modal-reservation .reservation .choix_user h2").text(nom);
    vid = $( this). attr("data-vehicule-id");
    aid = $("#agence_selectionnee"). attr("data-id-agence");
  });
  $("#reservation").one("click", function() {
    if (vid && aid && datechoisie && mailValidate)
    {
      $.ajax({
        url : "reserver.php",
        method : "post",
        data : {vehiculeid : vid, agenceid : aid, dateloc : datechoisie, mailClient : userMail},
        success: function(result) {
          $("#reservation").removeClass("btn-dark").addClass("btn-success").text("Réservé le " + datef);
          $("#reservation").after("<p class=\"my-2 text-center\">" + result + "</p>");
          $("#close").hide();
          $(".reservation").append('<a class="btn btn-primary btn-block" href="./">Nouvelle réservation</a>');
          $("#reservation").off("click").delay(2000).slideUp();
        }
      });
    }
    else $("#userEmail").toggleClass("mail-failed");
  });

})

</script>
<?php include('footer.php'); ?>
