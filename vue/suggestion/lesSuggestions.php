<?php
	echo "<ul class='suggestion-list'>";
	if(!$lesSuggestions==null){
		foreach($lesSuggestions as $suggestion) {
			echo "<li class='suggestion-item'>";
            $numS = $suggestion['numSuggestion'];
            $titre = $suggestion['titre'];
            $desc = $suggestion['description'];
            $theme = $suggestion['nomTheme'];
			echo "<p class='titre-sug'>" . $titre . "</p>";
            echo "<p class='descSug'>" . $desc . "</p>";
            echo "<p class='themeSug'>" . $theme . "</p>";
			echo "</li>";
		}
	}
	echo "</ul>";
?>

