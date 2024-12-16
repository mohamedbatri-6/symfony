## lancer le Blog
# Prérequis
•	PHP 8.0 ou plus
•	Composer
•	Symfony CLI

## Installation
# Installer les dépendances
Installez les dépendances PHP avec Composer :

( composer install )

## Configurer la base de données
Modifier le fichier .env à la racine du projet et configurez les identifiants de votre base de données :
(DATABASE_URL="mysql://utilisateur:motdepasse@127.0.0.1:3306/nom_de_la_base")

## Lancer le serveur de développement
Démarrez le serveur de développement Symfony :

symfony server:start

## Fonctionnalités
# Articles et commentaires
•	Sur la page d'accueil, les  articles sont affichés.
•	Les articles et les commentaires sont affichés du plus récent au plus ancien 

## Formulaires
•	Validation stricte des données dans les formulaires :
o	Adresse email et mot de passe pour l'inscription et la connexion.
o	Contenu du commentaire lors de sa création.

## Gestion des commentaires
•	Les utilisateurs connectés peuvent ajouter des commentaires.
