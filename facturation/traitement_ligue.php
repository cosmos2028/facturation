<?php
try{
// On se connecte à MySQL
$bdd = new PDO('mysql:host=localhost;dbname=facturation;charset=utf8', 'root', '');
} catch(Exception $e) {
// En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}
$numCpt= 411007;
$rep = $bdd->query('SELECT numCompte FROM ligue ORDER BY numCompte desc limit 1');
                  while ($donnes = $rep->fetch()){
                      $numCpt = $donnes['numCompte'];
                      $numCpt++;
                   }

   if (isset($_POST['nom_tresorier'])  && isset($_POST['nom_ligue']) ) {

                // On récupère tout le contenu de la table ligue
      $reponse = $bdd->query('SELECT nomlig FROM ligue');

      // On affiche chaque entrée une à une
      $trouver = 0;
      $tmp = $_POST['nom_ligue'];
      while ($donnees = $reponse->fetch()){
             $tmp1 = $donnees['nomlig'];
  
        if (strcasecmp($tmp1 , $tmp) == 0)
            $trouver = 1;      
    }
                if ($trouver) 
                /* genere le code client */
                $html = "<h3 style='color:red'>ERREUR : la ligue existe déjà </h3>"; 

                else if (!empty($_POST['nom_tresorier']) && !empty($_POST['nom_ligue']) && empty($_POST['rue']) && empty($_POST['cp'])  && empty($_POST['ville'])) {

                  $bdd = $bdd->prepare('INSERT INTO ligue(numCompte,nomlig,nomtres,rue,cp,ville) VALUES(:val,:val1,:val2,:val3,:val4,:val5)');
                  $bdd->execute( array('val' => $numCpt, 'val1' =>$_POST['nom_ligue'] ,'val2' =>$_POST['nom_tresorier'] ,'val3' =>'13 Rue Jean Moulin' ,'val4' =>'75001' ,'val5' =>'Paris'));
                  $html = "<h3 style='color:green'>BRAVO : Enregistrement Effectué </h3>"; 

                }else if (!empty($_POST['nom_tresorier']) && !empty($_POST['nom_ligue']) && !empty($_POST['rue']) && !empty($_POST['cp'])  && !empty($_POST['ville'])) {

                  /* On ajoute les information du client  dans la table ligue*/
                  $bdd = $bdd->prepare('INSERT INTO ligue(numCompte,nomlig,nomtres,rue,cp,ville) VALUES(:val,:val1,:val2,:val3,:val4,:val5)');
                  $bdd->execute( array('val' => $numCpt, 'val1' =>$_POST['nom_ligue'] ,'val2' =>$_POST['nom_tresorier'] ,'val3' =>$_POST['rue'] ,'val4' =>$_POST['cp'] ,'val5' =>$_POST['ville']));
                  $html = "<h3 style='color:green'>BRAVO : Enregistrement Effectué </h3>"; 
                }else
                $html = "<h3 style='color:red'>ERREUR : car vous devez remplir soit les champs obligatoire , soit tous les champs</h3>"; 
                echo $html;
}
?>


