
// vérifier que votre fichier est bien chargée

alert("Mon fichier est bien chargée dans la page"); // ligne à supprimer une fois la vérification faite

let agenceName = document.querySelector("#agenceLibelle").value; // récupère la valeur saisie dans le champ

if ( agenceName.trim() == "" )
 {
   alert("Le champ du libellé de l'agence n'est pas rempli");
 }

// si cette valeur est vide (on se débarasse des espaces éventuelles, on vérifie que l'utilisateur a saisi qq chose


if( ) {
  document.getElementById("creerAgence").setAttribute("disabled",false)
}

// si tous les champs sont remplis, activer le bouton valider
