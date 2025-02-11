<h1>Lancer un vote</h1>
<form action="index.php" method="post">
    <div>
        <input type="hidden" name="action" value="lancerVote">
        <input type="hidden" name="controleur" value="controleurGroupeUtilisateur">
        <input type="hidden" name="numGroupe" <?php echo "value = $numG" ; ?>>
    </div>
    <div>
        <label for="descVote">Description du vote:</label>
        <input type="text" name="descVote" placeholder="Le vote portera sur ce sujet" required>
    </div>
    <div>
        <label for="dureeDisc">Durée de la discussion en jours :</label>
        <input type="number" name="dureeDisc" placeholder="10" required>
    </div>
    <div>
        <label for="dureeVote">Durée du vote en jours :</label>
        <input type="number" name="dureeVote" placeholder="10" required>
    </div>
    <div>
        <label for="suggestion">Pour quelle suggestion souhaitez vous lancer le vote ?</label>
        <select name="suggestion" required>
        <option value="invalid">Sélectionnez une option</option>
            <?php
            if($lesSuggestions != null){
                foreach($lesSuggestions as $sugg){
                    echo "<option value=\"{$sugg['numSuggestion']}\">{$sugg['description']}</option>";
                }
            }
            ?>
        </select>
    </div>
    <div>
        <label for="typeVote">Choisissez le type de vote :</label>
        <select id="typeVote" name="typeVote" required>
                <option value="">Sélectionnez une option</option>
                <option value="PLURINOMINAL">Plurinominal</option>
                <option value="MAJORITE ABSOLUE">Majorité Absolue</option>
                <option value="MAJORITE RELATIVE">Majorité Relative</option>
        </select>
    </div>

    <div id="majoriteOptions" style="display: none;">
        <label for="optionsChoix">Choisissez une option :</label>
        <div>
            <label for="ouiNon">Oui/Non</label>
            <input type="radio" id="ouiNon" name="optionsChoix" value="ouiNon">
        </div>
        <div>
            <label for="pourContre">Pour/Contre</label>
            <input type="radio" id="pourContre" name="optionsChoix" value="pourContre">
        </div>
        <div>
            <label for="aChoix">À Choix</label>
            <input type="radio" id="aChoix" name="optionsChoix" value="aChoix">
        </div>
    </div>

    <div id="checkboxOption" style="display: none;">
        <input type="checkbox" id="nePrononcePas" name="nePrononcePas" disabled>
        <label for="nePrononcePas" >Ne se prononce pas</label>
    </div>

    <div id="optionsMult" style="display: none;">
        <label for="nbOption">Combien d'options proposez-vous :</label>
        <select id="nbOption" name="nbOption">
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
    </div>

    <div id = "entreeOptions" style = "display: none;">
        <div id="option1" style="display: none;">
            <label for="option1">Option 1:</label>
            <input type="text" name="option1" placeholder="Option 1">
        </div>
        <div id="budget1" style="display: none;">
            <label for="budget1">Budget 1:</label>
            <input type="number" name="budget1" placeholder="10.00" step="0.01">
        </div>

        <div id="option2" style="display: none;">
            <label for="option2">Option 2:</label>
            <input type="text" name="option2" placeholder="Option 2" >
        </div>
        <div id="budget2" style="display: none;">
            <label for="budget2">Budget 2:</label>
            <input type="number" name="budget2" placeholder="15.00" step="0.01">
        </div>

        <div id="option3" style="display: none;">
            <label for="option3">Option 3:</label>
            <input type="text" name="option3" placeholder="Option 3">
        </div>
        <div id="budget3" style="display: none;">
            <label for="budget3">Budget 3:</label>
            <input type="text" name="budget3" placeholder="0.00" step="0.01">
        </div>

        <div id="option4" style="display: none;">
            <label for="option4">Option 4:</label>
            <input type="text" name="option4" placeholder="Option 4">
        </div>
        <div id="budget4" style="display: none;">
            <label for="budget4">Budget 4:</label>
            <input type="text" name="budget4" placeholder="25.50" step="0.01"> 
        </div>
    </div>

    <button type="submit">Enregistrer</button>
