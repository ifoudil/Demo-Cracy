<?php 
    class Suggestion{

        protected int $numSuggestion;
		private string $titre;
		private string $description;
		private int $numGroupe;
        private int $numUtilisateur;
        private int $numTheme;

        public function __construct(int $numS , string $titre , string $desc, int $numG, int $numU, int $numT){
			$this->numSuggestion = $numS;
			$this->titre = $titre;
			$this->description = $desc;
			$this->numGroupe = $numG;
            $this->numUtilisateur = $numU;
			$this->numTheme = $numT;
		} 

        public static function getDernierNumSuggestion(){
            $requete = "SELECT MAX(numSuggestion) AS derniereSuggestion FROM Suggestion;";
            $resultat = Connexion::pdo()->query($requete);
            $numSugg= $resultat->fetch(PDO::FETCH_ASSOC);
			$derniereSuggestion = $numSugg['derniereSuggestion'];
			return $derniereSuggestion;
        }

        public static function ajouterUneSuggestion(string $titre , string $desc, int $numG, int $numU, int $numT){
            $numS = self::getDernierNumSuggestion()+1;
            $requete = "INSERT INTO Suggestion VALUES (:tag_numS, :tag_titre, :tag_desc, :tag_numG, :tag_numU, :tag_numT);";
            $requetePreparee = Connexion::pdo()->prepare($requete);
            
            $requetePreparee->bindParam(':tag_numS', $numS);
			$requetePreparee->bindParam(':tag_titre', $titre);
			$requetePreparee->bindParam(':tag_desc', $desc);
	        $requetePreparee->bindParam(':tag_numG', $numG);
            $requetePreparee->bindParam(':tag_numU', $numU);
	        $requetePreparee->bindParam(':tag_numT', $numT);
			
            try{
                $everythingOk = $requetePreparee->execute();
            } catch(PDOException $e){
                echo $e->getMessage();
            }
			
			if($everythingOk){
				echo "<p> La suggestion a bien été ajouté ! </p>";
			} else {
				echo "<p> Echec de l'envoi de la suggestion :( </p>";
			}
        }

        public static function getSuggestionGroupe(int $numG){
            $requete = "SELECT numSuggestion, description FROM Suggestion WHERE numGroupe = :numG;";
            $pdo = Connexion::pdo();
		    $requetePreparee = $pdo->prepare($requete);
	
            $requetePreparee->bindParam(':numG', $numG, PDO::PARAM_STR);
            $requetePreparee->execute();
            $lesSuggestions = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);

            return $lesSuggestions;
        }
    }
?>