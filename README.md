# Installazione

Mi sposto in una cartella di lavoro dove ho i permessi di scrittura:

	cd /home/md/temp

Faccio checkout del codice ( verifica di usare il ramo giusto ):

	git clone https://github.com/ManyDesigns/spid-cie-php
	cd spid-cie-php
	git checkout dev_NEW


Sposto tutto sul percorso di destinazione:

	cd /home/md/temp
	sudo cp -rp spid-cie-php/ /srv/
	cd /srv
	sudo mv /spid-cie-php spid

---

A questo punto mi aspetto che i file siano di proprietà dell'utente `md:md`. Deve essere così per consentirmi di fare tutto il processo di configurazione. Ci occuperemo al termine della procedura di sistemare le permissions.

Creo / copio / modifico il file di setup:

	cd /srv/spid
	vi spid-php-setup.json 

Ripeto: prima di procedere, il file qui sopra va verificato e opportunamente modificato. A volte il setup si blocca ( per problemi del proxy o magari perché non sono proprio raggiungibili i siti di AGID ).

Se già disponibili, copio i certificati nella cartella di destinazione:

	mkdir /srv/spid/cert
	cp /already/available/cert/* /srv/spid/cert

---

Imposto le variabili di ambiente per utilizzare il proxy di Galliera durante la configurazione:

	export https_proxy=http://proxy.galliera.it:3128
	export http_proxy=http://proxy.galliera.it:3128

Se sono dietro al proxy di Galliera, patcho i file che fanno richieste verso l'esterno:

	cd /srv/spid
	cp setup/Setup.php.GALLIERA setup/Setup.php
	cp setup/sdk/proxy-spid-php.GALLIERA.tpl setup/sdk/proxy-spid-php.tpl

NOTA: i files qui sopra devono differire solo nell'uso del proxy Galliera per le chiamate file_get_contents().

---

E finalmente:

	composer install

Mi raccomando, verifica l'output del comando per individuare ( e quindi correggere ) eventuali problemi.


# Post install

## Fix spid-php-proxy.json

Quando viene creato il file `spid-php-proxy.json`, anche se nel `spid-php-setup.json` sono stati dichiarati diversi client, viene creato con un solo client.

E' quindi necessario controllare ed eventualmente modificare a mano il file.