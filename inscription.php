<?php
session_start();
require "conf.inc.php";

try{
	$bdd = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PWD);
	}catch(Exception $e){
		die("Erreur SQL: ". $e->getMessage());
	}
	return $bdd;

//$reponse = $bdd->query("SELECT * FROM login");

if(isset($_POST['inscriptionvalide'])) {
		$pseudo = htmlspecialchars($_POST['pseudo']);
		$email = htmlspecialchars($_POST['email']);
		$mdp = sha1($_POST['mdp']);
		$mdp2 = sha1($_POST['mdp2']);
	if(!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])  ) {

		$pseudolength = strlen($pseudo);
		if($pseudolength <= 10) {
			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

				if($mdp == $mdp2){
				$insertmbr = $bdd->prepare("INSERT INTO login(pseudo, email, mdp) VALUES (?, ?, ?)");
				$insertmbr->execute(array($pseudo, $email, $mdp));
				$erreur = "Vous avez rejoint nos rangs";

				}else {
					$erreur = "Les mots de passe ne sont pas identiques";
				}
			}else{
				$erreur = "Votre email est invalide";
			}
		}else{
			$erreur = "Votre pseudo ne doit pas dépasser 10 caractères";
		}
	}
	else {
		$erreur = "Tu n'as pas remplis tous les champs!";
	}
}

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
	<title> Ahon & Slaid</title>

</head>
<!--Onglets d'options-->
<header>
	<div id = "onglets">
	<ul>
		<li ><a href="accueil.html"><b>Connexion</b></a></li>
		<li ><a href="#"><b>Lâche ta haine</b></a></li>
		<li ><a href="contact.html"><b>Contact</b></a></li>
	</ul>
	
	</div>
 
</header>
<body>
<div class="menu">
<center>
	<h1> Ahon & Slaid</h1>
</center>
</div>
<section id="formulaire">
	<div class="formulaire1">
        <center>         
            <form class="form" method="post" action="">
            <p>
            	Inscris-toi futur joueur
            </p>
                <p>

                    <input type="text" name="pseudo" id="nom" placeholder="Entrez votre pseudo" style="width:350px" size="20" maxlenght="15" class="contenu" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
                    <input type="text" name="email" id="mail" placeholder="Entrez votre email" style="width:350px" size="20" maxlenght="15" class="contenu" value="<?php if(isset($email)) { echo $email; } ?>"/>
                    <input type="password" name="mdp" id="mdp" placeholder="Entrez votre mot de passe" style="width:350px" size="20" maxlenght="15" class="contenu" />
                    <input type="password" name="mdp2" id="mdp2" placeholder="Confirmez votre mot de passe" style="width:350px" size="20" maxlenght="15" class="contenu"/>

                    <br><br><br><br>
                    <input id="boutton" type="submit" value="J'envoie mon inscription"  class="submit" name="inscriptionvalide">
                    <br><br><br>
            
        </center>
    </div>               
	</form>
	<?php
		if(isset($erreur)) {
			echo $erreur;
		}
	?>
</section>

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