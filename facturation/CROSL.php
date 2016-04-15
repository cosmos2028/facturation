<!DOCTYPE html>
<html>
    <head>
        <!-- En-tête de la page -->
        <meta charset="utf-8" />
		<link rel="stylesheet" href="styles.css" />
        <title>Application - Maison Des Ligues</title>
    </head>
    <body>
		<div id="container"><!-- pour identier mon div  -->
			<header>
				<img src="logo_m2l.jpg" alt="Logo M2L"/>
				<h1 class="titre">Maison des Ligues</h1><!-- titre de la page  -->
			</header>
			<ul class="nav">
				<!-- le menu et ses sous menu  -->
				<li>
					<a href="CROSL.php">ACCUEIL</a>
				</li>
				<li>
				    <!-- le menu et ses sous menu  -->
					<a href="">LIGUES</a>
					<ul class="dropdown">
						<li> <a href="ligue.php"> Nouvelle Ligue</a></li>
						<li> <a href="modif_liguee.php"> Modifier Ligue</a></li>
					</ul>
				</li>
				<li>
				    <!-- le menu et ses sous menu  -->
					<a href="">PRESTATION</a>
					<ul class="dropdown">
						<li> <a href="prestation.php"> Nouvelle Prestation</a></li>
						<li> <a href="modif_prestation.php"> Modifier Prestation</a></li>
					</ul>
				</li>
				<li>
				    <!-- le menu et ses sous menu  -->
					<a href="">FACTURE</a>
					<ul class="dropdown">
						<li> <a href="facture.php"> Nouvelle Facture</a></li>
						<li> <a href="obtenir_facture.php"> Obtenir une Facture</a></li>
					</ul>
				</li>
			</ul>
		</div>
    </body>
</html>