Site Annale Étudiante


Site web de publication et consultation d’annales étudiantes

Ce projet a été développé pour une association afin de centraliser les annales étudiantes de différentes matières. L’objectif est de permettre aux professeurs et aux étudiants de publier des documents tout en offrant un accès libre à la consultation pour tous.


Fonctionnalités principales

  Consultation libre : Les annales peuvent être consultées par tous, sans connexion.
  
  Publication sécurisée : Les professeurs et étudiants connectés peuvent publier des annales.
  
  Drag & Drop : Interface intuitive pour déposer les fichiers.
  
  Organisation par matière : Les annales sont classées par matière pour faciliter la recherche.
  
  Front-end dynamique : Utilisation de Vue.js pour une interface réactive et moderne.
  
  Back-end robuste : Symfony gère la logique serveur, la base de données et l’authentification.
  

Limitations actuelles

  Les forums pour chaque annale ne sont pas encore implémentés.
  
  Gestion des droits d’auteur non finalisée : actuellement, l’auteur affiché est “User propriétaire”. Il est recommandé que l’association mette en place un mécanisme où le nom réel du professeur apparaisse sur l’annale lors de la publication.
  
  Ce projet a été livré en l’état pour le stage, certaines fonctionnalités restent à améliorer (forums, notifications, vérification des droits).
  

Technologies utilisées

  Back-end : Symfony (PHP)
  
  Front-end : Vue.js
  
  Base de données : MySQL / Doctrine ORM
  
  Autres outils : HTML, CSS, JavaScript, drag & drop pour l’upload des fichiers
  


------ Installation et utilisation ------
Cloner le dépôt :

  git clone https://github.com/<votre-utilisateur>/site-annale-etudiante.git


Installer les dépendances Symfony :

  composer install


Installer les dépendances front-end (Vue.js) :

  npm install
  
  npm run build


Configurer la base de données dans ".env"

Lancer le serveur Symfony :

  symfony server:start


Accéder à l’application via http://localhost:8000


Objectif du dépôt GitHub

  Ce dépôt contient l’intégralité du code source du projet. Il permet à d’autres développeurs ou futurs stagiaires de reprendre le projet, de corriger les limitations et d’ajouter de nouvelles fonctionnalités pour l’association.
