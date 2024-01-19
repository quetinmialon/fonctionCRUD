# Atelier : Les fonctions et PDO

Dans cet atelier, l'objectif est de pratiquer la création et l'utilisation des fonctions ainsi que la manipulation de nos bases de données.

Toutes les fonctions de cet atelier sont à réaliser dans le fichier `functions.php`. Le fichier `index.php` vous servira à les tester via un `var_dump()` par exemple.

Celles-ci devront avoir des **paramètres et des valeurs de retour typés** ! #onvisepersonne

## 1. Première fonction !

Commencez par exécuter le script SQL `mpd.sql` fourni avec cet atelier ! Il contient tout ce qu'il faut pour créer une base de données `blog` ainsi que des tables et des entrées. Assurez-vous de **ne pas avoir déjà une base de données du même nom** pour que ça fonctionne.

Vous allez devoir commencer par créer une fonction `getPDO()` dont l'objectif sera de retourner une instance de PDO configurée comme vous l'avez indiqué en argument lors de l'appel.

Comme pour toutes les fonctions qui suivront, faites appel à celle-ci dans `index.php` et vérifier que tout fonctionne correctement.

## 2. Des posts et des catégories

C'est parti pour la création de nouvelles fonctions :

- `getPostsWithCategories()` : Permet de retourner l'ensemble des articles du plus récent au plus ancien associés à leurs catégories (jointures).

- `getPostWithCategory()` : Permet de retourner un article avec sa catégorie dont l'`id` a été passé en argument. Si l'article n'existe pas, le booléen `false` sera retourné.

- `getPostsByCategory()` : On veut maintenant pouvoir filtrer nos articles en fonction de leurs catégories (toujours du plus récent au plus ancien). Cette fonction aura donc en paramètre l'`id` d'une categorie et seul les articles liés à celle-ci seront retournés dans un tableau. Si aucun article ne correspond à la catégorie, un tableau vide sera retourné.

# 3. On améliore tout ça !

Les fonctions `getPostsWithCategories()` et `getPostsByCategory()` peuvent retourner beauuuuucoup de résultats !

En général, on va demander à ce type de fonction de nous retourner seulement une partie des résultats pour gérer facilement une pagination sur notre site.

Ces 2 fonctions vont devoir prendre des paramètres supplémentaires :

- `$page` : Numéro de la page pour laquelle on veut récupérer des articles.
- `$perPage` : Nombre d'éléments que vous souhaitez sur chaque page.

Avec ces 2 paramètres, vous devez être capable de gérer la pagination !

Exemple :

Si je met `$page = 2` et `$perPage = 5`, je dois récupérer les résultats du 6ème au 10ème (les 5 premiers étant destinés à la page 1). A vous de trouver le calcul ! 🤓

Les données retournées par ces fonctions devront être des tableaux au format suivant : (ces métadonnées en plus des données classiques permettraient de construire aisément une pagination côté HTML par exemple)

```php
[
  'count' => 25, // Nombre total d'entrées toutes pages comprises (si j'ai 3 pages des 15 éléments, je dois avoir 45)
  'per_page' => 10, // Nombre de posts à récupérer pour chaque page
  'page' => [
    'current' => 2, // Numéro de page actuel
    'total' => 4, // Nombre total de pages
  ]
  'data' => [
    // Ici tous mes posts pour la page actuelle
  ],
]
```

# 4. Création d'un article

Vous allez devoir créer un fichier `create.php` qui va contenir un formulaire HTML qui stockera dans la variable superglobale `$_POST` les informations nécéssaire à la création d'un article.
pour que ce formulaire soit complet il faudra donc demander a remplir un titre, un extrait, un contenu et avoir une liste déroulante pour acceder au différentes catégories possible avec la possibilité de choisir de ne pas mettre de catégorie.
il faudra donc pour cette dernière partie  créer une fonction getCategories() pour pouvoir récupèrer les noms de catégories ainsi que leurs id dans un tableau associatif.
créer également un bouton sur `index.php` pour pouvoir acceder a la page de création

Ensuite, créez la fonction `createPost()` qui prendra en arguments les données du formulaire, quand on appelera cette fonction on la remplira donc avec les informations stockées dans la variable superglobale `$_POST`, mais lors de la création de la fonction, on va etre feignants et mettre un nom plus court et qui rendra la fonction plus générale.
Cette fonction devra donc effectuer une requete SQL à notre base de donnée, en se basant donc sur getPdo() et en prenant $pdo en argument. 
Dans le but d'éviter une possible injection SQL, nous allons sécuriser notre requete en utilisant la méthode ->prepare(), puis nous nous assurerons que les variables qui seront intégrés a notre requete SQL sont bien typées comme on l'attend (en demandant un type précis en argument de fonctions dans un premier temps et en les faisant par la suite passer par la méthode ->bindValue ou ->bindParam) on executera alors la requete avec la méthode -> execute()
une variable sera cependant particulière puisqu'elle pourra etre non remplie, il s'agit de la catégorie, il faudra donc, lorsque cette dernière sera ou non remplie lui faire rentrer une valeur ou bien un `NULL` dans notre BDD
Cette fonction ne sera appelée QUE SI le formulaire a été soumis. il faudra donc utiliser la fonction empty() pour vérifier si la variable superglobale `$_POST` possède tout le contenu nécéssaire à la création d'un article.
dans le cas contraire, il ne faudra pas oublier de vider la variable superglobale `$_POST` avec la fonction unset() de manière à éviter des interférences avec des informations qui auraient persister depuis la précédente version de la page.


Elle devra retourner `false` si la création a échouée et `true` si tout a fonctionné.

# 5. Modification d'un article

Vous allez devoir créer un fichier `update.php` qui va contenir un formulaire HTML destiné à modifier un article.

Il va falloir le remplir automatiquement avec l'`id` contenu dans la barre d'adresse.

Ensuite, créez la fonction `updatePost()` qui prendra en arguments les données du formulaire MAIS AUSSI l'`id` de l'article à modifier. Cette fonction ne sera appelée QUE SI le formulaire a été soumis.

Elle devra retourner `false` si la mise à jour a échouée et `true` si tout a fonctionné.

# 6. Suppression d'un article

Vous allez devoir créer un fichier `delete.php` qui va contenir un formulaire HTML destiné à supprimer un article en le sélectionnant dans une liste déroulante.

Ensuite, créez la fonction `deletePost()` qui prendra en argument l'`id` de l'article à supprimer. Cette fonction ne sera appelée QUE SI le formulaire a été soumis.

Elle devra retourner `false` si la suppression a échouée et `true` si tout a fonctionné.

# 7. Commenter un article

Vous allez maintenant devoir créer une fonction `addComment()` qui prendra en arguments l'`id` de l'article auquel est destiné le commentaire ainsi que le contenu du commentaire dans un paramètre `$content`.

Elle devra retourner `false` si l'ajout a échouée et `true` si tout a fonctionné.

# 8. On filtre tout ça

Pratiquons un petit peu nos fonctions anonymes.

Sur `index.php`, récupérer une bonne liste de posts avec la fonction `getPostsWithCategories()` (pensez à mettre un grand nombre pour le paramètre `$perPage` et la `$page` à 1 pour que la clause `LIMIT` ne nous prive pas de résultats).

Une fois que c'est fait, filtrez le tableau récupéré dans une nouvelle variable avec la fonction `array_filter()` pour ne récupérer **QUE les articles qui n'ont PAS de catégorie** associée.

Une fois que ça fonctionne, **transformez cette fonction anonyme en fonction fléchés** si ça n'est pas déjà fait.
#   f o n c t i o n C R U D  
 