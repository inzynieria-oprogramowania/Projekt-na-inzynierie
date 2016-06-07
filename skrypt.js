var xmlHttp = new XMLHttpRequest();
function nowy()
{
    adres = encodeURIComponent(document.getElementById("url").value);
    xmlHttp.open("GET", "skrypt.php?adres=" + adres, true);
    xmlHttp.onreadystatechange = odpowiedz;
    xmlHttp.send(null);
}
function odpowiedz()
{
    if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
	{
	     dane = xmlHttp.responseXML;
	     glowny = dane.documentElement;
	     tekst = glowny.firstChild.data;
	    document.getElementById("pole").innerHTML = '<i>' + tekst + '</i>';
	}
}
function generuj()
{
    var dzien = document.getElementById("dzien").value;
    var miesiac = document.getElementById("miesiac").value;
    var rok = document.getElementById("rok").value;
    xmlHttp.open("GET", "skrypt.php?adres=wygeneruj&date=" + rok + miesiac + "&dzien=" + dzien, true);
    xmlHttp.onreadystatechange = wygeneruj;
    xmlHttp.send(null);
}
