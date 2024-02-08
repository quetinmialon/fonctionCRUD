
1-- procédure de mise en place du site en local et initialisation de la base de donnée

Tout d'abbord assurez vous d'avoir Laragon d'installer sur votre poste personnel ou bien un serveur local autre (homestead, mamp) ainsi qu'un système de gestion de base de donné mySQL (phpmyadmin par exemple). si ce n'est pas le cas, cliquez sur le liens suivant : https://github.com/leokhoa/laragon/releases/download/6.0.0/laragon-wamp.exe pour télécharger Laragon et ainsi pouvoir avoir accès à un serveur local pour pouvoir ouvrir la page web et créer la base de donnés relative à cette page.

Une fois Laragon installé, il va nous falloir executer quelques actions pour installer l'interpreteur Php, un serveur Local pour héberger l'application web et un système de gestion de base de données, heureusement pour nous, sur Laragon, en quelques clics ce sera fait ! 

Tout d'abord ouvrez Laragon et vérifier en appuyant sur le bouton "démarer" et vérifier votre listes d'outil installé comme ci-dessous : 

[""](/img/demarer.PNG)

[""](/img/outils.PNG)

si dans cette liste, apache (ou Ngynx) et MySQL (ou autre phpmyadmin, postgreSQL etc..) sont installer, vous etes normalement pret a ouvrir le site, l'étape suivante ne vous concernera donc pas.
Sinon, cela signifie qu'il va vous manquer quelques outils pour pouvoir acceder à nos superbes recettes !

la manipulation pour l'ajout des outils supplémentaire est simple, sur la page d'accueil de L'application Laragon, faites un clic droit, outil > quick Add > PHP (reproduire la même manipulation pour Appache et phpmyadmin) comme indiqué ci-dessous.

[""](/img/installationphp.PNG)

Voila vous etes maintenant prets à pouvoir executer pleinement les fichier PHP en local depuis votre propre serveur ! mais me direz-vous, c'est bien gentil, je peux le faire, mais comment ? 

Très bonne question en sommes ! tout d'abord on va effectuer une petite vérification de routine, et s'assurer que notre application Laragon cherchera bien à ouvrir les dossiers présents au bon endroit ! il va donc nous falloir vérifier ou se situe le dossier "www" qui sera le dossier dans lequel toutes nos applications seront à insérer ! 

pour ce faire on peut simplement ouvrir le dossier WWW depuis l'accueil de l'application Laragon (cela nous permetra de consulter le chemin que Laragon empruntera par défault) comme ceci : 

[""](/img/dossier.PNG)

le chemin est donc indiqué dans la barre en haut : 

[""](/img/chemin.PNG)


si vous souhaitez par la suite modifier ce chemin, il faudra passer par les parametres directement depuis l'application Laragon (parametre (bouton en haut a droite en forme d'engrenage sur l'accueil de l'application)>onglet general > Document Root. et changer le chemin d'accès pour aller vers celui choisi.)

maintenant que l'on sait vers quel dossier Laragon va chercher à executer nos fichier PHP, on va pouvoir y insérer directement tout le contenu de notre repo github ! une fois le dossier "BDD_ADMISSION" mis dans le dossier WWW de Laragon nous pouvons maintenant executer l'application en cliquant sur le bouton web de l'application Laragon (comme ci-dessous) ou bien en tapant dans la barre d'URL de votre navigateur préféré (si vous utilisez internet explorer il serait temps de changer sans vouloir vous commander) l'adresse suivante : localhost.

[""](/img/accesSite.PNG)

Vous arriverez sur une page comme ci-dessous, et d'ici vous n'avez plus qu'a cliquer sur le lien BDD_ADMISSION pour ouvrir la page web ! si tout fonctionne, la page affichera un message d'erreur ! et c'est normal ne vous inquietez pas ! la page attend en fait d'etre relié a une base de données qui actuellement n'existe pas, heureusement nous allons y remedier dès maintenant ! 

Commencons par retourner sur l'application Laragon pour ouvrir notre système de gestion de base de données phpmyadmin, pour ce faire cliquer sur le bouton "base de données" comme ci-dessous 

[""](/img/ouvrirBDD.PNG)

