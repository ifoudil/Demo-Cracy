<?php 
class VoteUtilisateur{
	
	private int $numUtilisateur;
	private int $numVote ;
	private int $numProposition;

	
	public function __construct(int $numU, int $numV , int $numP) {
		$this->numUtilisateur = $numU;
		$this->numVote = $numV;
		$this->numProposition = $numP;
	} 
	
	public static function ajouterVoteUtilisateur(int $numU, int $numV , int $numP){
	
		$requete = "INSERT INTO Vote_Utilisateur VALUES (:tag_numU, :tag_numV, :tag_numP);";
		$requetePreparee = Connexion::pdo()->prepare($requete);
		
		$requetePreparee->bindParam(':tag_numU', $numU);
		$requetePreparee->bindParam(':tag_numV', $numV);
		$requetePreparee->bindParam(':tag_numP', $numP);
		
		try{
			$everythingOk = $requetePreparee->execute();
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	}

	
	public static function getVotesUtilisateurs($numVote){
		$requete = "SELECT numProposition, nomProposition, budgetProposition, numUtilisateur FROM vResultatVoteUtilisateur WHERE numVote = :numVote;";
		$pdo = Connexion::pdo();
		$requetePreparee = $pdo->prepare($requete);

		$requetePreparee->bindParam(':numVote', $numVote, PDO::PARAM_INT);

		$requetePreparee->execute();
		$lesVotes = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);

		return $lesVotes;
	}
}			
?>