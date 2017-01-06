#Website hosten op Raspberry Pi (+https)
****
**Nu dat de website op mijn Raspberry Pi staat, kunnen we beginnen met het online te zetten. Om zelf thuis een website te kunnen hosten, moet u toegang hebben tot de router.**

##Website online krijgen (http)

###DNS

Om ervoor te zorgen dat mensen naar uw veranderlijk extern IP kunnen surfen moet je een domeinnaam aanmaken. Ik gebruikte hiervoor een gratis DNS service: **No-Ip**. 

Maak een account aan bij [No-Ip](https://www.noip.com).

Navigeer naar **my account** en dan **Dynamic DNS (free)**. Nu krijg je het volgende scherm te zien:

![dashboard](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/web_hosten/img/dashboard.png)

Hier klik je op Add Hostname. Nu krijg je volgende popup:

![hostname](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/web_hosten/img/hostname.png)

Kies uw gewenste **hostname** en **subdomain**. Als de domeinnaam beschikbaar is kan je op Add Hostname klikken. Je hebt nu een eigen DNS voor jouw website!

Er is wel nog een probleem: Het extern IP-adres van uw router verandert soms en deze DNS wijst naar uw huidig IP. Gelukkig heeft No-Ip hier een tooltje voor dat ons IP-adres geregeld gaat updaten op de No-Ip server. Dit tooltje (DUC) gaan we nu installeren op onze Raspberry Pi.

Log in op uw Raspberry Pi en navigeer naar volgende locatie:

<pre>
cd /usr/local/src/
</pre>

Hier gaan we DUC downloaden en installeren:

<pre>
sudo wget http://www.no-ip.com/client/linux/noip-duc-linux.tar.gz
</pre>

De gedownloade file uitpakken:

<pre>
tar xf noip-duc-linux.tar.gz
</pre>

We hebben nu een folder no-ip-2.1.9-1. We kunnen dus het origineel bestand (de .tar) verwijderen:

<pre>
sudo rm noip-duc-linux.tar.gz
</pre>

Navigeer naar de gecreëerde map:

<pre>
cd noip-2.1.9-1/
</pre>

Installeer het pakket:

<pre>
sudo make install
</pre>

Wanneer de installatie voltooid is, wordt er gevraagd om u in te loggen op No-Ip. Nu update de Raspberry Pi autonoom zijn extern ip zodat het ip gelinkt met onze domeinnaam altijd klopt. Toch alleszins tot we onze Pi herstarten... We moeten dit tooltje dus laten opstarten wanneer de Pi boot.

Navigeer naar **/etc**:

<pre>
cd /etc/
</pre>

Open rc.local:

<pre>
sudo nano rc.local
</pre>

En voeg de volgende lijn toe aan het bestand:

<pre>
#dns tool starten bij boot
sudo noip2
</pre>

Save de file en reboot de Pi. 
Je kan nu testen of het werkt door volgend commando uit te voeren:

<pre>
sudo noip2 -S
</pre>

Indien je een geldig PID hebt weet je dat de configuratie gelukt is. Nu gaat jouw domeinnaam altijd naar het juiste IP wijzen.

###Poort forwarden

Als je wilt dat uw website van buitenaf beschikbaar is zal je de nodige configuratie moeten doen in uw router. Zo moet je aan uw router zeggen dat je inkomende http requests wilt accepteren en doorverwijzen naar de Raspberry Pi. Onze webserver luistert naar **poort 80** voor http en **poort 443** voor https. Deze twee moeten we dus openen en forwarden naar het ip van onze Raspberry Pi (moet **statisch IP** hebben).

**OPMERKING: Volgende stappen zijn afhankelijk van uw ISP. In dit voorbeeld gebruik ik Proximus.**

Surf naar het IP-adres van uw router. In het geval van Proximus is dat standaard **192.168.1.1**. Je komt nu op de login van uw router. Het wachtwoord vindt u op de router zelf als **user password**. Als je bent ingelogd kom je op volged scherm uit:

![home pagina van Proximus](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/web_hosten/img/proximus1.png)

Navigeer naar **Access Control** en daar naar **Port Mapping**. Klik op **Create Portmap** en zet de service op HTTP, hierdoor wordt het protocol, de **external port start** en de interne poort automatisch juist gezet. Nu geef je bij **Internal Host** het IP in van uw Pi. Druk op enter en **Ok** om de instellingen op te slaan. Controleer of deze regel **enabled** is!

![Port map van Proximus](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/web_hosten/img/proximus2.png)

Dit zou genoeg moeten zijn om de server extern toegankelijk te maken. Indien dit niet het geval is (zoals bij mij), kan het zijn dat uw ISP standaard poorten 80 en 443 blokkeert. Nu heb je twee keuzes: forwarden naar een andere, niet geblokkeerde, externe poort of de instellingen van uw **Proximus account** aanpassen.

Om deze instelling te veranderen surf je naar de website van [Proximus](https://www.belgacom.be/login/nl/?ru=https%3A%2F%2Fadmit.belgacom.be%2Feservices%2Fwps%2Fmyportal%2FmyProducts%3F_ga%3D1.133387787.405385633.1449847048&pv=fls). Log in en, nu krijg je volgende pagina te zien:

![homepage proximus account](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/web_hosten/img/proximus_account1.png)

Klik op uw internet abonnement (in dit geval **Bizz Internet**). Nu kom je op de pagina waar we het internet abonnement kunnen beheren:

![Internet beheren](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/web_hosten/img/proximus_account2.png)

Navigeer naar **Technisch profiel**. Er opent zich een selectie menu waar je de keuze hebt tussen 2 technische profielen: **Basic** en **Normaal**. Kies hier **Basic (De inkomende poorten 80, 443 en 23 zijn geopend)** en klik op **Bevestigen**.

![Technisch profiel](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/web_hosten/img/proximus_account3.png)

Nu zou je van buitenaf toegang moeten hebben tot uw website (http). 

**OPMERKING: Mijn router (Proximus BBox3) liet niet toe dat ik poort 80 open zette. Dit deel en het volgende is dus niet toegepast op mijn eigen website. De oorzaak hiervoor is mij nog steeds onbekend.**

##Beveiligen met Let's Encrypt (https)

Nu dat onze website online staat moeten we ervoor zorgen dat wachtwoorden niet onderschept kunnen worden. Daarom beveiligen we onze webserver met Let's encrypt. We gaan onze ssl-certificaten genereren met **Certbot**.

###Download Certbot

We gaan **Python Certbot voor Apache** installeren:

<pre>
sudo apt-get install python-certbot-apache -t jessie-backports
</pre>

###Certificaten genereren

Het genereren van de certificaten is heel simpel. Start Certbot en volg de gegeven instructies.

<pre>
certbot-auto --apache
</pre> 

Let's encrypt certificaten blijven 90 dagen geldig. Je kan dit handmatig vernieuwen of gewoon volgend commando invoeren:

<pre>
certbot renew --dry-run
</pre>

Dat was alles! Nu zou mijn webserver geëncrypteerd zijn met ssl. Om te testen zou je nu nog naar uw website moeten surfen met **https://** ervoor.

###bronnen: 

- [http://readwrite.com/2014/06/27/raspberry-pi-web-server-website-hosting/](http://readwrite.com/2014/06/27/raspberry-pi-web-server-website-hosting/)
- [http://www.instructables.com/id/Host-your-website-on-Raspberry-pi/?ALLSTEPS](http://www.instructables.com/id/Host-your-website-on-Raspberry-pi/?ALLSTEPS)
- [http://www.proximus.be/support/nl/id_sfaqr_ports_unblock_secu/particulieren/support/internet/veiligheid-en-bescherming/uw-internetverbinding-beveiligen/internetpoorten-openen.html](http://www.proximus.be/support/nl/id_sfaqr_ports_unblock_secu/particulieren/support/internet/veiligheid-en-bescherming/uw-internetverbinding-beveiligen/internetpoorten-openen.html)
- [https://certbot.eff.org/#debianjessie-apache](https://certbot.eff.org/#debianjessie-apache)

