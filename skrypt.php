<?php

function polacz($uzytkownik, $haslo, $baza) {
  $sql = mysql_connect('mysql.cba.pl', $uzytkownik, $haslo);
  if(!($sql)) { exit("Nie można połączyć się z bazą danych!</response>"); }
  $select = mysql_select_db($baza, $sql);
  if(!($select)) { exit("Nie można wybrać bazy!</response>"); }
}

function wygeneruj($tabela, $plik) {
  $dni = array("Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek");
  $data = $_GET['date'];
  $dzien = $_GET['dzien'];
  $wynik = mysql_query("select * from $tabela");
  $naglowek = "BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//hacksw/handcal//NONSGML v1.0//EN\nCALSCALE:GREGORIAN\n";
  $status = 0;
  $licznik = 0;

//sprawdzenie czy poprawnie wygenerowano ical 
$query=mysql_query("SELECT COUNT('przedmiot') AS razem FROM $tabela");
$a=mysql_fetch_array($query);

if($a['razem']!=0){

$plik = fopen("$plik", "w");
  if(!($plik)) { exit("Nie można otworzyć pliku!</response>"); }
  fwrite($plik, $naglowek);
  while($r = mysql_fetch_row($wynik)) {
    if (strstr($r[0], $dni[$licznik])) {
     $licznik++; 
continue;
    }elseif (strstr($r[0], $dni[$licznik+1])){
$licznik++;
      $dzien++;
      continue;
    }elseif (strstr($r[0], $dni[$licznik+2])){
    if($licznik > 0){
$licznik=$licznik+2;
$dzien= $dzien+3;
}else{
$licznik=$licznik+2;
      $dzien= $dzien+2;
      continue;
}
    }elseif (strstr($r[0], $dni[$licznik+3])){
$licznik=$licznik+3;
      $dzien= $dzien+3;
      continue;
    }elseif (strstr($r[0], $dni[$licznik+4])){
$licznik=$licznik+4;
      $dzien= $dzien+4;
      continue;
    }
    $identyfikator = uniqid();
    $czas = time();
    $godzina = str_replace(":","",$r[1]);
    $godzina = str_replace(" ","",$godzina);
    $godzina2 = str_replace(":","",$r[2]);
    $godzina2 = str_replace(" ","",$godzina2);
    $format = sprintf("%'.02d", $dzien);

    $kalendarz = "BEGIN:VEVENT
DTEND: $data"."$format"."T"."$godzina2"."00
UID: $identyfikator
LOCATION: $r[4]
SUMMARY: $r[3]
DTSTART: $data"."$format"."T"."$godzina"."00
END:VEVENT\n";
  
    fwrite($plik, $kalendarz);
  }
  
  echo 'Poprawnie wygenerowano plik ical';
  $zakonczenie = "END:VCALENDAR\n";
  fwrite($plik, $zakonczenie);
  fclose($plik);

}

else{
echo "Niepoprawnie wygenerowano plik ical. Naciśnij przycisk Reset, upewnij się, że link url jest poprawny, <br /> wybierz datę, a następnie wciśnij New";

}


}

function wypisz_naglowek($plik) {
  
if (file_exists($plik)) {

  echo "true";
  }else{
  echo "false";
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
  $i = 0;
  $dni = array("Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota", "Niedziela","Nieregularne");
  $r = 0;
  $status = 0;
  foreach($rows as $row) {

  
  
if($i == 0) { $i++; continue; }
  else {
    $cols = $row->getElementsByTagName('td');
    $zmienna1 = $cols->item(1)->nodeValue.' ';
    $zmienna0 = $cols->item(0)->nodeValue.' ';
    $zmienna2 = $cols->item(2)->nodeValue.' ';
    $zmienna3 = $cols->item(3)->nodeValue.' ';
    $zmienna4 = $cols->item(6)->nodeValue.' ';

if (strstr($zmienna0, $dni[5]) || strstr($zmienna0, $dni[6]) || strstr($zmienna0, $dni[7])) {break;}

    echo "$zmienna0 $zmienna1 $zmienna2 $zmienna3 $zmienna4 <br/>";
for($j=0; $j < 5; $j++){
    if (strstr($zmienna0, $dni[$j])) {
      mysql_query("insert into ical values ('$zmienna0','$zmienna1','$zmienna2','$zmienna3','$zmienna4')");
      $status = 1;
    }
}
if($status == 0){
  mysql_query("insert into ical values ('NULL','$zmienna1','$zmienna2','$zmienna3','$zmienna4')");
}
$status = 0;
    } 
  }
}

function wyczysc($nazwa_pliku){
  unlink($nazwa_pliku);
}  

  header('Content-Type: text/xml');
  echo '<?xml version="1.0" encoding="utf-8" standalone="yes"?>';
  echo '<response>';
  $nazwa = $_GET['adres'];
  polacz('kamil18213','projekt18213','projekt_io_cba_pl');
  switch ($nazwa)
  {
    case 'wygeneruj':
      wygeneruj('ical','kalendarz.ics');
      break;
    
    case 'wyczysc': 
      wyczysc('kalendarz.ics');
      mysql_query("delete from ical");
      break;
    
    case 'pobierz':
      wypisz_naglowek('kalendarz.ics');
      break;
    
    default:
      stworz($nazwa,'ical');
  
 }
echo '</response>';
?>		