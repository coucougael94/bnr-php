<pre><?php

/* Pour la gestion d'erreur */
function _exit($ln){
	var_dump($GLOBALS);
	die('ERREUR ON-LINE '.$ln);
}

/* Pour l'utilisation d'IP (pour les connections locale + externe + avec proxi) */
function get_ip() {return (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];}

$bdd = new PDO('mysql: host=telligo.obicorp.fr;dbname=lucas','lucas','TelligoBn');$bdd->query("SET NAMES UTF8");

$id_game = (isset($_POST['id_game']))? filter_var($_POST['id_game'], FILTER_SANITIZE_NUMBER_INT):'0';

//Récupération de tout les emplacements de torpille
$RsTorpilles = $bdd->query("SELECT * FROM torpilles WHERE id_game = $id_game GROUP BY ip_lanceur");

if($RsTorpilles->rowCount() == 0){
	_exit(__LINE__);
}

//Récupération des données de la partie
$RsGame = $bdd->query("SELECT * FROM games WHERE id = $id_game");
$game  = $RsGame->fetch();
var_dump($game); // 'id', 'joueur1_ip', 'joueur2_ip', 'nbColonne'

if($RsGame->rowCount() == 0){
	_exit(__LINE__);
}

$RsBateaux = $bdd->query("SELECT * FROM bateaux WHERE id_game = $id_game GROUP BY ip_possesseur");

if($RsBateaux->rowCount() == 0){
	_exit(__LINE__);
}

$bateaux = $RsBateaux->fetch();

$listBateaux = [];

// Aucune imagination
$listeDePossibilitéPourX = array("A", "B", "C");

for($i = 0;$i < sizeof($bateaux); $i++){
	$bateauRanges = explode(';', $bateaux['caseRange']);
	for($j = 0; $j < sizeof($bateauRanges); $j++){
		if($j == 0 && !empty($bateauRanges[$j+1]))
			$listBateaux[$bateaux['ip_possesseur']][$bateauRanges[$j]] = "B";
		elseif($j == 0 && !empty($bateauRanges[$j+$game['nbColonne']]))
			$listBateaux[$bateaux['ip_possesseur']][$bateauRanges[$j]] = "2";
		elseif($j != 0 && !empty($bateauRanges[$j-1]) && array_search($bateauRanges[$j-1][0], $listeDePossibilitéPourX))
			$listBateaux[$bateaux['ip_possesseur']][$bateauRanges[$j]] = "-";
			//Suite du bateau
	}
/* Pour chaque case avec des bateaux, remplir le tableau avec l'index */
	$listBateaux[$bateaux['ip_possesseur']][] = explode(';', $bateaux['caseRange']);
}

/**
 * listBateaux est sous forme :
 *  - 'joueur1_ip'
 *      - bateaux1 select 1
 * 			- case n°1
 * 			 ...
 * 		- ...
 * - joueur2
 * 	  - ...
 */

$tableAdverse = [];
$tableMe	  = [];

for($i = 1;$i < intval($game['nbColonne']); $i++){
	$listBateaux[get_ip()] = ;
	$tableAdverse[i] = "**";
	//$tableMe[] 		= "**";
}

for($i= 0;$i < intval($game['nbColonne']); $i++){
	$tableAdverse[] = "**";
	$tableMe[] 		= "**";
}

while ($Torpilles = $RsTorpilles->fetch())
{
	//
}
