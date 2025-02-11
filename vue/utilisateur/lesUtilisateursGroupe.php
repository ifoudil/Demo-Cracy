<?php
    echo "<nav class='nav-users-container'>";
    echo "<ul class='user-list'>";
    echo "<p class='nav-title'>Les Utilisateurs</p>";
    if(!$lesUtilisateursGroupe==null){
        foreach($lesUtilisateursGroupe as $utilisateur) {
            echo "<li class='user-item'>";
            $mail = $utilisateur['mailUtilisateur'];
            $role = $utilisateur['nomRole'];
            echo "<p class='user-details'>" . $mail . " - " . $role . "</p>";
            echo "</li>";
        }
    } else {
        echo "<p class='no-users-message'>Aucun utilisateur dans ce groupe</p>";
    }
    echo "</ul>";
    echo "</nav>";
?>