une page web s'ouvrira dans votre navigateur vous demander de vous connecter, les identifiants par défault sont : "root" pour l'utilisateur et le mot de passe reste vide, connectez vous et ça y est vous etes sur votre SGBD ! 

Une fois sur la page d'accueil du SGBD, allez cliquez sur le bouton Import de la barra de navigation en haut de la page comme ceci : 

[""](/img/navBDD.PNG)

puis cliquer sur Choisir un fichier dans la partie importer depuis votre ordinateur, reprennez le chemin d'accès a votre dossier WWW, aller dans le dossier BDD_ADMISSION et ouvrez le fichier mpd.sql, scrollez tout en bas de la page et cliquez sur Import. félicitation votre BDD est créée car ce fichier contient une requete Sql qui va créer la base de données, les différentes tables dont on a besoin ainsi que quelques entrées pour remplir notre site ! 

[""](/img/mpdSQL.PNG)

Une fois ça terminé, vous pouvez fermer la page phpmyadmin et retourner sur notre fameuses page localhost (qui a normalement maintenant comme URL localhost/BDD_ADMISSION/), rechargez la page et .... TADA ! des recettes gourmandes vous sont apparues ! 



2-- Découverte et utilisation du site web ! 

l'accueil du site se compose donc de 3 parties, tout d'abbord la "navbar", présente sur toutes les pages du site elle permet de naviguer aisément entre les différentes pages pour pouvoir bénéficier en toute occasion de chacunes des fonctionnalités disponibles ! 
elle se présente comme suit et chacun des boutons emmenera respectivement sur la page d'accueil (ou nous sommes actuellement), une page de création de nouvelle recette (ou l'on pourra remplir un formulaire qui une fois valider rentrera dans notre BDD une nouvelle entrée, et donc affichera sur notre site une nouvelle recette), une page supprimer une recette (qui emmenera sur une page ou a contrario, on pourra avoir une liste déroullante de toutes nos recettes disponnibles en BDD pour décider d'en supprimer une) ainsi que les boutons permettant d'afficher seulement les recettes des différentes catégorie (à savoir 3 actuellement mais il est possible d'en rajouter directement depuis notre SGBD si souhaité, les boutons s'ajusterons en fonction automatiquement).

[](/img/navbar.PNG)

la deuxieme partie de notre site constitue donc nos fameuses recettes, chacune des recette sera affiché dans une petite "boite" et au clic de cette derniere nous ouvrirons une nouvelle page qui contiendra plus d'informations sur la recette souhaitée ainsi que des commentaires liés a cette recette (et la possibilité d'en rajouter de nouveaux !). Il y a également un bouton modifié la recette (accessible sur la page d'accueil pour chacune des recettes affichées et aussi sur la page de chacune des recette individuellement) qui nous permetra donc d'ouvrir une page de formulaire avec toutes les informations a modifier, par défault les informations déja présente en BDD seront pré remplie dans les champs du formulaire.

[](/img/flan.png)

enfin notre site possèdera une troisieme partie (uniquement présente sur les pages d'accueil et de catégories) permettant de gérer la pagination, c'est a dire la gestion du nombre d'entrées de notres BDD par page, et la gestion des dites pages. très simple d'utilisation il faudra simplement choisir le nombre d'entrée par page depuis le menu déroullant et naviguer en fonction des pages grace au numéro de ces dernières. 

[](/img/pagination.png)

vous avez maintenant toutes les clés en mains pour utiliser a son plein potentiel ce site et profiter des recettes disponnibles à votre guise, en créer de nouvelle, en modifier ou bien même en supprimer !

3-- technologies utilisées pour la conception de l'application 

Pour ce site, j'ai utilisé du PHP sans framework, du HTML5 et le framework CSS tailwind, j'ai également utilisé le SGBD phpmyadmin pour la gestion des requetes SQL ainsi que Laragon pour accèder à ces différents outils (interpreteur PHP, serveur Local et SGBD). pour finir j'ai utilisé github pour le versionning et le partage du projet.

merci d'avoir lu jusque la ! en espèrant que ce projet vous aura plus autant qu'il m'a fait plaisir de le créer !













#   B D D _ A D M I S S I O N 
 
 