<?php
    // Affichage des votes
    echo "<ul>";
    if($lesCommentairesVote != null) {
        foreach($lesCommentairesVote as $commentaire) {
            // Afficher la description du vote
            $numC = $commentaire['numCommentaire'];
            $contenu = $commentaire['contenu'];
            $numG = $commentaire['numGroupe'];
            echo "<div class='chat-bubble'>";
                echo "<li><p>", htmlspecialchars($contenu), "</p></li>";
            echo "</div>";
            $lesReactions = Reaction::afficherReaction();
            include("./vue/reaction/lesReactions.php");
        }
    }
    echo "</ul>";
?>