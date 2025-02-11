<?php 
    class Reaction{

        protected int $numReaction;
		private string $nomReaction;
		private string $imageReaction;

        public function __construct(int $numR , string $nomR , string $imageR){
			$this->numReaction = $numR;
			$this->nomReaction = $nomR;
			$this->imageReaction = $imageR;
		} 

        public static function afficherReaction(){
            $requete = "SELECT imageReaction,numReaction,nomReaction FROM Reaction;";
            $requetePreparee = Connexion::pdo()->prepare($requete);

            $requetePreparee->execute();
            $lesReactions = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
            return $lesReactions;
        }
    }
?>