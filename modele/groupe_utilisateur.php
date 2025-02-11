<?php

class GroupeUtilisateur{
	protected int $numUtilisateur;
	protected int $numGroupe;
	protected string $nomRole;
	protected string $typeNotification;
	
	public function getDansGroupe(){return $this->estDansGroupe ==1;}
	
	// constructeur
    public function __construct($donnees = NULL){
        if(!is_null($donnees)){
            foreach($donnees as $attribut => $valeur){
                $this->set($attribut, $valeur);
            }
        }
    }

	public static function verificationEstDansGroupe($numGroupe, $numUtilisateur){
		
		$requete = "SELECT * FROM vGroupeUtilisateur WHERE numGroupe = :tag_numG AND numUtilisateur = :tag_numU ;";
		$requetePrep = Connexion::pdo()->prepare($requete);
		
		$val = array ("tag_numU"=>$numUtilisateur, "tag_numG"=>$numGroupe);

		try{
			$requetePrep->execute($val);
			$resultat = $requetePrep->fetchAll();
			if(count($resultat) == 1) return true;
			return false;
		}catch(SQLException $e){
			return false;
		}	
	}
	
	public static function rejoindreGroupeUtilisateur ($numUtilisateur, $numGroupe, $nomRole, $typeNotification ){
		$requete = "INSERT INTO Groupe_Utilisateur VALUES (:tag_numU, :tag_numG, :tag_nomR, :tag_typeN);";
		$requetePreparee = Connexion::pdo()->prepare($requete);
        
		$requetePreparee->bindParam(':tag_numU', $numUtilisateur);
		$requetePreparee->bindParam(':tag_numG', $numGroupe);
		$requetePreparee->bindParam(':tag_nomR', $nomRole);
		$requetePreparee->bindParam(':tag_typeN', $typeNotification);
			
        try{
            $everythingOk = $requetePreparee->execute();
        } catch(PDOException $e){
            echo $e->getMessage();
        }
	}

	public static function afficherTousUtilisateursGroupe($numGroupe){ 
		$requete = "SELECT mailUtilisateur, nomRole FROM vGroupeUtilisateur WHERE numGroupe = :numGroupe;";
		$pdo = Connexion::pdo();
		$requetePreparee = $pdo->prepare($requete);
	
		$requetePreparee->bindParam(':numGroupe', $numGroupe, PDO::PARAM_INT);
		$requetePreparee->execute();
		$lesUtilisateursGroupes = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
	
		return $lesUtilisateursGroupes;
	}
	
	public static function afficherNomsGroupes($mailUtilisateur){ 
		$requete = "SELECT numGroupe,nomGroupe,numUtilisateur,image,couleur FROM vGroupeUtilisateur WHERE mailUtilisateur = :mailUtilisateur;";
		$pdo = Connexion::pdo();
		$requetePreparee = $pdo->prepare($requete);
	
		$requetePreparee->bindParam(':mailUtilisateur', $mailUtilisateur, PDO::PARAM_STR);
		$requetePreparee->execute();
		$lesGroupes = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
	
		return $lesGroupes;
	}

	public function afficherLeNomDuGroupe(){ 
		$gr = getGroupeByNum($this->numGroupe);
		$nom = $gr->get($nomGroupe);
		echo"<div class='line'>";
			echo"<a class ='button' href='index.php?controleur=controleurAfficherDiscussion&action=lireDiscussion&numGroupe=$this->numGroupe'>$nom</a>";
		echo "</div>";
	}

	public static function peutLancerVote($numG, $numU){
		$requete = "SELECT nomRole FROM Groupe_Utilisateur WHERE numGroupe = :numG AND numUtilisateur = :numU;";
		$pdo = Connexion::pdo();
		$requetePreparee = $pdo->prepare($requete);

		$requetePreparee->bindParam(':numG', $numG, PDO::PARAM_INT);
		$requetePreparee->bindParam(':numU', $numU, PDO::PARAM_INT);

		
		$requetePreparee->execute();
		$role = $requetePreparee->fetch(PDO::FETCH_ASSOC);
		if($role['nomRole'] == 'administrateur' || $role['nomRole'] == 'scrutateur'){
			return true;
		}
		return false;
	}

	public static function afficherNomsGroupesDecideur($numU){
		$requete = "SELECT numGroupe,nomGroupe,image,couleur FROM vGroupeUtilisateur WHERE numUtilisateur = :numU AND nomRole='décideur';";
		$pdo = Connexion::pdo();
		$requetePreparee = $pdo->prepare($requete);
	
		$requetePreparee->bindParam(':numU', $numU, PDO::PARAM_STR);
		$requetePreparee->execute();
		$lesGroupes = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
	
		return $lesGroupes;
	}
} 
