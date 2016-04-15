<?php

try{
// On se connecte à MySQL
$bdd = new PDO('mysql:host=localhost;dbname=facturation;charset=utf8', 'root', '');
} catch(Exception $e) {
// En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}

/* on verifie si on a bien le code du client */
if( isset($_POST['compt_cli'])  && !empty($_POST['compt_cli'])) {

     /* On récupère le numcompte de la table ligue et on affect le resultat dans la variable $reponse*/
$reponse = $bdd->query("SELECT nomlig FROM ligue ");
$trouver = 1;
$numCpt= 0;
$tmp = $_POST['nom_ligue'];
/* On affiche chaque entrée une à une, la boucle se repete tant qu'on a pas fini de parcourir le tableau $reponse*/
while ($donnees = $reponse->fetch()){
 $tmp1 = $donnees['nomlig'];
          //ici on effectué la comparaison
        if (strcasecmp($tmp1, $tmp) == 0)
            $trouver = 0;      
}

$val=$_POST['nom_ligue']; $val1=$_POST['nom_tresorier'];  
              /* genere le code client */
                  $today = date("jnY"); 
                  $idClient = "$val-$today";
                  $valCli = $_POST["compt_cli"];

                  $rep = $bdd->query("SELECT numCompte FROM ligue where nomlig = '$valCli' ");
                  while ($donnes = $rep->fetch()){
                      $numCpt = $donnes['numCompte'];
                   }

      /* ici on va enregistrer les informations du client s'il existe et s'il a rempli tous les champs */
 if( !$trouver)
      $html = "<h3 style='color:red'>ERREUR : la ligue existe déjà </h3>"; 
 

 else if (!empty($_POST['nom_tresorier']) && !empty($_POST['nom_ligue']) && empty($_POST['rue']) && empty($_POST['cp']) && empty($_POST['ville'])) {

               /* On ajoute les information du client  dans la table ligue*/

              
               $bdd->exec("UPDATE ligue SET nomlig='$val' ,nomtres = '$val1',rue ='13 Rue Jean Moulin' ,cp ='75001' ,ville = 'Paris' WHERE numCompte = $numCpt ");
                $reponse->closeCursor(); // Termine le traitement de la requête

       $html = "<h3 style='color:green'>BRAVO : Enregistrement Effectué </h3>"; 


 }else if (!empty($_POST['nom_tresorier']) && !empty($_POST['nom_ligue']) && !empty($_POST['rue']) && !empty($_POST['cp']) && !empty($_POST['ville']) ) {
    $val2 = $_POST['rue'];
    $val3 = $_POST['cp'];
    $val4 = $_POST['ville'];
   $bdd->exec("UPDATE ligue SET nomlig='$val',nomtres = '$val1',rue ='$val2' ,cp ='$val3' ,ville = '$val4' WHERE numCompte = $numCpt ");
                $reponse->closeCursor(); // Termine le traitement de la requête

       $html = "<h3 style='color:green'>BRAVO : Enregistrement Effectué </h3>"; 

}else $html = "<h3 style='color:red'>ERREUR : car vous devez remplir soit les champs obligatoire , soit tous les champs</h3>";

 echo $html;

}

?>


