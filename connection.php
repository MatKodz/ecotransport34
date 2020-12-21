<?php
try {
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $mydbname = 'mabasededonnees';
    $mycharset = "utf8";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$mydbname;charset=$mycharset", $dbuser, $dbpass);
    echo "<h2> La connexion a été établie</h2>"; // ligne à supprimer avoir  vérifié l'intégrité de la connexion
}
catch (PDOException $e) {
 echo "Error!: " . $e->getMessage() . "<br/>";
 die();
 }

 // le bloc try tente une connexion à la base de données, en cas d'échec c'est le bloc catch qui est exécuté, en affichant l'erreur et en stoppant l'éxecution des scripts qui suivent
?>
