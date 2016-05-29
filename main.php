<!DOCTYPE html 
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<script type="text/javascript" src="skrypt.js"></script>
</head>

<body leftmargin="200" rightmargin="200" marginwidth="200">
    <input type="button" value="NEW" onclick="nowy();" />
    <input type="button" value="Generate iCal" onclick="generuj();" /> <br /> <br />
    Adres URL:<input type="text" id="url" />
    Data:
    <?php
echo '<select id="dzien">';
for ($day = 1; $day <= 9; $day++)
echo "<option> 0$day </option>";
for ($day = 10; $day <= 31; $day++)
echo "<option> $day </option>";
echo '</select>';
echo '<select id="miesiac">';
for ($month = 1; $month <= 9; $month++)
echo "<option> 0$month </option>";
for ($month = 10; $month <= 12; $month++)
echo "<option> $month </option>";
echo '</select>';
echo '<select id="rok">';
for ($year = 2016; $year <= 2050; $year++)
echo "<option> $year </option>";
echo '</select>'; 
?>
    <div id="pole" width = '400px' height ='200px'> </div>
    <input type="button" value="Reset" onclick="resetuj();"/> 
    <input type="button" value="Download iCal" onclick="pobierz();" />
    <div id="informacja" />
    <div id="kod" />
</body>
</html>
