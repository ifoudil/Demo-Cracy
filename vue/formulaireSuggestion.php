<h1>Nouvelle suggestion</h1>
<form action="index.php" method="post">
    <div>
        <input type="hidden" name="action" value="ajouterSuggestion">
        <input type="hidden" name="controleur" value="controleurSuggestion">
        <input type="hidden" name="numGroupe" <?php echo "value = $numG" ; ?>>
    </div>

    <div>
        <label name="titre">Titre de la proposition</label>
        <input name="titre" type="text" placeholder="Titre" for="titre" required>
    </div>

    <div>
        <label name="description">Description de la proposition</label>
        <input name="description" type="text" placeholder="Description" for="description" required>
    </div>

    <div>
        <label for="theme">Theme de la suggestion</label>
        <select name="theme" required>
            <option value="invalid">Sélectionnez une option</option>
            <?php
                if($lesThemes != null){
                    foreach($lesThemes as $theme){
                        echo "<option value=\"{$theme['numTheme']}\">{$theme['nomTheme']}</option>";
                    }
                }
            ?>
        </select>
    </div>

    <button type="submit">Enregistrer</button>
</form>
