# Module Framework Web B2 - Symfony - Ynov Lyon Campus

# JokeOnU

## I - Contexte & Présentation du projet

Nous sommes le groupe Zinattendu, composé de Ismaël HACQUIN et de Mattéo DINVILLE.

**JokeOnU** est un site qui regroupe un certain nombre de blagues de tout genre, classé par catégories.

Pour pouvoir accéder aux blagues, il faut d'abord se connecter ou se créer un compte. Une fois que votre compte est créé, une blague vous ai automatiquement assigné.

Vous avez la possibilité d'aimer qu'une seule blague parmis toutes celles proposées sur le site, la blague ayant reçu le plus de like (si c'est celle qui appartient a votre compte) vous monter de place au classement.

## I - b - Lancer le projet

Tout d'abord pour utiliser notre site internet **JokeOnU**, vous devrez faire :

```bash
$ git clone git@github.com:Ynov-b2-sf-2022/zinattendu.git
```

Ensuite installer toutes les dépendances à l'aide des commandes :

```bash
$ composer install
$ npm install
```
Maintenant, il faut mettre en place la base de données à l'aide de la console symfony :
```bash
$ php bin/console doctrine:database:create
```
Importer les migrations : 

```bash
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate
```

Une fois que les migrations ont été faites, on remplit la base de données : 

```bash
$ php bin/console doctrine:fixtures:load
```

## II - Toutes les fonctionnalitées présentes sur notre application

Voici les différentes fonctionnalitées présentes sur notre application.

La route `/login` :

Cette route permet à l'utilisateur de pouvoir se connecter à son compte de manière claire et sécurisée.

La route `/logout` :

Cette route permet à l'utilisatuer de pouvoir se déconnecter de son compte.

La route `/register` :

Cette route permet à l'utilisateur de pouvoir se créer un compte, et ainsi renseigner ses informations à l'aide d'un formulaire.

La route `/admin` :

Cette route est destinée uniquement à un utilisateur qui possède le role ADMIN sur le site internet. A l'aide du role ADMIN, il aura la possibilité de pouvoir ajouter, supprimer ou modifier un utilisateur à l'aide du back office.

La route `/admin/user/` :

Sur cette route, le role ADMIN, à la possibilité de modifier, supprimer ou créer un utilisateur.

La route `/admin/like/` :

Sur cette route, le role ADMIN, à la possibilité de modifier, supprimer ou créer un utilisateur.

La route `/admin/joke/` :

Sur cette route, le role ADMIN, à la possibilité de modifier, supprimer ou créer une blague

La route `/newsletter/register` :

Sur cette route, nous avons configurer le service d'un **mailer**.

Nous avons également mis en place la connexion à l'[API](https://www.blagues-api.fr).

Notre application est aussi dockerisé.

## III - Comment mettre en place les fonctionnalités

### Database create and Entity

Dans la construction de notre site **JokeOnU**, 
nous allons renseigner dans un ficher de variables d'environnement les coordonnées d'accès à la base de données, via la variable `DATABASE_URL`.

Par la suite, on va pouvoir demander à Doctrine de créer la base de données pour nous avec la commande suivante :

```bash
$ php bin/console doctrine:database:create
```

L'assistant ligne de commande est plutôt clair et simple à utiliser. Choisissez pour chaque propriété que vous voulez créer son type, sa taille, nullable ou non, etc...

Pour créer des entités dans notre application, nous allons utiliser le `Maker` : 
```bash
$ php bin/console make:entity
```

### Fixtures

Nous avons rempli notre base de données grâce aux `Fixtures` de symfony avec la commande :

```bash
$ composer require --dev orm-Fixtures
```

La commande exécutée lors de l'installation a créé un fichier `src/DataFixtures/AppFixtures.php`.

C'est dans ce fichier qu'on va créer nos objets et les enregistrer en base de données.

Notre fichier de fixtures, à la base, ressemble à quelque chose comme ça :

```bash
<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    //...

    $manager->flush();
  }
}
```

Une fois que les données ont étaient mis en place dans le dossier "AppFixtures.php", nous lançons nos fixutres avec la commande :

```bash
$ php bin/console doctrine:fixtures:load
```

Pour ce qui concerne la fonctionnalité d'authentification, nous avons crée une entity User à l'aide de la commande :

```bash
$ php bin/console make:user
```

Maintenant que l'entité a été générée, il nous faut mettre à jour la base de données :

```bash
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate
```

Maintenant que nous avons notre entité "User" et que notre fichier de configuration "security.yaml" est à jour, nous avons mis en place nos pages de connexion et de déconnexion.

```bash
$ php bin/console make:auth
```

Deux routes sont disponibles :

Pour se connecter : `"/login"`, qui a pour nom `"app_login"`

Pour se déconnecter : `"/logout"`, dont le nom est `"app_logout"`

### Inscription

Une nouvelle commande de Symfony va générer de quoi faire cette création de compte :

```bash
$ php bin/console make:registration-form
```

### CRUD

Pour la partie back-office, qui nous permet de pouvoir modifier supprimer et ajouter des données, nous avons décidé de le mettre en place uniquement pour le `Role_ADMIN` de notre application, pour cela nous avons lancer la commande sur notre entity `User`, `Joke` et `Like` :

```bash
$ php bin/console make:crud User
$ php bin/console make:crud Joke
$ php bin/console make:crud Like
```

### Sécurité & Authentification

Pour sécuriser au maximum notre application, nous avons mis en place un role administrateur et donc un accès seulement pour les comptes possédant le `Role_ADMIN`.

Pour cela, nous avons créé un nouveau controller à l'aide de la console symfony :

```bash
$ php bin/console make:controller Admin
```

La partie administrateur est accessible via la route `/admin`.

```bash
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
```
### Partie Front-end - Twig

Pour la partie visuel de notre application, nous avions une [maquette](https://www.figma.com/file/7MzyDzdKOfbsQz2I7ZBXA9/JokeOnU?node-id=0%3A1) ainsi qu'un code couleur à respecter. Pour l'intégration de cette maquette, nous avons utiliser le moteur de templates `Twig` que Symfony propose, à cela viennent s'ajouter du `Bootstrap` et du `CSS`. 

Bootstrap à été installer via la documentation officiel de Bootstrap : 

```bash
$ npm install bootstrap
```

### Création d'un formulaire 

Pour créer un formulaire dans notre projet, nous avons utiliser le MakerBundle :

```bash
$ php bin/console make:form
```

### Mailer

Pour permettre la possibilité d'un envoie de mail, nous avons mis en place un mailer à l'aide de la commande :

```bash
$ docker run -d --name=mailtrap -p 9999:80 -p 9998:25 eaudeweb/mailtrap
```

Se connecter à `Mailtrap` via `Docker Desktop` sur le port qui lui à été associé auparavant pour pouvoir récuperer le mail envoyé.

Dans notre cas, nous avons accès à Mailtrap via l'URL : 

```bash
$ https://localhost:7423/
```

## IV - Problèmes rencontrés

Dans un premier temps, lorsque nous avons commencé à développer le projet Symfony, la base de données nous à posé quelques problèmes. Notamment au niveau des relations entre nos entités. Pour résoudre ce problème, nous avons à plusieurs reprise re créer une nouvelle base de données avec de nouvelles relation. Ce qui nous à pris pas mal de temps. Pour s'assurer que celle-ci était bien fonctionnel du début à la fin, nous avons insérer de fausses données à l'aide de faker et des fixtures de symfony.

![unknown](https://user-images.githubusercontent.com/76099896/166505684-c137190e-b714-4ad4-9315-ed2a8284f0fe.png)

Nous avons également rencontrés quelques souci au niveaux de nos fixtures, nous n'arrivions pas à insèrer toutes nos données dans chacune des tables. Cela était du à cause d'une relation OneToOne entre notre entité User et Joke, ou nos fixtures voulaient assignés 2 blagues pour un seul user, ce qui dans notre cas n'était pas possible. 

(Pour résoudre cela, dans le fichier `AppFixtures.php` nous avons retravaillé notre boucle FOR pour éviter ces soucis d'insertion.)

Egalement au niveau de l'API, au départ nous avions choisi d'utiliser le bundle HTTP Client de symfony, or nous nous sommes orienté vers une librairie wrapper qui à été crée sur l'api que nous avions choisi, cela nous a facilité la récuperation des blagues. De cette manière, nous avons eu besoin d'un token pour avoir accès à l'API et donc aux blagues proposées. 

Pour cela, nous avons utiliser la commande :

```bash
$ composer require zuruuh/blagues-api
```
Cela nous a permis de récuperer les données de l'API.

## V - Points d'améliorations

Pour continuer l'avancée de notre application dans le futur, nous aimerions améliorer l'interface utilisateur de notre site. Permettre à un utilisateur de pouvoir poster lui même sa blague sur le site. Avoir l'impression que cela est similaire à un jeu.

