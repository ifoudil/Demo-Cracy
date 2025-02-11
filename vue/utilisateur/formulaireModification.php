<main>
    <form action="index.php" method="post">
        <div>
            <input type="hidden" name="controleur" value="controleurUtilisateur">
            <input type="hidden" name="action" value="modifierUtilisateurs">
        </div>
    
        <div>
            <label for="login">login</label>
            <input type="text" name="login" value ="<?php echo $l;?>" readonly>
        </div>

        <div>
            <label for="mail">adresse mail</label>
            <input type="email" name="mail" value ="<?php echo $m;?>">
        </div>

        <div>
            <label for="mdp">mot de passe</label>
            <input type="password" name="mdp" value ="<?php echo $mdp;?>">
        </div>
    
        <div>
            <label for="nom">nom</label>
            <input type="text" name="nom"value ="<?php echo $n;?>">
        </div>
    
        <div>
            <label for="prenom">prenom</label>
            <input type="text" name="prenom" value ="<?php echo $p;?>">
        </div>

        <button type="submit">modifier</button>
    </form>
</main>
