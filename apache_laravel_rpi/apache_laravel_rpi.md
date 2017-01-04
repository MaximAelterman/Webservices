#Apache 2 + Laravel op raspberry pi 2 en 3
****
**Nu gaan we een webserver installeren op onze raspberry pi met als doel later onze website zelf thuis te kunnen hosten.**

**OPMERKING: Indien een van de volgende installatie-pakketten nit beschikbaar zijn doe volgend commando:**

<pre>
sudo apt-get update && sudo apt-get upgrade
</pre>

##1) Apache 2

Apache is de webserver dat we gaan gebruiken omdat deze compatiebel is met het Laravel-framework.

We beginnen met apache2 te installeren:
<pre>
sudo apt-get install apache2 apache2-utils
</pre>

Nu gaan we de server configureren zodat we Laravel kunnen gebruiken met Apache:

###Mod-Rewrite

<pre>
sudo a2enmod rewrite
</pre>

###Allow override

Open de config file van apache als root:
<pre>
sudo nano /etc/apache2/apache2.conf
</pre>

En verander "AllowOverride None" naar "AllowOverride All":

<pre>
&lt;Directory /var/www/&gt;
Options Indexes FollowSymLinks
AllowOverride All
Require all granted
&lt;/Directory&gt;
</pre>

###Standaard site folder veranderen (optioneel)

Ik heb de "home" folder van mijn website veranderd zodat ik op meteen op de index pagina van de website kom als ik naar de server surf. 
Dit is optioneel, indien je dit **niet** doet zal je wanneer je naar de server surft een file structuur te zien krijgen. Hier moet je dan handmatig naar "/laravel/public" navigeren om je site te zien te krijgen.

Open de config files van uw website en verander de **DocumentRoot** naar **/var/www/laravel/public**

<pre>
DocumentRoot /var/www/laravel/public
</pre>

###Geef www-data rechten

Nu moeten we ervoor zorgen dat www-data de map waar onze site in komt kan gebruiken:

<pre>
sudo chown -R www-data:www-data /var/www/
</pre>

Ten slotte herstart je apache zodat de nieuwe configuratie geladen wordt.

<pre>
sudo /etc/init.d/apache2 restart
</pre> 

##2) MySQL

We moeten ervoor zorgen dat we aan onze database kunnen. Ik heb in mijn project MySQL gebruikt en moet dit dus ook op mijn Pi installeren.

MySQL installeren is snel gebeurt:

<pre>
sudo apt-get install mysql-server
</pre>

Tijdens het installeren opent er zich een GUI waar een wachtwoord gevraagd wordt voor de root user.

![mysql_gui.png](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/apache_laravel_rpi/img/mysql_gui.png)

Na de installatie moet je de mySQL client nog installeren:

<pre>
sudo apt-get install mysql-client
</pre>

###phpMyAdmin
Om gemakkelijk mijn database te beheren heb ik ook phpmyadmin geinstalleerd.
<pre>
sudo apt-get install phpmyadmin
</pre>

Tijdens de installatie zal er gevraagd worden welke webserver je geinstalleerd hebt. In ons geval kiezen we dus apache2.

Wanneer volgen venster gegeven, kies je **Yes**.

![phpmyadmin.jpg](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/apache_laravel_rpi/img/phpmyadmin.jpg)

Ten laatste wordt er gevraagd om een root wachtwoord in te stellen. Ik heb gewoon het zelfde wachtwoord gebruik als bij de apache installatie.

###Includen in apache installatie

phpMyAdmin installeren is niet voldoende om het te laten werken met apache. Open de apache2 conf file:

<pre>
sudo nano /etc/apache2/apache2.conf
</pre>

Helemaal onderaan in de file voeg je volgende regel toe: (tip: CTRL + V om per pagina naar beneden te scrollen)

<pre>
Include /etc/phpmyadmin/apache.conf
</pre>

Herstart vervolgens je apache server zodat de configuratie wordt toegepast:

<pre>
sudo /etc/init.d/apache2 restart
</pre>

Als je nu naar uw website surft en er **/phpmyadmin** achter zet, kom je op de login van phpmyadmin uit!

##3) PHP

PHP installeren is zeer simpel maar belangrijk. Volgend commando installeert alles wat je nodig hebt:

<pre>
sudo apt-get install php5 php5-cli libapache2-mod-php5 php5-mysql php5-curl php5-gd php-pear php5-imagick php5-mcrypt php5-memcache php5-mhash php5-sqlite php5-xmlrpc php5-xsl php5-json php5-dev libpcre3-dev
</pre>


##4) Laravel

Eerst installeren we composer:

<pre>
sudo curl -sS https://getcomposer.org/installer | php
</pre>

Wanneer de installatie afgerond is, gebruiken we Composer om laravel te installeren:
<pre>
sudo ~/composer.phar global require "laravel/installer"
</pre>

Nu Laravel geinstalleerd is op mijn Pi, kan ik het laravel project dat ik al gemaakt had in de **/var/www** folder kopiëren. Als ik nu naar het Ip van mijn Pi surf, kom ik op mijn Laravel website uit.



###bronnen: 
- https://www.stewright.me/2012/09/tutorial-install-phpmyadmin-on-your-raspberry-pi/
- http://valentinvannay.com/2016/01/21/installation-of-a-web-server-and-laravel-5-on-a-raspberry-pi-2/
