<?php
    // Affichage des reactions
    echo "<ul class='ul_react'>";
    if($lesReactions != null) {
        foreach($lesReactions as $reaction) {
            echo "<li>";
                    $numR = $reaction['numReaction'];
                    $react = $reaction['imageReaction'];
					echo "<a tabindex='0' id='$numR' class='image-reaction' href='index.php?controleur=controleurGroupeUtilisateur&action=choisirReaction&numCommentaire=$numC&numReaction=$numR&numGroupe=$numG'>" ;
						echo "<img src='{$reaction['imageReaction']}' alt='image groupe' width='50'>";
					echo "</a>";
			echo "</li>";
        }
    }
    echo "</ul>";
?>