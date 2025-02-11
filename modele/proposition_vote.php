   <?php 
    class PropositionVote{

        private int $numVote;
		private int $numProposition;
		private float $budgetProposition;

        public function __construct(int $numV , int $numP , float $budget){
			$this->numVote = $numV;
			$this->numProposition = $numP;
			$this->budgetProposition = $budget;
		} 

        public static function afficherPropositionsVotes(int $numVote){
            $requete = "SELECT nomProposition, numProposition FROM vPropositionsVote WHERE numVote = :tag_numV;";
            $requetePreparee = Connexion::pdo()->prepare($requete);

            $requetePreparee->bindParam(':tag_numV', $numVote, PDO::PARAM_INT);

            $requetePreparee->execute();
            $lesPropositions = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
            return $lesPropositions;
        }

        public static function ajouterPropositionVote(int $numVote, int $numProposition,float $budget){
            $requete = "INSERT INTO Proposition_Vote VALUES (:numVote, :numProposition, :budget);";
            $requetePreparee = Connexion::pdo()->prepare($requete);
			
			$requetePreparee->bindParam(':numVote', $numVote);
			$requetePreparee->bindParam(':numProposition', $numProposition);
	        $requetePreparee->bindParam(':budget', $budget);
			
            try{
                $everythingOk = $requetePreparee->execute();
            } catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }