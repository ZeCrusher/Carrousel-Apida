# Carrousel des animations pour des écrans des Offices de Tourisme avec APIDAE  

Ce petit projet propose un carrousel qui met en avant les animations et événements d'une ville, directement alimenté par les données d'APIDAE. 

L'objectif est de fournir une solution "esthétique" (chacun ses goûts) et dynamique pour afficher des informations culturelles, touristiques ou événementielles.  

![Capture d'écran 2025-01-06 113611](https://github.com/user-attachments/assets/90410c41-1a25-4717-ba26-d8a802cabfbd)



Le principe et les fonctionnalités  
- il faut avoir un compte APIDAE car mon petit carrousel interagit avec APIDAE pour récupérer en temps réel les informations des animations et événements.  
- Affichage dynamique : Les animations défilent automatiquement il est "adapté" aux différents écrans (ordinateurs, tablettes, mobiles).  
- il est possbble de le personnalisation : Les utilisateurs peuvent configurer les critères pour filtrer les événements (date, catégorie, lieu, etc.).  

## Pourquoi ce projet ?  

Ce carrousel vise à faciliter la présentation d'événements d'une ville, en offrant une expérience utilisateur immersive tout en exploitant la richesse des données fournies par APIDAE.  

NOTE : Ajustez les paramètres pour correspondre à votre ville ou vos besoins.  

Voilà et si vous avez des suggestions et/ou des contributions, elles sont les bienvenues ! N'hésitez pas à ouvrir une issue ou soumettre une pull request si vous avez des idées pour améliorer ce projet.  


NOTE : Comment obtenir l'accès 
Vous devez demander des clefs publics et privés au support d’Open Agenda. Une fois reçu par mail, on insère ces clefs dans le fichier Config de l’API. L’API va l’utiliser pour établir une liaison d’accès provisoire et sécurisé.

![apidae8](https://github.com/user-attachments/assets/d625004c-0d79-4f31-98a3-96e60dc7d091)

Nous pouvons traduire token par "Jeton d'accès spécial". Il vous faudra donc fournir des clefs pour la lecture sur APIDAE et des clefs pour l'écriture sur l'OpenAgenda.

* Les clefs APIDAE se récupèrent depuis votre compte administrateur après la création d'un projet

* Les clefs OpenAgenda vous seront communiqué après une demande par email à l’équipe technique OpenAgenda

NB : Les clefs utilisées dans ce guide sont des valeurs d'exemples. Elles n'existent pas et ne pourront donc pas être utilisées dans les tests de l'API.

Obtenir les clefs d'APIDAE
Veuillez suivre attentivement le tutoriel d'Apidae concernant la création d'un projet. La validation de votre projet vous permettra de retrouver les clefs nécessaires à l'API tel que l'identifiant de votre projet et la clef API. Ils sont tous les deux uniques. Vous trouverez les clefs dans la rubrique informations générales de votre projet.


Information générales du projet
Les deux valeurs à noter dans le fichier config.php sont :

Identifiant :  6775

Clef d'API :  AbcdeF

