Commandes à effectuer via la console dans le répertoire du projet pour créer et mettre à jour la base de données locale

## 1. Création

```
php bin/console doctrine:database:create
```

        La base de données "roatrip" sera alors créée

## 2. Mise à jour du shéma


### a. Préparation des requêtes dans Symphony

```
php bin/console make:migration
```

        Crée un fichier de migration contenant les requêtes générées par les nouvelles modifications

### b. Exécution des mises à jour

```
        php bin/console doctrine:migrations:migrate
```

Effectue l'update du shéma de la base de données

## 3. Démarrage du serveur web local


    a. Démarrage du serveur

        php bin/console server:run

    b. URL pour l'utiliser

        http://127.0.0.1:8000/road_trip/route-à-appeler (ex : http://127.0.0.1:8000/road_trip/sorts)

        Les différentes routes se trouvent dans le fichier \src\Controller\RoadTripController.php, au dessus de chaque fonction.

        Ex :

            /**
            *  @Route("/road_trip/newSort", name="road_trip_createSort")
            *  @Route("/road_trip/{id}/editSort", name="road_trip_editSort")
            *           
            */

            Pour cette fonction, on peut appeler deux routes :

            http://127.0.0.1:8000/road_trip/newSort si on veut créer une nouvelle sorte
            http://127.0.0.1:8000/road_trip/1/editSort si on veut modifier une sorte (ici la numéro 1)

        Une page index existe en utilisant cette url : http://127.0.0.1:8000/road_trip/

## 4. Démarrage du webpack Encore

    J'ai installé Yarn sur ma machine. Donc, la commande à effectuer avec Yarn est :
```
    yarn encore dev --watch
```
    Pour installer les dépendances nécessaires
```
    YARN
    npm install yarn

    @symfony/webpack-encore
    npm i @symfony/webpack-encore
```

## 5. Modification du fichier .env pour l'utilisation de MAMP :

    Modifier la ligne
```
    DATABASE_URL=mysql://root:@127.0.0.1:3306/roadtrip
```
    en
```
    DATABASE_URL=mysql://root:root@127.0.0.1:8889/roadtrip
```
    Attention, après la modification de ce fichier, il sera nécessaire de modifier le fichier .gitignore afin que celui-ci ne soit plus repris dans les commits suivants afin de ne pas poser problèmes sur les machines locales.

##6. Utilisation de Git

    a. Cloner le remote
```
        git clone username@host:https://github.com/dubitoph/roadtrip.git
```
    b. Ajouter le remote
```
        git remote add origin https://github.com/dubitoph/roadtrip.git
```
    c. Créer une branche en local
```
        git branch nom_de_la_branche
```
    d. Travailler sur la nouvelle branche
```
        git checkout nom_de_la_branche
```
    e. Fusionner les changements de la nouvelle branche à la branche master
```
        git checkout master
        git merge nom_de_la_branche
```
    f. Supprimer la nouvelle branche
```
        git branch -d nom_de_la_branche
```
    g. Ajouter un changement à l'index
```
        git add *
```
    h. Valider les changements
```
        git commit -m "Message de validation"
```
    i. Envoyer les changements sur le remote
```
        git push origin master
```
##6. Des jeux de données dans la base de données

Cela s'effectue grâce aux fichiers situés dans src\DataFixtures.

Pour les exécuter il faut utiliser cette commande :
```
php bin/console doctrine:fixtures:load
```
Cette commande supprime toutes les données existantes et crée les nouvelles données.

Plusieurs options sont possibles :

-- nomDuFichier : le fichier à partir duquel charger les données, si on ne désire pas exécuter toutes les fixtures
-- append : ajoute les données sans supprimer les données pré-existantes.
-- purge-with-truncate : supprime les données en utilisant la commande sql truncate permettant une nouvelle indexation.


##7. A ne pas oublier lors de la mise en production

- Activer l'extension intl dans le php.ini

##8. A ne pas oublier d'ajouter comme extensions

- Symfony intl
- Twig intl
- moment.js