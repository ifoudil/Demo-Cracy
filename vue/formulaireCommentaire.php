<div class=".div-commenter">
    <form class="form-com" action="index.php?" method = "post">
        <div>
            <input type = "hidden" name = "action" value = "PosterCommentaire">
            <input type = "hidden" name = "controleur" value = "controleurGroupeUtilisateur">
        </div>
        <div>
            <input type="hidden" name="numSuggestion" value="<?php echo $numS; ?>">
        </div>
        <div>
            <input type="hidden" name="numGroupe" value="<?php echo $numG; ?>">
        </div>
        <div>
            <textarea type="text" name="contenu" placeholder ="Tapez votre commentaire ici"></textarea>
        </div>

        <button class="send-commentaire" type="submit">Envoyez</button>
    </form>
</div>
