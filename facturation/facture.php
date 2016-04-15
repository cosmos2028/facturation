
	<?php
try{
// On se connecte à MySQL
$bdd = new PDO('mysql:host=localhost;dbname=facturation;charset=utf8', 'root', '');
} catch(Exception $e) {
// En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}

// On récupère tout le contenu de la table ligue
$reponse = $bdd->query('SELECT codePresta FROM prestation');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch()){
$tableau[] = $donnees['codePresta'];   
}
$reponse->closeCursor(); // Termine le traitement de la requête

// On récupère tout le contenu de la table ligue
$rep = $bdd->query('SELECT nomlig FROM ligue');

// On affiche chaque entrée une à une
while ($donnes = $rep->fetch()){
$tab[] = $donnes['nomlig'];
}

function liste_deroulant($tableau) {

	foreach ($tableau  as $element) {
		# code...
	
  echo "<option value=".$element.">".$element."</option>";
}

}

?>
        <?php include("CROSL.php"); ?> <!-- ce bout de code me permet d'afficher ma page d'acceuil -->


<!DOCTYPE html>
<html>
    <head>

        <!-- En-tête de la page -->
        <meta charset="utf-8" />
		<link rel="stylesheet" href="styles.css" />
    <!-- Inclure la librairie Jquery -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <title>Nouvelle Facture</title>
    </head>
<body> 
      
      <div id="ContactForm">
  
          <h1>Nouvelle Facture</h1><br/>
          <label for="compte_ligue" > Code Client</label>
          <select name="compte_ligue" id="compte_ligue">

      <?php liste_deroulant($tab); ?>   
               
      </select><br/><br/>
      <form method="post" action="traitement_facture.php" target="_blank">



      <fieldset style="width:390px;">
      <legend>Prestation</legend>

     
      <label for="code_presta">Code prestation</label>
      <select name="code_presta" id="code_presta">

      <?php liste_deroulant($tableau); ?>   
               
      </select><br/><br/>

      <label for="qte"> quantité</label>
      <input type="number" name="qte" id="qte" />
      <input autocomplete="off" type="button" onclick="ajouterLigne();" value="Ajouter" />
      

      <table id="tableau" name="tableau" >
      <thead>
      <tr>
      <th>code prestation</th>
      <th>quantité</th>
      <th>Supprimer</th>
      </tr>
      </thead>

      <tbody>

      </tbody>

      </table>

      </fieldset><br/><br/>

      <input type="button" value="Enregister" id="enregistre"/>

      <div class="form_result"> </div>
 
      </form>
</div>

<!-- 2. Mettre toujours les script avant la fermeture du body -->
<!-- Inclure la librairie Jquery -->
    <script src="http://code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
    <!-- Plugin pour la conversion JSON -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-json/2.5.1/jquery.json.min.js" type="text/javascript"></script>  
<script>

// fonction qui sert à supprimer la ligne courante du tableau
function supprimerLigne(num){
document.getElementById("tableau").deleteRow(num);
}
// fonction qui sert à ajouter une ligne à la fin du tableau

function ajouterLigne(){
  /* ceci est un sélecteur jquery $("#code_presta") qui récupère id # 
ayant pour nom code_presta 
le .val() est une fonction jquery pour récupérer la valeur de l'attribut value d'un input */
var codePresta = $("#code_presta").val();
/* idem pour qte */
var qte = $("#qte").val();

/* ici le sélecteur jquery pointe sur id tableau puis le tbody donc tout le tbody du tableau */

var tableau = $("#tableau tbody");
/* la variable ligne constitue le code html qui sera ajouter */
var ligne = "<tr>";
ligne += "<td>"+codePresta+"</td>";
ligne += "<td>"+qte+"</td>";
ligne += '<td><input type="button" value="supprimer" onclick="supprimerLigne(this.parentNode.parentNode.rowIndex);"/></td>';
ligne += "</tr>";
/* ici tableau correspond au tbody du tableau ayant pour id tableau
la fonction append de jquery permet d'ajouter du contenu à suite du tableau dans notre cas
le contenu ajouter et stocker dans la variable ligne qui est passer en paramètre de la fonction append */
tableau.append(ligne);
}

// ici on a un écouteur d’événement sur le click pour l'élément ayant pour id enregistre

$("#enregistre").click(function(e) {
  // la variable form a comme type un Objet

var form = new Object();
// la variable tabLigne a comme type un Tableau

var tabLigne = new Array();
form.compteLigue = $("#compte_ligue").val();
/* pour un objet on ajoute des propriété par un point et le nom de celle-ci
ici notre objet et form auquel je lui ajoute la propriété compteLigue avec la syntaxe form.compteLigue
et cette propriété aura comme valeur $("#compte_ligue").val() soit id compte_ligue qui est un input dont je récupère la valeur avec .val()
    form.compteLigue = $("#compte_ligue").val();

/* le $.each() et une fonction jquery qui boucle les éléments passé en premier paramètre soit 
    $("#tableau tbody tr") qui correspond a tout le tr contenu dans le tbody du tableau ayant pour id tableau
    le deuxième paramètre et une fonction anonyme donc n'ayant pas de nom */  
$.each( $("#tableau tbody tr"), function( ) {
  // dans la fonction anonyme je créer un objet temporaire qui sera détruit une fois la fonction terminée

var ligne = new Object();
/* A cette objet ligne j'ajoute une propriété codePresta qui a pour valeur 
$(this) représente l'élément en cours soit le tr et la fonction .children() récupère tout les enfant de l'élément en cours 
soit ici tout le td du tr en cours car $(this) correspond au tr et children() a tout le td dans ce tr
la fonction .eq(0) sert a prendre un élément particulier de tout les td ici le paramètre 0 correspond au premier td
enfin la fonction .text() permet de récupérer le texte dans se td */
ligne.codePresta = $(this).children().eq(0).text();
/* même chose que pour code codePresta sauf que le eq(1) correspond au deuxième td  
      ligne.qte = $(this).children().eq(1).text();
// Enfin j'ajoute a mon tableau tabLigne via la fonction push() la variable ligne qui est un objet avec 2 propriété (codePresta et qte)
      tabLigne.push(ligne);
// Comme on est dans une boucle a chaque tour on ajoute au tableau tabLigne chaque tr avec leur 2 td pour (codePresta et qte)
    });

// ici j'ajoute une propriété lignes à mon objet form qui contient tout mon tableau tabLigne qui contient chaque tr avec leur 2 td
    form.lignes = tabLigne;

    /* Pour débogage sert a afficher l'objet form dans la console */
ligne.qte = $(this).children().eq(1).text();
tabLigne.push(ligne);
});
form.lignes = tabLigne;
/* la variable json va contenir via le plugin "jquery.json.min.js" une représentation complète de notre objet form */

var json = $.toJSON(form);

// étant toujours sur l’événement click du bouton enregistrer
// ici $.post est une fonction jjquery pour faire de l'ajax sur la méthode post
// le premier paramètre correspond au fichier
// le second est un objet déclarer en live via {} le data et la propriété de cette objet et form est sa valeur au format json
// coté PHP on devra analyse la valeur data dans la variable $_POST avec $_POST['data']
// la fonction always sert au retour du résultat envoyer au fichier le paramètre html correspond au echo fait dans le fichier php
$.post("traitement_facture.php",{data:json}).always(function(html){
  
      // code si retour du post en html
// ici je sélectionne la balise body auquel je lui ajoute avec append() le retour du code contenu dans le paramètre html
            // code si retour du post en html
             $('#ContactForm').find('.form_result').html(html);
        });
});

</script>

  </body>
</html>﻿