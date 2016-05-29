<?php

function polacz($uzytkownik, $haslo, $baza) {
  $sql = mysql_connect('localhost', $uzytkownik, $haslo);
  if(!($sql)) { echo "Nie mozna polaczyc sie z baza danych!"; exit(1); }
  $select = mysql_select_db($baza, $sql);
  if(!($select)) { echo "Brak stworzonej bazy danych!"; exit(1); }
}



function wypisz_naglowek($plik) {
  if (file_exists($plik)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($plik).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($plik));
  }
}

?>