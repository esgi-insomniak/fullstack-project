# Ta BMW 

## Objet

Ce projet est un site de e-commerce de voitures BMW. 
- Il permet de visualiser les voitures disponibles, de les filtrer, de les ajouter au panier et de passer commande.
- Il permet à un client de mettre sa voiture en vente et de la vendre à un garage BMW.
- Il est possible de prendre des RDV pour des réparations ou des essais de voitures en fonction de la disponibilité des garages.

# Librairies / Frameworks utilisées

Le projet inclut les fonctionnalités suivantes :

- Front: usage de **Vue.JS**
- Bundling :

  - Configuration **vite** personnalisée basée sur SWC incluant un serveur de développement avec hot reload

- Authentification :

  - Inscription avec Token **JWT** 
  - Validation par email 

- Tests unitaires :

  - **Jest** et **testing-library** installés et préconfigurés
  - **Cypress** test fonctionnels

- Intégration à l'API :

  - Création de service d'appel API avec **Axios**

- Formulaires :

  - Gestion des formulaires avec **FormKit**
  - Validation déclarative du formulaire par schéma via **yup**

- Routage :

  - **Routing côté navigateur** avec Vue Router
  - Prise en charge des **routes protégées**

- Autres :

  - **Vuex** pour la gestion d'état global 
  - **TailwindCSS** pour le style


- Environment :

  - [Prod Front](https://ta-bmw.frozox.fr/)
  - [Prod API](https://api.ta-bmw.frozox.fr/)

  - [Preprod Front](https://preprod.ta-bmw.frozox.fr/)
  - [Preprod API](https://preprod.api.ta-bmw.frozox.fr/)

# API

Api platform utilise un swagger pour la documentation et le testing de l'api.

# Comment initialiser le projet et l'utiliser

1. **Cloner le projet**

   Faire un clone du projet git pour initialiser le repo du projet.

2. **Configurer les variables d'environnement**

   Dans le dossier 'vuejs-starter', créer un fichier '.env.local' et y renseigner les variables d'environnement suivantes :
   ```bash
    VITE_API_URL=https://localhost/
    VITE_API_JAWG_ACCESS_TOKEN={Your_Own_Token}
    ```
    Pour obtenir un token Jawg, vous pouvez vous rendre sur le site suivant : [Jawg IO](https://www.jawg.io/)


3. **Configurer Prettier**

   Vérifier qu'une extension Prettier est installée sur l'IDE, l'installer le cas échéant [https://prettier.io/docs/en/editors.html](https://prettier.io/docs/en/editors.html)

4. **Installer les dépendances et démarrer le projet**

Dans un terminal, se placer dans le dossier 'vuejs-starter' et exécuter les commandes suivantes :

   ```bash
    make build
    make start
   ```

Dans une autre fenetre du terminal, ouvrir le dossier 'api-platform-starter' et exécuter les commandes suivantes :

   ```bash
    make build
    make jwt
    make start
    make migrate 
    make fixtures-purge
   ```