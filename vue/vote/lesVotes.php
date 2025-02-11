<?php
    // Affichage des votes
    echo "<div class='centered-list'>";
    echo "<ul>";
    if($lesVotesGroupe != null) {
        foreach($lesVotesGroupe as $vote) {
            // Afficher la description du vote
            $desc = $vote['descVote'];
            $numV = $vote['numVote'];
            echo "<li><a class='button' href='index.php?controleur=controleurGroupeUtilisateur&action=commenter&numVote=$numV'><div class='descVote'>", htmlspecialchars($desc), "</div>";
                echo "<br>";
                if ($vote['dateDebutDiscussion']=!null){
                    echo " - La discussion se finira le ". $vote['dateFinDisc'];
                    echo "<br>";
                    if( $vote['dateDebutVote']!=null){
                        echo " - Le vote débutera le ". $vote['dateDebutVote'].", et se finira le ". $vote['dateFinV'];
                        echo "<br>";
                    }
                }
                    echo "<br>";
                echo "Ce vote sera adopté à la ". $vote['typeVote'];
            echo "</a></li>";
            if(Vote::voteEnCours($numV)){
                $lesPropositions = PropositionVote::afficherPropositionsVotes($numV);
                include("./vue/proposition/lesPropositions.php");
            }
            $lesCommentairesVote = SuggestionVote::afficherSuggestionCommentaires($numV);
            include("./vue/commentaire/lesCommentairesVote.php");
        }
    } else {
        echo "<p>Aucun vote disponible pour ce groupe.</p>";
    }
    echo "</ul>";
    echo "</div>";
?>