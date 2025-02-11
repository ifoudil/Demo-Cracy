<?php 
    class SuggestionVote{

        private int $numVote;
		private int $numSuggestion;

        public function __construct(int $numV , int $numS){
			$this->numVote = $numV;
			$this->numSuggestion = $numS;
		} 

        public static function afficherSuggestionCommentaires($numV){
            $requete = "SELECT DISTINCT contenu, numSuggestion, numCommentaire, vCommentaireGroupe.numGroupe FROM vCommentaireGroupe INNER JOIN vVoteGroupe ON vVoteGroupe.numVote = vCommentaireGroupe.numVote WHERE vVoteGroupe.numVote = :tag_numV;";
            $requetePreparee = Connexion::pdo()->prepare($requete);

            $requetePreparee->bindParam(':tag_numV', $numV, PDO::PARAM_INT);

            $requetePreparee->execute();
            $lesCommentaires = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
            return $lesCommentaires;
        }

        public static function afficherSuggestionGroupe($numG){
            $requete = "SELECT S.numSuggestion, Groupe.numGroupe, titre, description, nomTheme FROM Suggestion S INNER JOIN Groupe ON S.numGroupe = Groupe.numGroupe INNER JOIN Theme T ON S.numTheme = T.numTheme WHERE Groupe.numGroupe = :tag_numG";
            $requetePreparee = Connexion::pdo()->prepare($requete);

            $requetePreparee->bindParam(':tag_numG', $numG, PDO::PARAM_INT);

            $requetePreparee->execute();
            $lesSuggestions = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
            return $lesSuggestions;
        }

        public static function ajouterSuggVote($numV, $numS){
            $requete = "INSERT INTO Suggestion_Vote VALUES(:numV, :numS);";
            $requetePreparee = Connexion::pdo()->prepare($requete);
			
			$requetePreparee->bindParam(':numV', $numV);
			$requetePreparee->bindParam(':numS', $numS);
            
            try{
                $requetePreparee->execute();
            }catch(PDOExcpetion $e){
                return;
            }
        }

        
        public static function valide($numSuggestion){
            $requete = "SELECT * FROM SuggestionVote WHERE numSuggestion = :numSuggestion";
            $requetePreparee = Connexion::pdo()->prepare($requete);

            $requetePreparee->bindParam(':numSuggestion', $numSuggestion, PDO::PARAM_INT);

            $requetePreparee->execute();
            $lesSuggestions = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
            if($lesSuggestions.count()>0) return false;
            return true;
        }
    }