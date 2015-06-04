<?php
// setup the autoloading
require_once '/vendor/autoload.php';

// setup Propel
require_once '/generated-conf/config.php';
//wir definieren die Konstanten um den R�ckgabewert kontrollieren zu k�nnen
define("LOGIN_PWFALSE", 1);
define("LOGIN_USERFALSE", 2);
function Benutzer_login($username,$passwort) {
//Wir suchen den Benutzer mit dem Namen $username aus der Datenbank
	$userQ = new UserQuery();
	//username muss nicht �berpr�ft werden, da Propel die Sicherheitsmechanismen �berpr�ft.
	$user = $userQ->findOneByBenutzername($username);
	if(!is_null($user)){
		if ($user->getPasswort() == $passwort){
		//Daten korrekt, Login wird ausgef�hrt
			return $user;
		}else{
		//Das Passwort passt nicht zum Benutzer
			return LOGIN_PWFALSE;
		}
	}
	
	
	//Es wurde kein Benutzer mit dem Namen $user gefunden
	return LOGIN_USERFALSE;
		
}
?>