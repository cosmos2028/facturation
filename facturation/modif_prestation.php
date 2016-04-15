 <?php include("CROSL.php"); /*ce bout de code me permet d'afficher ma page d'acceuil */
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


       function liste_deroulant($tableau) {

           foreach ($tableau  as $element) {
        # code...
    
       echo "<option value=".$element.">".$element."</option>";
       }

       }
 ?> 

<!DOCTYPE html>
<html>
    <head>
        <!-- En-tête de la page -->
        <meta charset="utf-8" />
        <link rel="stylesheet" href="styles.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <!-- Inclure la librairie Jquery -->
        <script src="http://code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
    

        <title>Modifier Prestation</title>
        
    </head>
    <body>  <!-- debut de la page  -->

    <script>
            /*  cette  fonction JavaScript   exécute le code jQuery pour transmettre les donnees de maniere serialize () cela permet de facilite la  transmise au serveur. */
        function submitForm() {
            $.ajax({type:'POST', url: 'traitement_modif_prestation.php', data:$('#ContactForm').serialize(), success: function(response) {
            $('#ContactForm').find('.form_result').html(response);
        }});

        return false; /* ce false permet de signaler la fin de la requette et arret de regenerer la page*/
    }

    </script>

 <form autocomplete="off" method="post" action="traitement_modif_prestation.php" id="ContactForm" onsubmit="return submitForm();">
 
            <h1>Modifier prestation</h1><br/>
         <label for="id_presta"> code prestation</label>
         <select name="id_presta" id="id_presta">
             <?php liste_deroulant($tableau); ?>   <!-- l'identifiant du client --> 
            </select><br/><br/>
    
        <label for="nom_prest">Nom de la prestation *</label>
        <input type="text" id="nom_prest" name="nom_prest" /> <br/>
        <label for="cod_presta">le code de la prestation *</label>
        <input type="text" id="cod_presta" name="cod_presta" /> <br/>
        <label for="pu">le prix unitaire *</label>
        <input type="text" id="pu" name="pu" /> <br/><br/>
        <p>* pour les champs obligatoire</p><br/>
        <input type="submit" name="submit" value="Enregistrer" />

        <div class="form_result"> </div>  <!--  j'ai inclus un élément div à laquelle que je vais  mettre à jour dynamiquement la réponse du serveur -->
    </form>
    
    </body>
</html>