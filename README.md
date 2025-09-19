# Projet PRWB 2021 - Trello

# Trello-Clone

Une application web inspirée de Trello permettant de gérer des tableaux, des listes et des cartes pour organiser des tâches et projets.

---

## 🚀 Table des matières

- [À propos](#à-propos)  
- [Technologies utilisées](#technologies-utilisées)  
- [Fonctionnalités](#fonctionnalités)  
- [Installation & utilisation](#installation--utilisation)  
- [Architecture du projet](#architecture-du-projet)  
- [Limitations & améliorations possibles](#limitations--améliorations-possibles)

---

## À propos 

Ce projet est une reproduction simplifiée de Trello réalisé dans le cadre d'un projet scolaire, en collaboration avec un autre étudiant, développé pour mettre en pratique mes compétences en **PHP, JavaScript, MySQL, HTML et CSS**.  

Il permet de créer des tableaux de projet, gérer des listes et des cartes, et collaborer sur les tâches de manière structurée.  

---

## Technologies utilisées

### Backend
- **Langage** : PHP  
- **Architecture** : MVC (Router + Controllers + Views)  
- **Base de données** : MySQL  
- **Configuration** : fichiers `dev.ini` et `prod.ini` avec la classe `Configuration`  
- **Serveur local recommandé** : XAMPP, WAMP, MAMP  

### Frontend
- **Langages** : HTML, CSS, JavaScript  
- **Structure** : Pages statiques générées par PHP  
- **Librairies** : Bootstrap

---

## Fonctionnalités

1. **Gestion des tableaux**
   - Création, édition et suppression de tableaux  
   - Affichage des tableaux auxquels l’utilisateur appartient
   - intercation en drag & drop pour restructurer la mise en page

2. **Gestion des listes**
   - Ajout, modification et suppression de listes dans chaque tableau  

3. **Gestion des cartes**
   - Création, édition et suppression de cartes  
   - Déplacement des cartes entre listes (si implémenté)
   - intercation en drag & drop pour restructurer la mise en page


4. **Authentification**
   - Connexion et déconnexion des utilisateurs  
   - Gestion des utilisateurs pour chaque tableau  

---

## Installation & utilisation

1. Cloner le dépôt :  
   ```bash
   git clone https://github.com/LucienLambert/Trello-Clone.git

## Utilisateurs

Tous les utilisateurs (`boverhaegen@epfc.eu`, `bepenelle@epfc.eu`, `brlacroix@epfc.eu` et `xapigeolet@epfc.eu`) ont le mot de passe `Password1,` (remarquez qu'il se termine par une virgule).

## Sauvegarde de la base de données

- Vérifiez le chemin de `mysql dump` dans le fichier de configuration
- Accédez à l'url [http://localhost/prwb_2021_d02/setup/export](http://localhost/prwb_2021_d02/setup/export) 
    - `database/prwb_2021_d02.sql` contient le schéma de la base de données
    - `database/prwb_2021_d02_dump.sql` contient le dump de la base de données
- Pour la restaurer, accédez à l'url [http://localhost/prwb_2021_d02/setup/install](http://localhost/prwb_2021_d02/setup/install)


