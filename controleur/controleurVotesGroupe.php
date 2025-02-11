<?php
    require_once("modele/vote.php");

    class ControleurVotesGroupe {

        // Recuperation et affichage de toutes les votes d'un groupe.
        public static function lireVotesGroupe(){
            $titre = "Discussion du Groupe";

            $lesVotesGroupe = Vote::afficherVotesGroupe($numGroupe);
            
            include("./vue/debut.php");
            include("./vue/main.html");
            include("./vue/vote/lesVotes.php");
        }
    }
?>