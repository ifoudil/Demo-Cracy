<?php
require_once("../config/connexion.php");
Connexion::connect();

require('allModele.php');
if(isset($_GET['action'])){
    if($_GET['action']=='afficherGroupes' && isset($_GET['mail'])){
        $mail = $_GET['mail'];
        $num = Utilisateur::getNumUtilisateurByMail($mail);
        
        $groupeUtilisateurDecideur = GroupeUtilisateur::afficherNomsGroupesDecideur($num);
        $json = array();

        for($i = 0 ; $i < count($groupeUtilisateurDecideur) ; $i+=1){
            $groupe = "groupe".$i;
            $json[] = array($groupe=>$groupeUtilisateurDecideur[$i]);
        }

        print json_encode($json);
        return json_encode($json);

    }

    if($_GET['action']=='checkMDP' && isset($_GET['mail']) && isset($_GET['mdp'])){
        $mail = $_GET['mail'];
        $mdp = $_GET['mdp'];

        $json = array("statut"=>false);
        if(Utilisateur::checkMDP($mail,$mdp)){
            $json = array("statut" => true);
        }

        print json_encode($json);
        return json_encode($json);
    }

    if($_GET['action']=='getVotesFinis' && isset($_GET['numGroupe'])){
        $numGroupe = $_GET['numGroupe'];
        
        $votesFinis = Vote::getVotesFinis($numGroupe);
        $json = array();
        for($i = 0; $i<count($votesFinis) ; $i++){
            $vote = "vote".$i;
            $json = array($vote => $votesFinis);
        }

        print json_encode($json);
        return json_encode($json);
    }

    if($_GET['action']=='getVotesUtilisateurs' && isset($_GET['numVote'])){
        $numV = $_GET['numVote'];
        

        $votesUtilisateur = VoteUtilisateur::getVotesUtilisateurs($numV);
        $json = array();

        for($i = 0 ; $i < count($votesUtilisateur) ; $i+=1){
            $votes = "voteUtilisateur".$i;
            $json[] = array($votes=>$votesUtilisateur[$i]);
        }
        print json_encode($json);
        return json_encode($json);

    }
}

