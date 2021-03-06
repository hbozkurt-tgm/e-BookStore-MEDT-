<?php
//Zweck : Steuerfile fue Registrierung
//Autor: Gligorevic Nenad
//Datum 20150505

error_reporting(E_ALL);
ini_set('display_errors', '1');

//session_start();
//$error = '';   //Fehlermeldungen
//$notice = '';   //Hinweismeldungen
// setup the autoloading
//require_once ("/home/schueler/propelProjects/vendor/autoload.php");
// setup Propel
//require_once ("/home/schueler/propelProjects/ebookstore/generated-conf/config.php");

function Benutzer_registrieren($bname,$pw) {
	$user = new User();

	$user -> setBenutzername($bname);
	$user -> setPasswort($pw);
	$user -> setRolle(0);
	//Speichert alle Aenderungen
	$user -> save();
}

if (isset($_POST['reg_btn'])) {
	//Eingaben in Variablen speichern
	$uname = ($_POST['uname']);
	$pw1 = ($_POST['pw1']);
	$pw2 = ($_POST['pw2']);
	$userquery = new UserQuery();	
	//Falls es bereits den selben Benutzer gibt
	//soll in die Vaariable $Fm geschrieben werden.
	$error = "".$userquery->findOneByBenutzername($uname);

	//Nichts darf leer sein
	if ($uname != "" && $pw1 != "" && $pw2 != ""){
		//Wenn die $error nicht leer ist dann gibt
		//es bereits einen Benutzer
		if ($error != "") {
			$error = "Dieser Benutzername existiert bereits<br>";
			//include 'form.html';
			echo($error);
		} else {
			//Passwoerter muessen uebereinstimmen
			if ($pw1 == $pw2) {
				//Benutzer wird registriert in DB
				Benutzer_registrieren($uname, $pw1);
				//Nachdem der Benutzer erfolgreich registriert
				//wurde wird er auf die naechste Seite geschickt.
				//header('location: erfolgreich_reg.html');
				$notice = "Erfolgreich registriert";
				echo($notice);
			} else {
				//Wenn die Passwoerter nicht uebereinstimmen
				//den bekommt der Benutzer eine Hinweismeldung und
				//es wird ein css File includiert welches die Felder
				//rot umrandet damit der Benutzer sieht wo der Fehler liegt.
				$error = "Passw&ouml;rter stimmen nicht &uuml;ber ein!";
				//?>
				//<style>
				//<?php include 'css/error.css'; ?>
				//</style>
				//<?php
				//include 'form.html';
			}
		}
	} else {
		//Falls die Eingaben leer sind kriegt der
		//Benutzer eine Hinweis Meldung
		$error = "Eingaben sind leer<br><br>";
		//include 'form.html';
	}

} else {
//Wenn Button nicht gedrueckt wird soll Html Seite
//trotzdem includet werden
	//include 'form.html';
}
?>
