<?php

class Session{
    public static function userConnected(){
        if(isset($_SESSION["mailUtilisateur"])) return true;
        return false;
    }

    public static function userConnecting(){
        if(isset($_GET["action"]) && $_GET["action"]=="connecterUtilisateur") return true;
        return false;
    }
}