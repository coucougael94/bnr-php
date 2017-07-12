<pre><?php

include 'case.class.php';

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


$cases = array();
for($i=0;$i < pow($game['nbColonne'], 2);$i++){
	$cases[] = Case();
}

