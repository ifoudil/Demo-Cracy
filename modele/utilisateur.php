<?php
class Utilisateur{
  
  // attributs d'instance
	private int $numUtilisateur;
    private string $mailUtilisateur;
    private string $nomUtilisateur;
    private string $prenomUtilisateur;
    private string $mdp;
    private string $adresseUtilisateur;
	private string $villeUtilisateur;
	private string $CPUtilisateur;
		
	public function __construct($donnees = NULL){
        if(!is_null($donnees)){
            foreach($donnees as $attribut => $valeur){
                $this->set($attribut, $valeur);
            }
        }
    }

	public static function getNumUtilisateurByMail($mail){
		$requete = "SELECT numUtilisateur FROM Utilisateur WHERE mailUtilisateur = :tag_mail;";
		$requetePreparee = Connexion::pdo()->prepare($requete);

		$requetePreparee->bindParam(':tag_mail', $mail, PDO::PARAM_STR);

		$requetePreparee->execute();
		$numU = $requetePreparee->fetch(PDO::FETCH_ASSOC);
		if ($numU) {
			return (int)$numU['numUtilisateur'];
		} else {
			return null;
		}
	}


  public static function checkMDP($mail, $mdp){
	$requete = "SELECT mailUtilisateur, mdp FROM Utilisateur WHERE mailUtilisateur = :tag_mail AND mdp = :tag_mdp";
	$requetePrep = Connexion::pdo()->prepare($requete);

	$val = array ("tag_mail"=>$mail, "tag_mdp"=>$mdp);

	try{
		$requetePrep->execute($val);
		$resultat = $requetePrep->fetchAll();
		if(count($resultat) == 1) return true;
		return false;
	}catch(SQLException $e){
		return false;
	}
  }

  
	public static function getDernierNumUtilisateur(){
        $requete = "SELECT MAX(numUtilisateur) AS dernierUtilisateur FROM Utilisateur;";
        $resultat = Connexion::pdo()->query($requete);
        $numUtilisateur = $resultat->fetch(PDO::FETCH_ASSOC);
		$dernierUtilisateur = $numUtilisateur['dernierUtilisateur'];
		return $dernierUtilisateur;
	}

	
	
	public static function addUtilisateur(string $m, string $n, string $p, string $mdp, string $a, string $v, string $cp){
			$numUtilisateur = Utilisateur::getDernierNumUtilisateur()+1;
            $requete = "INSERT INTO Utilisateur (numUtilisateur, mailUtilisateur, nomUtilisateur, prenomUtilisateur, mdp, adresseUtilisateur, villeUtilisateur, CPUtilisateur) VALUES (:numUtilisateur, :mailUtilisateur, :nomUtilisateur, :prenomUtilisateur, :mdp, :adresseUtilisateur, :villeUtilisateur, :CPUtilisateur)";
            $requetePreparee = Connexion::pdo()->prepare($requete);
			
			$n = strtoupper($n);
			$p = strtoupper($p);
			$v = ucfirst($v);

			$requetePreparee->bindParam(':numUtilisateur', $numUtilisateur);
			$requetePreparee->bindParam(':mailUtilisateur', $m);
			$requetePreparee->bindParam(':nomUtilisateur', $n);
	        $requetePreparee->bindParam(':prenomUtilisateur', $p);
			$requetePreparee->bindParam(':mdp', $mdp);
			$requetePreparee->bindParam(':adresseUtilisateur', $a);
			$requetePreparee->bindParam(':villeUtilisateur', $v);
			$requetePreparee->bindParam(':CPUtilisateur', $cp);
			
            try{
                $everythingOk = $requetePreparee->execute();
            } catch(PDOException $e){
                echo $e->getMessage();
            }
			
			if($everythingOk){
				echo "<p> Le compte a bien été crée ! </p>";
			} else {
				echo "<p> Echec de la creation de compte :( </p>";
			}
    }

	public static function updateUtilisateur($mail, $nom, $prenom, $mdp, $adresse, $ville, $cp){
		$req = "UPDATE Utilisateur SET nomUtilisateur = :tag_nom, prenomUtilisateur = :tag_prenom, mdp = :tag_mdp, adresseUtilisateur = :tag_adresse, villeUtilisateur = :tag_ville, CPUtilisateur = :tag_cp WHERE mailUtilisateur = :tag_mail";
		$reqPrep = Connexion::pdo()->prepare($req);

		$val = array(
			"tag_mail" => $mail,
			"tag_nom" => strtoupper($nom),
			"tag_prenom" => strtoupper($prenom),
			"tag_mdp" => $mdp,
			"tag_adresse" => $adresse,
			"tag_ville" => ucfirst($ville),
			"tag_cp" => $cp
		);

		try{
			$reqPrep->execute($val);
			return true;
			
		}catch(PDOException $e){
			return false;
		}
	}
}
?>