</form>

<script>
    // Fonction qui affiche les éléments quand il y a besoin de les afficher et les cache sinon
    // Par exemple on affiche le menu avec les chiffres 2 à 4 si le vote est plurinominal ou s'il est "à choix" pour les deux votes à majorité
    document.getElementById('typeVote').addEventListener('change', function() {
        const choice = this.value;

        // Toutes les options sont cachées au début
        document.getElementById('optionsMult').style.display = 'none';
        document.getElementById('checkboxOption').style.display = 'none';
        document.getElementById('majoriteOptions').style.display = 'none';
        document.getElementById('entreeOptions').style.display = 'none';

        // On vérifie que la checkbox "ne se prononce pas" est toujours désactivée
        document.getElementById('nePrononcePas').checked = false;
        document.getElementById('nePrononcePas').disabled = true;

        // On montre les options selon le type de vote
        if (choice === 'PLURINOMINAL') {
            document.getElementById('optionsMult').style.display = 'block';
        } else if (choice === 'MAJORITE ABSOLUE' || choice === 'MAJORITE RELATIVE') {
            document.getElementById('majoriteOptions').style.display = 'block';
        }
    });

    // On montre les possibilités pour un vote à la majorité (pour/contre, oui/non ou à choix)
    document.getElementById('majoriteOptions').addEventListener('change', function() {
        const optionsChoix = document.querySelector('input[name="optionsChoix"]:checked');
        const checkbox = document.getElementById('nePrononcePas');
        document.getElementById('entreeOptions').style.display = 'none';

        if (optionsChoix) {
            // Si le vote est oui/non ou pour/contre alors on propose l'option de ne pas se prononcer
            if (optionsChoix.value === 'ouiNon' || optionsChoix.value === 'pourContre') {
                document.getElementById('optionsMult').style.display = 'none';
                document.getElementById('checkboxOption').style.display = 'block';

                document.getElementById('entreeOptions').style.display = 'block';

                document.getElementById('option1').style.display = 'none';
                document.getElementById('option2').style.display = 'none';
                document.getElementById('option3').style.display = 'none';
                document.getElementById('option4').style.display = 'none';

                document.getElementById('budget1').style.display = 'block';
                document.getElementById('budget2').style.display = 'block';

                checkbox.disabled = false;
            } 
            // Sinon on ne l'affiche pas
            else if (optionsChoix.value === 'aChoix') {
                document.getElementById('optionsMult').style.display = 'block';
                document.getElementById('checkboxOption').style.display = 'none';
                checkbox.checked = false;
                checkbox.disabled = true;
            }
        }
    });

  // Event listener for the 'change' event on the optionsMult dropdown
    document.getElementById('nbOption').addEventListener('change', function () {
        document.getElementById('entreeOptions').style.display = 'block';
        const nbOptionsSelection = parseInt(this.value); 

        // Loop through 1 to the selected number (e.g., 2, 3, or 4)
        for (let i = 1; i <= nbOptionsSelection; i++) {
            var budg = "budget" + i;
            var opt = "option" + i;

            // Show the divs for 'budget' and 'option' based on the selected number
            document.getElementById(budg).style.display = 'block';
            document.getElementById(opt).style.display = 'block';
        }

        for (let i = nbOptionsSelection + 1; i <= 4; i++) {
            var budg = "budget" + i;
            var opt = "option" + i;

            // Hide the divs for extra options (if more options were selected before)
            document.getElementById(budg).style.display = 'none';
            document.getElementById(opt).style.display = 'none';

        }
    });

    document.getElementById('nePrononcePas').addEventListener('change', function () {
        if(this.checked){
            document.getElementById('budget3').style.display = 'block';
        }
        else{
            document.getElementById('budget3').style.display = 'none';
        }
    });
</script>
