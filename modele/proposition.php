<?php 
    class Proposition{

        protected int $numProposition;
		private string $nomProposition;
		private string $descProposition;

        public function __construct(int $numP , string $nomP , string $descP){
			$this->numProposition = $numP;
			$this->nomProposition = $nomP;
			$this->descProposition = $descP;
		} 

        public static function getDerniereProposition(){
            $requete = "SELECT MAX(numProposition) AS derniereProposition FROM Proposition;";
            $resultat = Connexion::pdo()->query($requete);
            $numProposition= $resultat->fetch(PDO::FETCH_ASSOC);
			$derniereProposition = $numProposition['derniereProposition'];
			return $derniereProposition;
        }

        public static function ajouterUneProposition(int $numP , string $nomP, string $descP){
            $numProposition = Proposition::getDerniereProposition()+1;
            $requete = "INSERT INTO Proposition VALUES (:tag_numP, :tag_nomP, :tag_descP);";
            $requetePrep = Connexion::pdo()->prepare($requete);
            
            $requetePreparee->bindParam(':tag_numP', $numP);
			$requetePreparee->bindParam(':tag_nomP', $nomP);
			$requetePreparee->bindParam(':tag_descP', $descP);
			
            try{
                $everythingOk = $requetePreparee->execute();
            } catch(PDOException $e){
                echo $e->getMessage();
            }
			
			if($everythingOk){
				echo "<p> La proposition a bien été crée ! </p>";
			} else {
				echo "<p> Echec de la creation de la proposition :( </p>";
			}
        }
    }