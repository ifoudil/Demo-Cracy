<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $titre ?></title>

    <link rel="stylesheet" type="text/css" href="css/styleFormulaire.css" />
    <link rel="stylesheet" type="text/css" href="css/styleVote.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/styleMenuGroupe.css">
    <link rel="stylesheet" type="text/css" href="css/styleProposition.css">
    <link rel="stylesheet" type="text/css" href="css/styleVoteCommentaire.css">
    <link rel="stylesheet" type="text/css" href="css/styleCommenter.css">
    <link rel="stylesheet" type="text/css" href="css/stylePropositionCommenter.css">
    <link rel="stylesheet" type="text/css" href="css/styleSuggestionGroupe.css">
    <link rel="stylesheet" type="text/css" href="css/styleBoutons.css">
    <link rel="stylesheet" type="text/css" href="css/styleUtilisateursGroupe.css">
    <link rel="stylesheet" type="text/css" href="css/styleReaction.css">

    <script>
        // Fonction pour mettre à jour le champ texte avec la couleur hexadécimale sélectionnée
        function updateColorCode() {
            var colorInput = document.getElementById('hexa'); // Récupère le champ couleur
            var colorCodeInput = document.getElementById('couleur'); // Récupère le champ texte
            colorCodeInput.value = colorInput.value; // Met à jour le champ texte avec la couleur sélectionnée
        }
    </script>
  </head>
  <body>