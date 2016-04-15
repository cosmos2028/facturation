
<?php   ob_start(); 

 
 ?>

<style type="text/css">
    table { width: 100%; line-height: 6mm;}
</style>



    <page backtop = "20mm" backleft ="10mm backright =10mm" backbottom = "30mm">

        <table style="vertical-align:top;">
            <tr>
            <strong>
                <td style="width:55%;"> Maison Régionale des Sports de Lorraine <br/>
                13 rue jean Moulin <br/>
                BP 70001<br/>
                Siret 31740105700029<br/>
                Tél 03.83.18.87.02<br/>
                Fax 03.83.18.87.03
                 </td>
                 </strong>
                 <?php
               
                    $bdd = new PDO('mysql:host=localhost;dbname=facturation;charset=utf8', 'root', '');
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               

                $date = new DateTime();

              $date=$date->format('d-m-Y');
               
              $datE = date('d-m-Y', strtotime('+17 days'));

                // On récupère tout le contenu de la table jeux_video
            $reponse = $bdd->query('SELECT * FROM ligue ');

        // On affiche chaque entrée une à une
        while ($donnees = $reponse->fetch())
        {?>
            <strong>
            <td style="width:45%;"> Ligue Lorraine <?php echo $donnees['nomlig']; ?><br /> 
            A l'attention de <?php echo $donnees['nomtres'];?><br/>
            <?php echo $donnees['rue'];?> 
            <?php echo  $donnees['cp'];?>
            <?php echo  $donnees['ville'];?>
             </td>
           </strong>
            <?php      
        }

        $reponse->closeCursor(); // Termine le traitement de la requête

            ?>
            </tr>
            
        </table>
        
        <table>
            <thead> 
            <tr>
                <th>Numero Facture</th>
                <th>Code Client</th>
                <th>Date Emise</th>
                <th>Echeance</th>
                </tr>

            </thead>
            <tbody>

            <tr>koko</tr>
            <tr>koko</tr>

            </tbody>

        </table>
    
    </page>


<?php   
       $content = ob_get_clean(); 
       require('html2pdf/html2pdf.class.php');

       try{
        $pdf = new HTML2PDF('p','A4','fr');
        $pdf->writeHTML($content);
        ob_end_clean();
        $pdf->Output('tests.pdf');

       }catch(HTML2PDF_exception $e) {
           die ($e);
       }
?>

