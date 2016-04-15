<?php include("CROSL.php");/* ce bout de code me permet d'afficher ma page d'acceuil */
        try{
// On se connecte à MySQL
$bdd = new PDO('mysql:host=localhost;dbname=facturation;charset=utf8', 'root', '');
} catch(Exception $e) {
// En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}
// On récupère tout le contenu de la table ligue
$rep = $bdd->query('SELECT nomlig FROM ligue');

// On affiche chaque entrée une à une
while ($donnes = $rep->fetch()){
$tab[] = $donnes['nomlig'];
}

function liste_deroulant2($tableau) {

  foreach ($tableau  as $element) {
    # code...
  
  echo "<option value=".$element.">".$element."</option>";
}

}

// On récupère tout le contenu de la table ligue
$reponse = $bdd->query('SELECT dateFact FROM facture ');
$trouver = 0;
// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch()){
  $val = $donnees['dateFact'];
  $annee = substr("$val", -4);
  if (!$trouver) {
    $tableau2[] = $annee;
     $trouver = 1;
  }
  
}

$reponse->closeCursor(); // Termine le traitement de la requête


function liste_deroulant($tableau) {

    foreach ($tableau  as $element) {
        echo $element;
    
  echo "<option value=".$element.">".$element."</option>";
}

}
for ($i=1; $i <=12 ; $i++) { 
   $tableau3[$i] = $i;
 }

 ?> 

 <!DOCTYPE html>
<html>
    <head>

        <!-- En-tête de la page -->
        <meta charset="utf-8" />
    <link rel="stylesheet" href="styles.css" />
        <title> Facture</title>
     </head>
<body> 
      <div id="ContactForm">

 <form method="post" action="Generer_pdf.php" target="_blank">
 <h1>Obtenir Une FACTURE</h1><br/>

     <label for="nomlig" > Code Client</label>
          <select name="nomlig" id="nomlig">

      <?php liste_deroulant($tab); ?>   
               
      </select><br/><br/>

      <label for="annee"> Année</label>
      <select name="annee" id="annee">
             <?php liste_deroulant($tableau2); ?>   <!-- l'identifiant du client --> 
            </select><br/><br/>
      <label for="mois"> Mois</label>
      <select name="mois" id="mois">
             <?php liste_deroulant($tableau3); ?>   <!-- l'identifiant du client --> 
            </select><br/><br/>

      <input type="submit" value="ouvrir pdf"/>
      </form>

</div>
       
  </body>
</html>﻿