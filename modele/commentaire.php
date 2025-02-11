<?php 
    class Commentaire{

        protected int $numCommentaire;
		private string $contenu;
		private int $numSuggestion;
		private int $numUtilisateur;

        public function __construct(int $numC , string $c , int $numS, int $numU){
			$this->numCommentaire = $numC;
			$this->contenu = $c;
			$this->numSuggestion = $numS;
			$this->numUtilisateur = $numU;
		} 

        public static function getDernierNumCommentaire(){
            $requete = "SELECT MAX(numCommentaire) AS dernierCommentaire FROM Commentaire;";
            $resultat = Connexion::pdo()->query($requete);
            $numCommentaire= $resultat->fetch(PDO::FETCH_ASSOC);
			$dernierCommentaire = $numCommentaire['dernierCommentaire'];
			return $dernierCommentaire;
        }

        public static function ajouterUnCommentaire(string $c , int $numS, int $numU){
            $numCommentaire = Commentaire::getDernierNumCommentaire()+1;
            $requete = "INSERT INTO Commentaire VALUES (:tag_numC, :tag_contenu, :tag_numS, :tag_numU);";
            $requetePreparee = Connexion::pdo()->prepare($requete);
            
            $requetePreparee->bindParam(':tag_numC', $numCommentaire);
			$requetePreparee->bindParam(':tag_contenu', $c);
			$requetePreparee->bindParam(':tag_numS', $numS);
	        $requetePreparee->bindParam(':tag_numU', $numU);
			
            try{
                $everythingOk = $requetePreparee->execute();
            } catch(PDOException $e){
                echo $e->getMessage();
            }
			
			if($everythingOk){
				echo "<p> Le commentaire a bien été crée ! </p>";
			} else {
				echo "<p> Echec de la creation du commentaire :( </p>";
			}
        }

        public static function afficherCommentairesGroupe($numGroupe){
            $requete = "SELECT * FROM vCommentaireGroupe WHERE numGroupe = :tag_numG;";
            $requetePreparee = Connexion::pdo()->prepare($requete);

            $requetePreparee->bindParam(':tag_numG', $numGroupe, PDO::PARAM_INT);

            $requetePreparee->execute();
            $lesCommentaires = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
            return $lesCommentaires;
        }
    }