# Studi_ECF_Arcadia_Zoo

Bienvenue dans le projet Arcadia Zoo. Ce projet vise à développer un site interactif, intuitif et moderne pour le zoo d'Arcadia. Il fournit une plateforme destinée aux clients pour qu'ils puissent trouver toutes les informations nécessaires à leur séjour et permet aux employés du zoo de gérer le site internet et de fournir des informations sur les animaux.

Prérequis
Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

Git - Pour cloner le projet depuis GitHub.
WampServer64 - Pour héberger le serveur web local et la base de données.
Visual Studio Code - Pour éditer et gérer le code source.
Navigateur Web - Pour accéder à l'application web.

Installation
1. Cloner le Dépôt GitHub
Clonez le dépôt du projet depuis GitHub dans votre répertoire local :

"git clone https://github.com/votre-utilisateur/arcadia-zoo.git
cd arcadia-zoo"

2. Configurer le Serveur Web Local (WampServer64)
Téléchargez et installez WampServer depuis wampserver.com. Une fois installé, démarrez WampServer et placez le répertoire cloné arcadia-zoo dans le répertoire www de WampServer :

C:\wamp64\www\arcadia-zoo

3. Importer la Base de Données
Ouvrez PHPMyAdmin en accédant à http://localhost/phpmyadmin dans votre navigateur.
Créez une nouvelle base de données nommée arcadia_zoo.
Importez le fichier SQL de la base de données inclus dans le dépôt GitHub. Le fichier SQL se trouve dans le répertoire database.

4. Configurer les Informations de Connexion à la Base de Données
Modifiez les fichiers de connexion à la base de données pour utiliser vos informations locales. Ouvrez les différent fichiers pdo.php et mettez à jour les informations de connexion :

    $pdo = new PDO('mysql:host=localhost;dbname=arcadia_zoo', 'username', 'password', [

Assurez-vous que les informations host, dbname, username et password correspondent à votre configuration locale.

5. Démarrer le Serveur Web Local
Assurez-vous que WampServer est en cours d'exécution. Accédez à l'application web en ouvrant votre navigateur et en entrant l'URL suivante :

http://localhost/arcadia-zoo

Fonctionnalités
Gestion des Animaux : Ajout, modification et suppression d'animaux. Téléchargement sécurisé des images.
Gestion des Services : Ajout, modification et suppression des services offerts par le zoo.
Administration des Avis : Validation et suppression des avis des clients.
Gestion des Horaires : Mise à jour des horaires d'ouverture du zoo.

Merci - J'espère que le projet vous plaira. 

Très bonne navigation 
Thomas
