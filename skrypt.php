<?php

function polacz($uzytkownik, $haslo, $baza) {
  $sql = mysql_connect('localhost', $uzytkownik, $haslo);
  if(!($sql)) { exit("Nie można połączyć się z bazą danych!</response>"); }
  $select = mysql_select_db($baza, $sql);
  if(!($select)) { exit("Nie można wybrać bazy!</response>"); }
}

function wygeneruj($tabela, $plik) {
  $data = $_GET['date'];
  $dzien = $_GET['dzien'];
  $wynik = mysql_query("select * from $tabela");
  $naglowek = "BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//hacksw/handcal//NONSGML v1.0//EN\nCALSCALE:GREGORIAN\n";
  $plik = fopen("$plik", "w");
  if(!($plik)) { exit("Nie można otworzyć pliku!</response>"); }
  fwrite($plik, $naglowek);
  echo $naglowek;
  $i = 0;
  while($r = mysql_fetch_row($wynik)) {
    if($i == 0 || $i ==1) {
      $i++;
      continue;
    }
    if(!(strstr($r[0],":"))) {
      $dzien++;
      continue;
    }
    $identyfikator = uniqid();
    $czas = time();
    $godzina = str_replace(":","",$r[0]);
    $godzina = str_replace(" ","",$godzina);
    $godzina2 = str_replace(":","",$r[1]);
    $godzina2 = str_replace(" ","",$godzina);
    $format = sprintf("%'.02d", $dzien);

    $kalendarz = "BEGIN:VEVENT
DTEND: $data"."$format"."T"."$godzina2"."00
UID: $identyfikator
DTSTAMP: $czas 
LOCATION: $r[3]
DESCRIPTION: $r[2]
DTSTART: $data"."$format"."T"."$godzina"."00
END:VEVENT\n";

    echo $kalendarz;
    fwrite($plik, $kalendarz);
  }
  $zakonczenie = "END:VCALENDAR\n";
  echo $zakonczenie;
  fwrite($plik, $zakonczenie);
  fclose($plik);
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

function stworz($nazwa, $tabela) {
  urldecode($nazwa);
  $url = @file_get_contents($nazwa,true);
  if($url === FALSE) { exit("Nieprawidlowy URL!</response>"); }
  mysql_query("delete from $tabela");
  $dom = new domDocument;
  $dom->loadHTML($url);
  $dom->preserveWhiteSpace = false;
  $tables = $dom->getElementsByTagName('table');
  $rows = $tables->item(1)->getElementsByTagName('tr');
  foreach($rows as $row) {
    $cols = $row->getElementsByTagName('td');
    $zmienna1 = $cols->item(1)->nodeValue.' ';
    $zmienna2 = $cols->item(2)->nodeValue.' ';
    $zmienna3 = $cols->item(3)->nodeValue.' ';
    $zmienna4 = $cols->item(6)->nodeValue.' ';
    echo "$zmienna1 $zmienna2 $zmienna3 $zmienna4";
    mysql_query("insert into ical values ('$zmienna1','$zmienna2','$zmienna3','$zmienna4')");
  }
}


  header('Content-Type: text/xml');
  echo '<?xml version="1.0" encoding="utf-8" standalone="yes"?>';
  echo '<response>';
  $nazwa = $_GET['adres'];
  polacz('root','pokurwa','projekt');
  switch ($nazwa)
  {
    case 'wygeneruj':
      wygeneruj('ical','kalendarz.ical');
      break;
    
    case 'wyczysc': 
      mysql_query("delete from ical");
      break;
    
    case 'pobierz':
      wypisz_naglowek('kalendarz.ical');
      break;
    
    default:
      stworz($nazwa,'ical');
  
 }
echo '</response>';
?>