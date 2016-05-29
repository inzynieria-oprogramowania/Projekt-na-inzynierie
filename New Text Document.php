<?php
function polacz($uzytkownik, $haslo, $baza) {
	$sql = mysql_connect('localhost', $uzytkownik, $haslo);
	if(!($sql)) { echo "Nie mozna polaczyc sie z baza danych!"; exit(1); }
	$select = mysql_select_db($baza, $sql);
	if(!($select)) { echo "Brak stworzonej bazy danych!"; exit(1); }
}

echo "hej"
?>