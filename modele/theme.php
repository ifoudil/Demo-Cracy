<?php
class Theme{
    private int $numTheme;
    private string $nomTheme;

    public function __construct(int $num = NULL, string $nom = NULL){
        $this->numTheme=$num;
        $this->$nomTheme=$nom;
    }

    public static function getAllTheme(){
        $requete = "SELECT * FROM Theme";
        $requetePreparee = Connexion::pdo()->prepare($requete);

        $requetePreparee->execute();
        $lesThemes = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);

        return $lesThemes;
    }

}