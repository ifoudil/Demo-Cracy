<?php 
    class Groupe{

        //attribut d'une instance de la classe Utilisateur 
		private int $numGroupe;
        private string $nomGroupe;
        private string $image;
        private string $couleur;
		
		public function get($attribut){ return $this->$attribut;}

        public function set($attribut, $valeur){ $this->$attribut = $valeur ;}
		
		public static function getDernierNumGroupe(){
            $requete = "SELECT MAX(numGroupe) AS dernierGroupe FROM Groupe;";
            $resultat = Connexion::pdo()->query($requete);
            $numGroupe = $resultat->fetch(PDO::FETCH_ASSOC);
			$dernierGroupe = $numGroupe['dernierGroupe'];
			return $dernierGroupe;
        }
		
		public static function ajouterGroupe(string $n, string $i, string $c){
			
			$numGroupe = Groupe::getDernierNumGroupe()+1;
            $requete = "INSERT INTO Groupe (numGroupe, nomGroupe, image, couleur) VALUES (:numGroupe, :nomGroupe, :image, :couleur);";
            $requetePreparee = Connexion::pdo()->prepare($requete);
			
			$requetePreparee->bindParam(':numGroupe', $numGroupe);
			$requetePreparee->bindParam(':nomGroupe', $n);
			$requetePreparee->bindParam(':image', $i);
	        $requetePreparee->bindParam(':couleur', $c);
			
            try{
                $everythingOk = $requetePreparee->execute();
            } catch(PDOException $e){
                echo $e->getMessage();
            }
			
			if($everythingOk){
				echo "<p> Le groupe a bien été crée ! </p>";
			} else {
				echo "<p> Echec de la creation du groupe :( </p>";
			}
        }
		
		public function __construct(string $image , string $nomGroupe , string $couleur ) {
			$this->image = $image;
			$this->nomGroupe = $nomGroupe;
			$this->couleur = $couleur;
		}
		
		public static function getGroupeByNum(int $numG) {
			$requete = "SELECT * FROM Groupe WHERE numGroupe = :tag_numG;";
			$pdo = Connexion::pdo();
			$requetePreparee = $pdo->prepare($requete);

			$requetePreparee->bindParam(':tag_numG', $numG, PDO::PARAM_INT);

			$requetePreparee->execute();
			$groupe = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);

			return $groupe;
		}

		public static function getGroupeByNom(string $nomG) {
			$requete = "SELECT numGroupe FROM Groupe WHERE nomGroupe = :tag_nomG;";
			$pdo = Connexion::pdo();
			$requetePreparee = $pdo->prepare($requete);

			$requetePreparee->bindParam(':tag_nomG', $nomG, PDO::PARAM_STR);

			$requetePreparee->execute();
			$nom = $requetePreparee->fetch(PDO::FETCH_ASSOC);

			return $nom ? $nom['numGroupe'] : null;
		}
		
		public function afficher(){ 
			echo "<p> Le groupe",$this->nomGroupe, " existe</p>" ;
		} 	
	}
?>