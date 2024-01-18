# piratebox-cohabit

* La piratebox c'est quoi ?
Une sorte de serveur qui permet de crée un tchat et de partager des fichiers sans passer par internet directement
* Comment resoudre le probleme ?
Il suffit tout simplement d'installer un serveur web sur le raspberry Pi et de coder une page web qui permettrai l'acces au fichier C'EST SI SIMPLE QUE CA

1- Installation d'ubuntu server sur le raspberry pi
2- Installation d'Apache et de vsftpd sur le serveur
<pre><code class="shell">
sudo apt install vsftpd
sudo apt install apache2

# config apache
sudo nano /etc/apache2/sites-available/piratebox.conf
```
 <VirtualHost *:80>
    ServerAdmin lunarsol@duck.com
    ServerName piratebox.com
    DocumentRoot /var/www/piratebox.com
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>   
```


sudo mkdir /var/www/piratebox.com #Création du dossier
sudo chown -R $USER:$USER /var/www/piratebox.com #Attribution de la propriete du dossier
sudo chmod -R 755 /var/www/piratebox.com #Autorisation de lecture ecriture execution

sudo a2dissite 000-default #desactiver le template par defaut
sudo a2ensite piratebox.conf #activer le site
sudo service apache2 restart #restart apache pour mettre a jour les perm
systemctl reload apache2 
</pre></code>
