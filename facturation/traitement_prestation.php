<?php

try{
// On se connecte à MySQL
$bdd = new PDO('mysql:host=localhost;dbname=facturation;charset=utf8', 'root', '');
} catch(Exception $e) {
// En cas d'erreur, on affiche un message et on arrête tout
  die('Erreur : '.$e->getMessage());
}

     /* On récupère le numcompte de la table ligue et on affect le resultat dans la variable $reponse*/
$reponse = $bdd->query("SELECT codePresta FROM prestation ");
$tableau[] = ' ';
/* On affiche chaque entrée une à une, la boucle se repete tant qu'on a pas fini de parcourir le tableau $reponse*/
while ($donnees = $reponse->fetch()){
$tableau[] = $donnees['codePresta'];   /* on stock chaque resultat dans une variable tableau */

}
      /* ici on va enregistrer les informations des prestation s'il n'existe pas  et s'il a rempli tous les champs */
 
    if(in_array($_POST['cod_presta'], $tableau))
         $html = "<h3 style='color:red'>ERREUR : Enregistrement impossible le Code Prestation existe déja </h3>";

 else if (($_POST['nom_prest']!=='') && ($_POST['cod_presta']!=='') && ($_POST['pu']!=='')  ) {
               // On ajoute une entrée dans la table prestation
                $bdd = $bdd->prepare('INSERT INTO prestation(codePresta ,nomPresta,puPresta) VALUES(:cod_presta,:nom_prest,:pu)');

                $bdd->execute(array ('cod_presta' =>$_POST['cod_presta'],'nom_prest' =>$_POST['nom_prest'],'pu'=>$_POST['pu']  ));

                $reponse->closeCursor(); // Termine le traitement de la requête

       $html = "<h3 style='color:green'>BRAVO : Enregistrement Effectué </h3>"; 


 }else $html = "<h3 style='color:red'>ERREUR :car vous devez remplir tous champs obligatoire </h3>";

 echo $html;


?>
