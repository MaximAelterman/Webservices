# Installatie Laravel met Xammp voor Windows

****

**Deze guide gaat er vanuit dat Xampp reeds geinstalleerd is. Indien dit niet het geval is kan u Xampp [hier](https://www.apachefriends.org/index.html "Download Xampp") downloaden.**


##1) Composer 

Composer is een PHP package manager dat wordt gebruikt voor Laravel. Dit kunnen we gemakkelijk installeren door de executable te downloaden:

[Download pagina Composer](https://getcomposer.org/download/ "Composer downloads")

Nu kunt u de installatie van Composer testen. Open een terminal venster en roep het commando "composer" op. Dit zou, indien de installatie gelukt is, het volgende venster moeten opleveren.

![Composer1.png](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/laravel_install/img/composer1.PNG "Composer installatie gelukt")

##2) Xampp virtual host

C:\xampp\apache\conf\extra\httpd-vhosts.conf

<pre>
#VirtualHost for LARAVEL.DEV

&lt;VirtualHost laravel.dev:80&gt;
    DocumentRoot "C:\xampp\htdocs\laravel\public"
    ServerAdmin laravel.dev
    &lt;Directory "C:\xampp\htdocs\laravel"&gt;
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    &lt;/Directory&gt;
&lt;/VirtualHost&gt;
</pre>

C:\Windows\System32\drivers\etc --> hosts file

<pre>
127.0.0.1    laravel.dev
</pre>

##3) Laravel framework installeren

Open een terminal venster en navigeer naar de htdocs map in C:\Xampp. Geef hier het volgende commando in:

<pre>
composer create-project laravel/laravel laravel "5.1.*"
</pre>

Dit commando geeft Composer de opdracht om het framework te installeren.
Dit zou een paar minuten moeten duren. Hierna is er, als alles goed is verlopen, de map "laravel" aangemaakt.

Om de installatie te testen kunt u nu xampp opstarten. Hier start u dan de apache en de mysql services. Als u nu een browser opent en "laravel.dev" ingeeft zal u volgende testpagina moeten te zien krijgen.

![laravel_home.png](https://raw.githubusercontent.com/MaximAelterman/Webservices/master/laravel_install/img/laravel_home.PNG "Laravel installatie gelukt")

Laravel is nu geinstalleerd in Xampp!