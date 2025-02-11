<?php	
	// insertion des classes connexion
	require_once("config/connexion.php");
	require_once("modele/session.php");
	
	// connexion
	Connexion::connect();

	if(!Session::userConnected()&&!Session::userConnecting()){
		$actionDispo = array("1" => "afficherFormulaireConnexion", "2" => "afficherFormulaireCreation", "3" => "creerUtilisateur", "4" => "connecterUtilisateur");
		$action = "afficherFormulaireConnexion";
		if(isset($_GET["action"]) && in_array($_GET["action"], $actionDispo)) $action = $_GET["action"];
		if(isset($_POST["action"]) && in_array($_POST["action"], $actionDispo)) $action = $_POST["action"];

		require_once("controleur/controleurUtilisateur.php");
		controleurUtilisateur::$action();

	}
	else{
		$controleur = "controleurGroupeUtilisateur";
		$action = "lireGroupesUtilisateur";
		
		$tableauControleurs = ["controleurGroupeUtilisateur","controleurUtilisateur", "controleurSuggestion", "controleurVotesGroupe"];
		$actionParDefaut = array(
			"controleurGroupeUtilisateur" => "lireGroupesUtilisateur",
			"controleurUtilisateur" => "deconnecterUtilisateur",
			"controleurSuggestion" => "afficherFormulaireSuggestion",
			"controleurVotesGroupe" => "lireVotesGroupe"
		);
	
		if(isset($_GET["controleur"]) && in_array($_GET["controleur"], $tableauControleurs))  $controleur = $_GET["controleur"];
		if(isset($_POST["controleur"]) && in_array($_POST["controleur"], $tableauControleurs)) $controleur = $_POST["controleur"];
		
		require_once("controleur/$controleur.php");
		
		//si "action" est mis dans la barre de recherche, et que "action" se trouve dans la classe du controleur choisi par l'utilisateur
		//sinon l'action est définie automatiquement à l'action par défaut du controleur choisi
	
		if(isset($_GET["action"]) && in_array($_GET["action"], get_class_methods(new $controleur()))) $action = $_GET["action"];
		else if(isset($_POST["action"]) && in_array($_POST["action"],get_class_methods(new $controleur()))) $action = $_POST["action"];
		else $action = $actionParDefaut[$controleur];
	
		$controleur::$action();
		
	}
	
?>