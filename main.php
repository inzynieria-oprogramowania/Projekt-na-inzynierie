<!DOCTYPE html 
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<head>
	<link rel="stylesheet" type="text/css" href="css.css">
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="skrypt.js"></script>
</head>

<body>
	<div class="cialo">
		<div class="button-top">
			<input type="button" value="NEW" id = "new" onclick="nowy();"  />
			<input type="button" id="generate" value="Generate iCal" onclick="generuj();" /> 
		</div>
		<div class="url">
			<div id="url-image"></div>   <input type="text" id="url"/>
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
		</div>

		<div id="pole"> </div>
		<div class="button-bottom">
			<input type="button" value="Reset" id="reset" onclick="resetuj();"/> 
			<input type="button" value="Download iCal" id="download" onclick="pobierz();" />
		</div>
		<div id="informacja" /> </div>
		<div id="kod" /></div>
	</div>  
</body>
</html>