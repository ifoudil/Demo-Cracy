<?php
	echo "<nav>";
		echo "<div class='chat-container'>";
		echo "<a class='deconnexion' href='index.php?controleur=controleurUtilisateur&action=deconnecterUtilisateur'>Se déconnecter</a>";
		echo "<ul>";
		echo "<div class='header-logo' id='headerLogo'>";
			echo "<img src='https://e7.pngegg.com/pngimages/178/595/png-clipart-user-profile-computer-icons-login-user-avatars-monochrome-black-thumbnail.png' alt='utilisateur' width='200'>";
			echo "<div style='width: auto; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>";
				echo "<p>".$_SESSION['mailUtilisateur']."</p>";
			echo "</div>";
		echo "</div>";
		echo "<div class='create-group-button'>";
			echo "<div class='title-mes-groupes'>";
				echo "<p> Mes Groupes </p>";
			echo "</div>";
			echo "<div class='select-create-button'>";
				echo "<a class='button' href='index.php?controleur=controleurGroupeUtilisateur&action=afficherFormulaireCreationGroupe'>";
					echo "<img src='image/Plus_Groupe.png' alt='image plus groupe'>";
				echo "</a>";
			echo "</div>";
		echo "</div>";
		if(!$lesGroupesUtilisateur==null){
			foreach($lesGroupesUtilisateur as $groupe) {
				echo "<li>";
					$num = $groupe['numGroupe'];
					echo "<a class='chat-group' href='index.php?controleur=controleurGroupeUtilisateur&action=lireConversationGroupeUtilisateur&numGroupe=$num'>". htmlspecialchars($groupe['nomGroupe']) ;
						echo "<img src='{$groupe['image']}' alt='image groupe' width='50'>";
					echo "</a>";
				echo "</li>";
			}
		}
		else{
			echo "<p>L'utilisateur n'est dans aucun groupe </p>";
		}
		echo "</ul>";
		echo "</div>";
	echo "<nav>";
?>

