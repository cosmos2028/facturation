
<?php  
/* connection a la base de donnée*/
  if( isset($_POST['nomlig']) && isset($_POST['annee']) && isset($_POST['mois']) ) {
   try
                {
                    $bdd = new PDO('mysql:host=localhost;dbname=facturation;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
    /* cette fonction me permet d'ajouter les differentes prestations du client*/
   function ligne_facture($donnees ){
   $Montant = $donnees['qte'] * $donnees['puPresta'];
?>

          <tr >
          <td style="width:25%;">  <?php echo $donnees['nomPresta'];?> </td>
          <td style="width:25%;"> <?php echo $donnees['qte'];?> </td>
          <td style="width:25%;"> <?php echo $donnees['puPresta'];?>  €</td>
          <td style="width:25%;"> <?php echo $Montant ;?>  €</td>
          </tr>
<?PHP
      }
?>

<?PHP 
  /* l'ouverture du pdf commenece ici*/
    ob_start(); 

?>
<!-- forcer le tableau à avoir 100% de la marge et espace de haut à 6mm--> 
<style type="text/css">
  table { width: 100%; line-height: 6mm;}

</style>
    <!-- je fournis les proprietes à la page telle que mes tableau doivent etre espace de 20mm en hauteur,10mm à gauche  et en bas et en fin je 
    pagine la page avec le footer--> 
    <page backtop = "20mm" backleft ="10mm" backright ="10mm" backbottom = "30mm" footer="page">
    <!-- on a ici les informations de l'organisation--> 
    <table style="vertical-align:top ;">
        <tr>
        <td style="width:75%;" class="exclure"><strong> Maison Régionale des Sports de Lorraine </strong><br/>    
        <strong>AD</strong>  13 rue jean Moulin <br/>
        <strong>BP</strong> 70001<br/>
        <strong>Siret </strong>31740105700029<br/>
        <strong>Tél</strong> 03.83.18.87.02<br/>
        <strong>Fax </strong>03.83.18.87.03
         </td>     
<?php
      /* je recupere les informations des clients grace à une jointure sur la table facture et ligue*/
           $nomligg = $_POST['nomlig'];
        $reponse = $bdd->query("SELECT numCompte,nomlig,nomtres,rue,cp,ville FROM ligue 
        WHERE  nomlig = '$nomligg' ");

    // On affiche chaque entrée une à une
        while ($donnees = $reponse->fetch() )
    {
              $numComptebd =$donnees['numCompte'];
?>
        <td style="width:25%;" class="exclure"><strong> Ligue Lorraine <?php echo $donnees['nomlig']; ?></strong><br /> 
        A l'attention de <?php echo $donnees['nomtres'];?><br/>
        <?php echo $donnees['rue'];?> 
        <?php echo  $donnees['cp'];?>
        <?php echo  $donnees['ville'];?>
<?php  
    }
        $reponse->closeCursor(); // Termine le traitement de la requête
?>
         </td>
           
      </tr>
     
      </table> <br/><br/><br/><br/>
<?php /* ici on recupere les données de la table facture pour les afficher */
        $repNumFact = $bdd->query("SELECT numFact  FROM LIGUE,FACTURE 
        WHERE  LIGUE.numCompte=FACTURE.numCompte and LIGUE.nomlig = '$nomligg'");

        // On affiche chaque entrée une à une
        while ($donnesNumFact = $repNumFact->fetch()){

        $vaal = $donnesNumFact['numFact'];
       $rest = substr("$vaal", -1);
       if ($rest == $_POST['mois']) {
          $val = $donnesNumFact['numFact'];
        } 
        
        }
        echo $val;
        $reponse = $bdd->query("SELECT * FROM facture
        WHERE  numFact = '$val' ");

    // On affiche chaque entrée une à une
        while ($donnees = $reponse->fetch() )
    { 
       $valFact = $donnees['dateFact'];
       $annee = substr("$valFact", -4);
       $numdonFact = $donnees['numFact'];
       $rest = substr("$numdonFact", -1); 
       echo $rest;
       echo $annee;
       echo $numComptebd;
      if ($annee == $_POST['annee'] && $_POST['mois']==$rest && $numComptebd == $donnees['numCompte'] ) {
        
      
?>
      <table >
       
      <tr ><strong>
           <td style="width:25%;" class="txtcenter">Numero Facture</td>
           <td style="width:25%;"class="txtcenter">Code Client</td>
           <td style="width:25%;">Date Emise</td>
           <td style="width:25%;">Echeance</td>
      </strong>
      </tr>
      <tr >
           <td style="width:25%;">  <?php echo $donnees['numFact'];?>  </td>
           <td style="width:25%;"> <?php echo $donnees['numCompte'];?>  </td>
           <td style="width:25%;"> <?php echo $donnees['dateFact'];?> </td>
           <td style="width:25%;"> <?php echo $donnees['echeance'];?> </td>
      </tr>
      </table><br/><br/><br/><br/>
<?php  
    }
      $reponse->closeCursor(); // Termine le traitement de la requête
      /* grace à une jointure on recupere les differentes prestation du client*/
      $reponse = $bdd->query("SELECT nomPresta,puPresta,qte FROM ligne_facture,prestation 
      WHERE  ligne_facture.numFact = '$val' AND ligne_facture.codePresta = prestation.codePresta");
?>
      <!-- un peu de css pour structurer les informations du clients dans un tableau--> 
      <table border="5px;" border-collapse= "collapse;" margin="0px;"padding= "0px;"border=" none;"cellspacing="0;"text-align="center;"vertical-align="middle" >
      <tr>
      <strong >
            <td style="width:25%;"> Désignation</td>
            <td style="width:25%;"> Quantité</td>
            <td style="width:25%;"> Prix Unitaire HT</td>
            <td style="width:25%;"> Montant TTC</td>
      </strong>
      </tr>
<?php
/* initialisation des variable*/
      $somme=0;
      $Montant=0;
    // On affiche chaque entrée une à une
      while ($donnees = $reponse->fetch() )
    {          /* on effectue le produit pour le montant et la somme pour le montant total*/
           $Montant = $donnees['qte'] * $donnees['puPresta'];
           $somme= $somme + $Montant;

      ligne_facture($donnees) ;
    }
?>
      </table><br/><br/>
      <table align="right">
      <tr>
      <strong>     
           <td>MONTANT A PAYER :</td>
           <td><?php echo $somme;?> EUROS</td>
      </strong>
      </tr>
      </table>
    </page>
  
<?php   
    }// FIN DE LA CONDITION DU IF
       $content = ob_get_clean(); /* on affecte tout le contenu de la page ci-dessous dans la variable content*/
       require('html2pdf/html2pdf.class.php'); /* on appel la bibiotheque oü se trouve le pdf*/   
       try{
       $pdf = new HTML2PDF('p','A4','fr'); /* on crée une variable pdf */
       $pdf->pdf->SetDisplayMode('fullpage');/* permet d'afficher le pdf entierement */
       $pdf->writeHTML($content);/*on ecrit le contenu dans une page html*/
       ob_end_clean();/* on ferme la page*/
       $pdf->Output('tests.pdf'); /* on afficher affiche la page sur le navigateur*/

       }catch(HTML2PDF_exception $e) {
           die ($e); /* on gere les erreurs*/
       }

     }
?>
