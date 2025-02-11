<?php
require_once("./modele/theme.php");
require_once("./modele/suggestion.php");
require_once("./controleur/controleurGroupeUtilisateur.php");

class ControleurSuggestion{
    public static function afficherFormulaireSuggestion(){
        $numG=$_GET['numGroupe'];
        if(GroupeUtilisateur::verificationEstDansGroupe($numG,$_SESSION['numUtilisateur'])){
            $titre = 'Nouvelle suggestion';
            include("./vue/debut.php");
            include("./vue/main.html");
            $lesThemes = Theme::getAllTheme();
            include('./vue/formulaireSuggestion.php');
        }
        else{
            GroupeUtilisateur::lireGroupesUtilisateur();
        }
    }

    public static function ajouterSuggestion(){
        $numG = $_POST['numGroupe'];
        if($_POST['theme'] == 'invalid'){
            header("Location: index.php?controleur=controleurSuggestion&action=afficherFormulaireSuggestion&numGroupe=$numG");
        }

        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $theme = (int) $_POST['theme'];

        Suggestion::ajouterUneSuggestion($titre,$description,$numG,$_SESSION['numUtilisateur'],$theme); 
        header("Location: index.php?controleur=controleurGroupeUtilisateur&action=Suggerer&numGroupe=$numG");       
    }
}