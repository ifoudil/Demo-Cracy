<?php
class Modele{
    // getter
    public function get($attribut) {return $this->$attribut;}

    // setter
    public function set($attribut, $valeur) {$this->$attribut = $valeur;} 
    
    // constructeur
    public function __construct($donnees = NULL){
        if(!is_null($donnees)){
            foreach($donnees as $attribut => $valeur){
                $this->set($attribut, $valeur);
            }
        }
    }

    public function affichable(){return true;}

    public static function getAll(){
        $table = static::$objet;

        $requete = "SELECT * FROM $table;";
		$resultat = Connexion::pdo()->query($requete);
		$resultat->setFetchmode(PDO::FETCH_CLASS,$table);
		$arr = $resultat->fetchAll();

		return $arr;
    }
    
    public static function getObjetById($id){
        $table = static::$objet;
        $cp = static::$cle;
        
        $requeteTag = "SELECT * FROM $table WHERE $cp = :$cp;";
		$requetePrep = Connexion::pdo()->prepare($requeteTag);
        
        $val = array();
		$val[$cp] = $id;

		try{
			$requetePrep->execute($val);
			
		}catch(PDOException $e){
			echo $e->getMessage();
		}

		$requetePrep->setFetchmode(PDO::FETCH_CLASS,$table);
		$result = $requetePrep->fetch();

		return $result;
    }

    public static function deleteObjetById($id){
        $table = static::$objet;
        $cp = static::$cle;
        
        $requeteTag = "DELETE FROM $table WHERE $cp = :$cp;";
		$requetePrep = Connexion::pdo()->prepare($requeteTag);
        
        $val = array();
		$val[$cp] = $id;

		try{
			$requetePrep->execute($val);
			
		}catch(PDOException $e){
			echo $e->getMessage();
		}
    }

}