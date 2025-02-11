<?php
	echo "<ul class='proposition-list-commenter'>";
	if(!$lesPropositions==null){
		foreach($lesPropositions as $proposition) {
			echo "<li class='proposition-item-commenter'>";
            $numP = $proposition['numProposition'];
			echo "<p class='proposition-commenter'>". htmlspecialchars($proposition['nomProposition']) ."</p>";
			echo "</li>";
		}
	}
	echo "</ul>";
?>

