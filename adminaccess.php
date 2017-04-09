<?php
session_start();
try {
$bdd = ora_logon("projet@localhost")
} 
catch (Exception $e) {
	die('Erreur : ' . $e->getMessage());
}
//Recherche des membres inscrits
if(!isset($_SESSION["id"]) OR $_SESSION["id"] == 1){
	exit();
}
//$query = $bdd->prepare("SELECT id FROM admin where ")
	if(isset($_GET["confirme"]) AND !empty($_GET["confirme"])) {
		$confirme = (int) $_GET["confirme"];
		$req = $bdd->prepare("UPDATE membres SET confirme = 1 WHERE membre = ?");
		$req->execute(array($confirme));
	}
elseif(isset($_GET["type"]) AND $_GET["type"] == "commentaire") {
	if(isset($_GET["confirme"]) AND !empty($_GET["confirme"])) {
		$confirme = (int) $_GET["confirme"];
		$req = $bdd->prepare("UPDATE commentaire SET confirme = 1 WHERE commentaire = ?");
		$req->execute(array($confirme));
	}	
	if(isset($_GET["supprime"]) AND !empty($_GET["supprime"])) {
		$supprime = (int) $_GET["supprime"];
		$req = $bdd->prepare("DELETE FROM membres SET confirme = 1 WHERE membre = ?");
		$req->execute(array($supprime));
	}
}
$membres = $bdd->query("SELECT * FROM membres ORDER BY pseudo DESC");
$commentaire = $bdd->query("SELECT * FROM commentaire");

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Cabin+Sketch|Press+Start+2P" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Neucha" rel="stylesheet">
	<!--Titre de la page-->
	<title> Ahon & Slaid - Administration</title>

</head>
<!--Onglets d'options-->
<header>
	<div id = "onglets">
	<ul>
		<li href=""><a><b>Déconnexion</b></a></li>
		<li href=""><a><b>Membres</b></a></li>
		<li href="messagerie.html"><a><b>Messagerie</b></a></li>
	</ul>
	
	</div>
 
</header>
<body>
<center>
	<h1>Ahon & Slaid - Bienvenue dans l'espace administration</h1>
</center>
//Affichage des membres inscrits
<ul>
	<?php while($m = $membres->fetch()) { ?>
	<li> <?= $m["pseudo"] ?> : <?= $m["pseudo"] ?> <?php if($m["confirme"] == 0) { ?> - <a href="adminaccess.php?confirme=<?= $m["pseudo"] ?>">Confirmer</a> <?php } ?> - <a href="adminaccess.php?supprime=<?= $m["pseudo"] ?>">Supprimer</a><?php } ?></li>
</ul>
<br>
<ul>
	<?php while($c = $commentaire->fetch()) { ?>
	<li> <?= $c["pseudo"] ?> : <?= $c["contenu"] ?> <?php if($c["confirme"] == 0) { ?> - <a href="adminaccess.php?confirme=<?= $c["pseudo"] ?>">Confirmer</a> <?php } ?> - <a href="adminaccess.php?supprime=<?= $m["pseudo"] ?>">Supprimer</a><?php } ?></li>
</ul>
</body>
<footer>
	<div id="divfooter">
	<p>Ahon & Slaid | Copyright © 2017.</p>
		<li><a><i class="fa fa-envelope-o" aria-hidden="true"></i></li>
		
		<li><a><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
		<li><a><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
	</div>
</footer>
</body>
</html>