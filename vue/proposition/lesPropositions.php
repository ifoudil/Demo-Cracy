<?php
	echo "<ul class='proposition-list'>";
	if(!$lesPropositions==null){
		foreach($lesPropositions as $proposition) {
			echo "<li class='proposition-item'>";
            $numP = $proposition['numProposition'];
            $numV = $vote['numVote'];
			$numG = $_GET['numGroupe'];
			echo "<a class='proposition' href='index.php?controleur=controleurGroupeUtilisateur&action=voter&numProposition=$numP&numVote=$numV&numGroupe=$numG'>". htmlspecialchars($proposition['nomProposition']) ."</a>";
			echo "</li>";
		}
	}
	echo "</ul>";
?>

