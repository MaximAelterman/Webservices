#Fail2Ban op Raspberry Pi

**Fail2Ban is een intrusion prevention framework. De bedoeling hiervan is om het IP van hackers die brute-force proberen in te breken in uw server, te bannen.**

###Installatie

Installeer fail2ban door volgend commando uit te voeren:

<pre>
sudo aptitude install fail2ban
</pre>

Als de installatie voltooid is, kopiëer je de jail.conf file naar jail.local. Hier gaan we in werken.

<pre>
sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local
</pre>

###Configuratie

Open deze file:

<pre>
sudo nano /etc/fail2ban/jail.local
</pre>

Hier vindt u alle settings die je kan aanpassen. We gaan eerst naar de **[DEFAULT]** settings. Ik heb hier het IP van de localhost ingezet zodat je niet van uw eigen server geband kunt worden.

<pre>
[DEFAULT]
ignoreip = 127.0.0.1
</pre>

Lager in deze file kan je kiezen waar fail2ban op mag werken en hoe lang een IP banned mag zijn. Voor mijn project heb ik de detectie aan gezet voor **ssh**, **Apache** en **mysql**.

<pre>
[ssh]
enabled = true
...
[apache]
enabled = true
...
[mysqld-auth]
enabled = true
</pre>

Wanneer je de jails hebt ingesteld naar uw normen, moet je de fail2ban service herstarten zodat de instellingen ingeladen worden:

<pre>
sudo service fail2ban restart
</pre>

###Gebruik

Nu Fail2Ban geïnstalleerd en geconfigureerd is kan je de banned IPs zien met volgend commano:

<pre>
sudo iptables -L
</pre> 

Je kan ook handmatig IPs bannen en unbannen:

<pre>
sudo fail2ban-client set &lt;jail&gt; banip/unbanip &lt;ip address&gt;

#bijvoorbeeld:
sudo fail2ban-client set sshd unbanip 83.136.253.43
</pre>

###bronnen

- [https://www.upcloud.com/support/installing-fail2ban-on-debian-8-0/](https://www.upcloud.com/support/installing-fail2ban-on-debian-8-0/)