<?php
    require_once("./modele/groupe_utilisateur.php");
    require_once("./modele/vote.php");
    require_once("./modele/groupe.php");
    require_once("./modele/commentaire.php");
    require_once("./modele/proposition_vote.php");
    require_once("./modele/vote_utilisateur.php");
    require_once("./modele/suggestion_vote.php");
    require_once("./modele/suggestion.php");
    require_once("./modele/reaction.php");
    require_once("./modele/reaction_utilisateur.php");

    class ControleurGroupeUtilisateur {

        // Recuperation et affichage de toutes les groupes d'un utilisateur.
        public static function lireGroupesUtilisateur(){
            $titre = "Les Groupes";
            $mail = $_SESSION['mailUtilisateur'];
            include("./vue/debut.php");
            include("./vue/main.html");
            $lesGroupesUtilisateur = GroupeUtilisateur::afficherNomsGroupes($mail);
            include("./vue/groupe/lesGroupes.php");
        }

        public static function choisirReaction(){
            include("./vue/debut.php");
            include("./vue/main.html");
            $numC = $_GET['numCommentaire'];
            $numR = $_GET['numReaction'];
            $numG = $_GET['numGroupe'];
            ReactionUtilisateur::ajouterReactionCommentaireUtilisateur( $_SESSION['numUtilisateur'], $numC, $numR); 
            header("Location: index.php?controleur=controleurGroupeUtilisateur&action=lireConversationGroupeUtilisateur&numGroupe=$numG");
        }

        public static function lireConversationGroupeUtilisateur(){
            $titre = "Le groupe";
            $numGroupe = $_GET['numGroupe'];
            include("./vue/debut.php");
            echo "<a class='user-button' href='index.php?controleur=controleurGroupeUtilisateur&action=afficherLesUtilisateursDuGroupe&numGroupe=$numGroupe'>Utilisateurs</a>"; 
            echo "<a class='suggestion-button' href='index.php?controleur=controleurGroupeUtilisateur&action=Suggerer&numGroupe=$numGroupe'>Suggestion</a>"; 
            if($numGroupe && GroupeUtilisateur::verificationEstDansGroupe($numGroupe,$_SESSION['numUtilisateur'])){
                if(GroupeUtilisateur::peutLancerVote($numGroupe, $_SESSION['numUtilisateur'])){
                    echo "<a class='vote-button' href='index.php?controleur=controleurGroupeUtilisateur&action=afficherVote&numGroupe=$numGroupe'>Lancer un vote</a>";
                }
                echo "<div class='conversation'>";
                $lesVotesGroupe = Vote::afficherVotesGroupe($numGroupe);
                echo "</div>";
                
                include("./vue/vote/lesVotes.php");
                self::lireGroupesUtilisateur();        
            }
        }

        public static function afficherLesUtilisateursDuGroupe(){
			$titre = "Les utilisateurs";
            $numGroupe = $_GET['numGroupe'];
			include("vue/debut.php");
            include("./vue/main.html");
            $lesUtilisateursGroupe = GroupeUtilisateur::afficherTousUtilisateursGroupe($numGroupe);
			include("vue/utilisateur/lesUtilisateursGroupe.php");
            echo "<a class='retour' onclick='history.back()'>Retour</a>";
		}

        public static function voter(){

            include("./vue/debut.php");
            include("./vue/main.html");
            $numP = $_GET['numProposition'];
            $numV = $_GET['numVote'];
            $numG = $_GET['numGroupe'];
            VoteUtilisateur::ajouterVoteUtilisateur( $_SESSION['numUtilisateur'], $numV, $numP); 
            header("Location: index.php?controleur=controleurGroupeUtilisateur&action=lireConversationGroupeUtilisateur&numGroupe=$numG");
        }

        public static function afficherFormulaireCreationGroupe(){
			$titre = "Création du groupe'";
			include("vue/debut.php");
            include("./vue/main.html");
			include("vue/formulaireCreationGroupe.html");
            echo "<a class='retour' onclick='history.back()'>Retour</a>";
		}

        public static function creerGroupe(){
			$nomG = $_POST["nomGroupe"];
			$image = $_POST["image"];
			$couleur = $_POST["couleur"];

            $role = "administrateur";
            $notif = "journaliere";

			Groupe::ajouterGroupe($nomG, $image, $couleur);
            $numG = Groupe::getGroupeByNom($nomG);
			GroupeUtilisateur::rejoindreGroupeUtilisateur($_SESSION['numUtilisateur'], $numG, $role, $notif);
            header("Location: index.php?controleur=controleurGroupeUtilisateur&action=lireGroupesUtilisateur");
            exit();
		}

        public static function inviterGroupe(){
            $numG = $_GET['numGroupe'];
            $numInvitant = $_SESSION['numUtilisateur'];

			$titre = "Inviter dans le groupe";
			include("vue/debut.php");
            include("./vue/main.html");
            include('./vue/groupe/inviterGroupe.php');
        }

        public static function commenter(){
            $titre ="Commenter";
            $numV = $_GET['numVote'];
            include("./vue/debut.php");
            include("./vue/main.html");
            $vote = Vote::afficherSelectVote($numV);
            $desc = $vote['descVote'];
            $numS = $vote['numSuggestion'];
            $numG = $vote['numGroupe'];
            echo "<div class='commenter'>";
            echo"<p class='page-vote-commenter'>".htmlspecialchars($desc)."</p>";
            echo "</div>";
            $lesPropositions = PropositionVote::afficherPropositionsVotes($numV);
            include("./vue/proposition/lesPropositionsDiscussion.php");
            include("./vue/formulaireCommentaire.php");
        }

        public static function PosterCommentaire(){
           
            $numS = $_POST['numSuggestion'] ?? null;
            $numG = $_POST['numGroupe'] ?? null;
            if ($numS != null) {
                $contenu = $_POST["contenu"];
                Commentaire::ajouterUnCommentaire($contenu, $numS, $_SESSION['numUtilisateur']);
            } else {
                echo "Erreur: numS n'est pas défini.";
            }
            header("Location: index.php?controleur=controleurGroupeUtilisateur&action=lireConversationGroupeUtilisateur&numGroupe=$numG");
        }

        public static function Suggerer(){
            $titre = "Les Suggestions";
            $numG = $_GET['numGroupe'];
            include("./vue/debut.php");
            include("./vue/main.html");
            $lesSuggestions = SuggestionVote::afficherSuggestionGroupe($numG);
            include("./vue/suggestion/lesSuggestions.php");
            echo "<div class='boutonsSuggestions'>";
            echo "<a class='ajouterSugg' href='index.php?controleur=controleurSuggestion&action=afficherFormulaireSuggestion&numGroupe=$numG'>Ajouter une suggestion</a>";
            echo "<a class='retour' onclick='history.back()'>Retour</a>";
            echo "</div>";
            self::lireGroupesUtilisateur();
        }


        public static function afficherVote(){
            $numG=$_GET['numGroupe'];
            if(GroupeUtilisateur::verificationEstDansGroupe($numG,$_SESSION['numUtilisateur'])){
                $titre = "Lancer le vote";
                $lesSuggestions = Suggestion::getSuggestionGroupe($numG);
                include("./vue/debut.php");
                include("./vue/main.html");
                include("./vue/formulaireCreationVote.php");
            } else{
                self::lireGroupesUtilisateur();
            }
        }

        public static function lancerVote(){
            $desc = $_POST['descVote'];
            $dureeDisc = $_POST['dureeDisc'];
            $dureeVote = $_POST['dureeVote'];
            $typeVote = $_POST['typeVote'];
            $numG = (int) $_POST['numGroupe'];
            $date = date("Y-m-d");

            if($_POST['suggestion'] != 'invalid'){
                $numVote = Vote::ajouterVote($desc, $dureeDisc, $dureeVote, $typeVote, $date, $numG);
                SuggestionVote::ajouterSuggVote($numVote, $_POST['suggestion']);
                if($typeVote == 'PLURINOMINAL' || $_POST['optionsChoix'] == 'aChoix'){
                    $nbOptions = $_POST['nbOption'];
                    
                    // On initialise à 3 car dans la base de données "option 1" est la 3e valeur.
                    $numProp= 3;
                    for($i = 1; $i <= $nbOptions;$i++){
                        $budget = "budget".$i;
                        PropositionVote::ajouterPropositionVote($numVote, $numProp, $_POST[$budget]);
                        $numProp++;
                    }
                }
                elseif ($_POST['optionsChoix'] == 'ouiNon'){
                    PropositionVote::ajouterPropositionVote($numVote, 1, $_POST['budget1']);
                    PropositionVote::ajouterPropositionVote($numVote, 2, $_POST['budget2']);

                    if(isset($_POST['nePrononcePas'])){
                        PropositionVote::ajouterPropositionVote($numVote, 9, $_POST['budget3']);
                    }
                }
                elseif($_POST['optionsChoix'] == 'pourContre'){
                    PropositionVote::ajouterPropositionVote($numVote, 7, $_POST['budget1']);
                    PropositionVote::ajouterPropositionVote($numVote, 8, $_POST['budget2']);

                    if(isset($_POST['nePrononcePas'])){
                        PropositionVote::ajouterPropositionVote($numVote, 9, $_POST['budget3']);
                    }
                }
            }else{
                header("Location: index.php?controleur=controleurGroupeUtilisateur&action=afficherVote&numGroupe=$numG");
            }

            header("Location: index.php?controleur=controleurGroupeUtilisateur&action=lireConversationGroupeUtilisateur&numGroupe=$numG");
        }
        
    }
?>