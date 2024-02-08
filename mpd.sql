-- Création de la base de données
CREATE DATABASE IF NOT EXISTS recipes;

-- Utilisation de la base de données
USE recipes;

-- Création de la table "categories"
CREATE TABLE IF NOT EXISTS categories (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Création d'entrées dans la table "categories"
INSERT INTO categories (name) VALUES ('Sucrés');
INSERT INTO categories (name) VALUES ('Salés');
INSERT INTO categories (name) VALUES ('Sucrés-Salés');

-- Création de la table "recipes"
CREATE TABLE IF NOT EXISTS recipes (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(100) NOT NULL,
  body TEXT NOT NULL,
  excerpt VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  category_id BIGINT UNSIGNED NOT NULL,
  img_url TEXT NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE
);

-- Création d'entrées dans la table "recipes"
INSERT INTO recipes (title, body, excerpt, category_id, img_url) VALUES ('Flan', 
'Pour réaliser le flan, commencez par faire bouillir le lait avec la gousse vanille fendue dans le sens de la 
longueur.
Pendant ce temps, mélangez la Maïzena (tamisée) avec le sucre.
Ajoutez les oeufs battus.
Mélangez le tout et ajoutez le lait chaud sans la gousse de vanille.
Chauffez la préparation à feu doux en remuant constament pendant environ 1 à 2 min.
Préchauffez le four à 200°C.
Dans un plat rond préalablement beurré, placez la pâte brisée.
Piquez le fond, versez votre mélange et lissez la surface.
Enfournez pendanrt 40 minutes.
Laissez refroidir.

Bonne dégustation !', 'Facile et pas chère, cette recette est la meilleure pour réaliser un flan pâtissier traditionnel !', 1,"https://mycancalekitchen.com/wp-content/uploads/schema-and-structured-data-for-wp/flan-patissier-1200x1200.jpg");
INSERT INTO recipes (title, body, excerpt, category_id, img_url) VALUES ('Pizza aux 3 fromages', '
ÉTAPE 1

Etaler la pâte à pizza dans un plat à tarte, la piquer avec une fourchette, étaler le coulis de tomate sur la
 pâte.

ÉTAPE 2

Découper des rondelles de fromage de chèvre et de mozzarella, découper aussi de fines tranches de roquefort.

ÉTAPE 3

Placer le fromage en alternance (une tranche de fromage de chèvre, une de mozzarella, une de roquefort).

ÉTAPE 4

Couvrir de gruyère râpé.

ÉTAPE 5

Saler et poivrer selon les goûts.

ÉTAPE 6
Mettre au four à Thermostat 7 (210°C), pendant 1/2 heure et plus si nécessaire.', 'pour réussir vos pizza comme un reel pizzaïolo', 2, "https://cdn-elle.ladmedia.fr/var/plain_site/storage/images/elle-a-table/fiches-cuisine/tous-les-themes/soiree-pizza/168384-21-fre-FR/Recettes-de-pizzas.jpg");
INSERT INTO recipes (title, body, excerpt, category_id, img_url) VALUES ('Porc au caramel', "ÉTAPE 1

Découper le porc en bouchées.

ÉTAPE 2

Faire chauffer 50 cl d'eau. Ajouter les deux cubes de bouillon de poule, 1 cuillère à soupe de gingembre moulu, 
1 cuillère à soupe de mélange quatre épices et 3 cuillères à soupe de sauce soja.

ÉTAPE 3

Dans une sauteuse, préparez votre caramel avec le sucre et l'eau.

ÉTAPE 4
Une fois le caramel prêt, ajouter le bouillon et tourner très vite pour faire dissoudre le caramel 
(qui va se durcir) dans le bouillon.

ÉTAPE 5

Une fois le caramel dissout, rajouter la viande et l'oignon coupé en gros morceaux et mettre à feu 
très vif. Laisser réduire jusqu'à ce que tout le liquide se soit évaporé (environ 25 min) et que la 
viande se mêle au mélange épais caramel-épices.

ÉTAPE 6
Déguster !", 'audacieux et savoureux, un classique de la gastronomie sucrées salées', 3,"https://www.seb.fr/medias/?context=bWFzdGVyfHJvb3R8MzgwMTF8aW1hZ2UvanBlZ3xoMTUvaDY0LzE2NDc5NzIxOTc5OTM0LmpwZ3wzYTEwOGVlNGJiZDkzMmI2Mjc5NWRhYThjMWNkODA1OTU4M2JhZDQyZTVlOWM3NTYxM2U5ZDFiY2UxMmE2ODU2");

INSERT INTO recipes (title, body, excerpt, category_id, img_url) VALUES ('Gateau de savoie', "ÉTAPE 1

Cassez les oeuf en séparant les blancs des jaunes, mettre les blancs dans un saladier.

ÉTAPE 2

Montez les blancs en neige (bien ferme) ajoutez-y le sucre.

ÉTAPE 3
Ensuite mettez les jaunes dans les blancs en neige.

ÉTAPE 4

Mélanger la farine avec la levure puis incorporez-la à la préparation.

ÉTAPE 5
Beurrez et sucré votre moule (rond de préférence), puis verser la préparation.

ÉTAPE 6
TOUT FAIRE AU BATTEUR.", 'moelleux, léger et authentique. Le gateau de savoie, une recette facile pour épater tout vos hotes', 1,"https://www.mademoisellecuisine.com/wp-content/uploads/sites/2/2015/12/gateau-de-savoie-2.jpg");
INSERT INTO recipes (title, body, excerpt, category_id, img_url) VALUES ('lasagne chèvre et épinards', "ÉTAPE 1

Préchauffez le four à 200°C (Th 6-7). Décongelez les épinards, à feu doux, dans une casserole, puis enlevez 
l'eau résiduelle (n'hésitez pas à appuyer pour la faire sortir!). Hachez-les grossièrement (je le fais au ciseau).

ÉTAPE 2
Emiettez la bûchette de chèvre.

ÉTAPE 3

Dans un grand plat à four beurré, posez une couche de lasagnes, puis une couche d'épinards, puis une couche 
de miettes de chèvre, puis un peu de béchamel, puis un peu de sel et de poivre, puis à nouveau une couche 
de pâtes...

ÉTAPE 4

Faites ainsi 2 ou 3 couches, en terminant par la béchamel et en recouvrant de gruyère râpé.

ÉTAPE 5
Laissez cuire environ 30 min et servez chaud, avec une salade aux noix.", 'sain, savoureux, original et qui plaira mêmes aux enfants, de quoi satisfaire toutes votre table avec cette recette de lasagne', 2,"https://www.galbani.fr/wp-content/uploads/2019/12/AdobeStock_100041854-800x600.jpeg");


-- Création de la table "comments"
CREATE TABLE IF NOT EXISTS comments (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  content VARCHAR(1023) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  recipe_id BIGINT UNSIGNED,
  FOREIGN KEY (recipe_id) REFERENCES recipes (id) ON DELETE CASCADE
);

-- Création d'entrées dans la table "comments"
INSERT INTO comments (content, recipe_id) VALUES ('excellent ! un vrai Voyage a venise cette recette', 2);
INSERT INTO comments (content, recipe_id) VALUES ('Parfait pour un étudiant comme moi, top et pas trop cher', 1);
INSERT INTO comments (content, recipe_id) VALUES ("j'ai réussi a faire manger des épinards à mes enfants merci !", 5);
INSERT INTO comments (content, recipe_id) VALUES ("il est tellement moelleux qu'on dormirait presque dessus", 4);
INSERT INTO comments (content, recipe_id) VALUES ("aussi bon que le flan patissier de la boulangerie du coin ! ", 1);
INSERT INTO comments (content, recipe_id) VALUES ("personnellement j'ai rajouté un peu de fleur d'oranger :)", 4);
INSERT INTO comments (content, recipe_id) VALUES ("délicieux ! ", 3);
INSERT INTO comments (content, recipe_id) VALUES ('miam ! ', 3);

