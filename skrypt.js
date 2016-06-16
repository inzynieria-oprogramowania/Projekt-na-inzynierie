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
	    document.getElementById("pole").innerHTML = xmlHttp.responseText + '<br />';
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
function wygeneruj()
{
    if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
	{
	    dane2 = xmlHttp.responseXML;
	    glowny2 = dane2.documentElement;
	    tekst2 = glowny2.firstChild.data;
	    document.getElementById("kod").innerHTML = '<i>' + tekst2 + '</i>';
	}
}

function resetuj()
{
    xmlHttp.open("GET", "skrypt.php?adres=wyczysc", true);
    xmlHttp.onreadystatechange = wyczysc;
    xmlHttp.send(null);
}
function wyczysc()
{
    document.getElementById("pole").innerHTML = '';
    document.getElementById("kod").innerHTML = '';
}



function pobierz()
{
  
    xmlHttp.open("GET", "skrypt.php?adres=pobierz", true);
    xmlHttp.onreadystatechange = pobranie;
    xmlHttp.send(null);


}

function pobranie()
{
    if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
	{
	    dane3 = xmlHttp.responseXML;
	    glowny3 = dane3.documentElement;
	    tekst3 = glowny3.firstChild.data;
            if(tekst3 == "true"){
              window.location = 'kalendarz.ics';
            }else{
              document.getElementById("kod").innerHTML = '<i>' + 'Plik ical nie istnieje, należy go wygenerować' + '</i>';
            }
	}
}
 	