<?php	
require_once("modele/utilisateur.php");


	class ControleurUtilisateur{
		protected static $objet = "Utilisateur";
		protected static $cle = "login";
		
		public static function afficherFormulaireCreation(){
			$titre = "Création de compte utilisateur";
			include("vue/debut.php");
            include("./vue/main.html");
			include("vue/formulaireCreation.html");
		}

		public static function afficherFormulaireConnexion(){
			$titre = "Connexion";
			include("vue/debut.php");
            include("./vue/main.html");
			include("vue/formulaireConnexion.html");
		}

		public static function creerUtilisateur(){

			$mail = $_POST["mailUtilisateur"];
			$nom = $_POST["nomUtilisateur"];
			$prenom = $_POST["prenomUtilisateur"];
			$adresse = $_POST["adresseUtilisateur"];
			$ville = $_POST["villeUtilisateur"];
			$cp = $_POST["CPUtilisateur"];
			if($_POST['mdp'] == $_POST['mdpConfirmation']){
				$mdp = $_POST['mdp'];
				$b = Utilisateur::addUtilisateur($mail, $nom, $prenom, $mdp, $adresse, $ville, $cp);
				if($b) {
					self::afficherFormulaireConnexion();
				}
				else {
					self::afficherFormulaireCreation();
				}
			} else {
				self::afficherFormulaireCreation();
				echo "<p>Mot de passe différent. Veuillez réessayer d'entrer le mot de passe !</p>";
			}
		}


		public static function connecterUtilisateur(){
			$mail = $_POST["mailUtilisateur"];
			$mdp = $_POST["mdp"];
			if(!Utilisateur::checkMDP($mail,$mdp)){
				self::afficherFormulaireConnexion();
			}
			else{
				$_SESSION["mailUtilisateur"] = $mail;
				$_SESSION["numUtilisateur"] = Utilisateur::getNumUtilisateurByMail($mail);
				
				require_once("controleurGroupeUtilisateur.php");
				ControleurGroupeUtilisateur::lireGroupesUtilisateur();
			}
		}

		public static function deconnecterUtilisateur(){
			session_unset();
			session_destroy();
			setcookie(session_name(),'',time()-1);
			self::afficherFormulaireConnexion();
		}
	}

?>