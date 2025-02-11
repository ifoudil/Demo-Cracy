<?php 
    class ReactionUtilisateur{

        private int $numUtilisateur;
		private int $numCommentaire;
		private int $numReaction;

        public function __construct(int $numU , int $numC , int $numR){
			$this->numUtilisateur = $numU;
			$this->numCommentaire = $numC;
			$this->numReaction = $numR;
		} 

        public static function afficherReactionCommentaireUtilisateur(int $numC){
            $requete = "SELECT image FROM vReactionMessage WHERE numCommentaire = :tag_numC;";
            $requetePreparee = Connexion::pdo()->prepare($requete);

            $requetePreparee->bindParam(':tag_numC', $numC, PDO::PARAM_INT);

            $requetePreparee->execute();
            $lesReactionsUtilisateur = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
            return $lesReactionsUtilisateur;
        }

        public static function ajouterReactionCommentaireUtilisateur(int $numU, int $numC, int $numR){
            $requete = "INSERT INTO Reaction_Utilisateur VALUES (:tag_numU, :tag_numC, :tag_numR);";
            $requetePreparee = Connexion::pdo()->prepare($requete);
			
			$requetePreparee->bindParam(':tag_numU', $numU);
			$requetePreparee->bindParam(':tag_numC', $numC);
	        $requetePreparee->bindParam(':tag_numR', $numR);
			
            try{
                $everythingOk = $requetePreparee->execute();
            } catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>