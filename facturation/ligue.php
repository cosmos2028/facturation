  
<?php include("CROSL.php"); ?> <!-- ce bout de code me permet d'afficher ma page d'acceuil -->
<!DOCTYPE html>
<html>
    <head>
    <title>Nouvelle Ligue</title>
        <!-- En-tête de la page -->
        <meta charset="utf-8" />
        <link rel="stylesheet" href="styles.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <!-- Inclure la librairie Jquery -->
        <script src="http://code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
    

        <title> Ligue</title>
        
    </head>
    <body>  <!-- debut de la page  -->

    <script>
            /*  cette  fonction JavaScript   exécute le code jQuery pour transmettre les donnees de maniere serialize () cela permet de facilite la  transmise au serveur. */
        function submitForm() {
            $.ajax({type:'POST', url: 'traitement_ligue.php', data:$('#ContactForm').serialize(), success: function(response) {
            $('#ContactForm').find('.form_result').html(response);
        }});

        return false; /* ce false permet de signaler la fin de la requette et arret de regenerer la page*/
    }

    </script>
   
<form autocomplete="off" method="post" action="traitement_ligue.php" id="ContactForm" onsubmit="return submitForm();">
    <!--  lorsque on appui sur enregistrer le formulaire appel la fonction submitForm() pour executer la requete ajaxs -->
            <h1>Nouvelle Ligue</h1><br/>

        	    <label for="nom_ligue"> Nom de la ligue *</label>
        	    <input type="text"  id="nom_ligue" name =" nom_ligue"/> <br/><br/>
        	<!-- les differentes information du nouveau client -->
        	<fieldset style="width:360px;">
        		<legend>Les informations sur le trésorier</legend>
        			<label for="nom_tresorier">  Nom *</label>
        	        <input type="text" id="nom_tresorier"  name ="nom_tresorier"/> <br/>
        	        <label for="rue"> Rue</label>
        	        <input type="text" id="rue " name ="rue" /> <br/>
        	        <label for="cp"> CP</label>
        	        <input type="number" id="cp" name ="cp" /> <br/>
        	        <label for="ville"> Ville</label>
        	        <input type="text" id="ville" name ="ville" /> <br/>

        	</fieldset>
           <p>* pour les champs obligatoire</p><br/>
        	 <input type="submit" name="submit" value="Enregistrer" />

        <div class="form_result"> </div>  <!--  j'ai inclus un élément div à laquelle que je vais  mettre à jour dynamiquement la réponse du serveur -->
    </form>
    
    </body>
</html>
