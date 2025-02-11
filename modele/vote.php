<?php 
class Vote{
	protected int $numVote;
	private string $descVote ;
	private int $dureeDiscussion;
	private int $dureeVote ;
	private string $typeVote;
	private date $dateDebutVote;
	private date $dateFinVote;
	private date $dateDebutDiscussion;
	private date $dateFinDiscussion;
	private int $numGroupe;
	
	public function __construct(int $numV , string $desc , int $dureeD, int $dureeV, string $type, date $debDisc, int $numG, date $debVote = NULL, date $finVote = NULL, date $finDisc = NULL) {
		$this->numVote = $numV;
		$this->descVote = $desc;
		$this->dureeDiscussion = $dureeD;
		$this->dureeVote = $dureeV;
		$this->typeVote = $type;
		$this->dateDebutVote = $debVote;
		$this->dateFinVote = $finVote;
		$this->dateDebutDiscussion = $debDisc;
		$this->dateFinDiscussion = $finDisc;
		$this->numGroupe = $numG;
	} 
	
	public static function getDernierNumVote(){
		$requete = "SELECT MAX(numVote) AS dernierVote FROM Vote;";
		$resultat = Connexion::pdo()->query($requete);
		$numVote = $resultat->fetch(PDO::FETCH_ASSOC);
		$dernierVote = $numVote['dernierVote'];
		return $dernierVote;
	}

	//scrutateur et admin
	public static function ajouterVote(string $desc , int $dureeD, int $dureeV, string $type, string $debDisc, int $numG){
		
		$numVote = Vote::getDernierNumVote()+1;
		$requete = "INSERT INTO Vote (numVote, descVote, dureeDiscussion, dureeVote, typeVote, dateDebutDiscussion, numGroupe) VALUES (:numVote, :desc, :dureeD, :dureeV, :type, :debDisc, :numG);";
		$requetePreparee = Connexion::pdo()->prepare($requete);
		
		$requetePreparee->bindParam(':numVote', $numVote);
		$requetePreparee->bindParam(':desc', $desc);
		$requetePreparee->bindParam(':dureeD', $dureeD);
		$requetePreparee->bindParam(':dureeV', $dureeV);
		
		$requetePreparee->bindParam(':type', $type);
		$requetePreparee->bindParam(':debDisc', $debDisc);
		$requetePreparee->bindParam(':numG', $numG);
		
		try{
			$everythingOk = $requetePreparee->execute();
		} catch(PDOException $e){
			echo $e->getMessage();
		}
		
		if($everythingOk){
			echo "<p> Le vote a bien été crée ! </p>";
			return $numVote;
		} else {
			echo "<p> Echec de la creation du vote :( </p>";
		}
	}

	public static function afficherVotesGroupe(int $numGroupe){
		
		$requete = "SELECT typeVote,descVote,numVote,dateDebutDiscussion,dateDebutVote,ADDDATE(dateDebutDiscussion, dureeDiscussion) AS dateFinDisc,ADDDATE(dateDebutVote, dureeVote) AS dateFinV FROM vVoteGroupe WHERE numGroupe = :numGroupe;";
		$pdo = Connexion::pdo();
		$requetePreparee = $pdo->prepare($requete);

		$requetePreparee->bindParam(':numGroupe', $numGroupe, PDO::PARAM_INT);

		$requetePreparee->execute();
		$lesVotes = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);

		return $lesVotes;
	}	

	public static function afficherSelectVote(int $numV){
		
		$requete = "SELECT descVote,vVoteGroupe.numVote,vCommentaireGroupe.numGroupe,numSuggestion FROM vVoteGroupe LEFT  JOIN vCommentaireGroupe ON vCommentaireGroupe.numVote = vVoteGroupe.numVote WHERE vVoteGroupe.numVote = :tag_numV;";
		$pdo = Connexion::pdo();
		$requetePreparee = $pdo->prepare($requete);

		$requetePreparee->bindParam(':tag_numV', $numV, PDO::PARAM_INT);

		$requetePreparee->execute();
		$leVote = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);

		return $leVote[0];
	}
	
	public static function voteEnCours(int $numVote){
		$requete = "SELECT dateFinVote FROM Vote WHERE numVote = :numVote AND (dateFinVote >= CURRENT_TIMESTAMP OR dateFinVote IS NULL);";
		$pdo = Connexion::pdo();
		$requetePreparee = $pdo->prepare($requete);

		$requetePreparee->bindParam(':numVote', $numVote, PDO::PARAM_INT);

		$requetePreparee->execute();
		$leVote = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);

		if(count($leVote) == 1) return true;
		else return false;
	}

	

	public static function getVotesFinis($numG){
		$requete = "SELECT numVote, descVote FROM vVoteGroupe WHERE dateFinVote <= curdate() AND numGroupe = :numG;";
		$pdo = Connexion::pdo();
		$requetePreparee = $pdo->prepare($requete);

		$requetePreparee->bindParam(':numG', $numG, PDO::PARAM_INT);

		$requetePreparee->execute();
		$lesVotesFinis = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);

		return $lesVotesFinis;
	}


}
	
	
		
		
?>