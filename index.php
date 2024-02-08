<?php
require("functions.php");

// on vérifie que la superglobale contient ou non des informations sur la pagination dans l'URL, on met par défaut une valeur de page a 1 et de par page a 3 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = isset($_GET['perPage']) ? $_GET['perPage'] : 3;

//appel de nos fonctions pour recupérer les info dans la BDD
$pdo = getPDO("mysql:host=localhost;dbname=recipes", "root", "");
$recipes = getRecipesWithCategories($pdo, $page, $perPage);
$categories = getAllCategories($pdo);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>accueil</title>


</head>


<header>
    <nav class ="flex justify-center gap-1 p-2 bg-neutral-400 color-white">
        <a href="index.php"><button class ="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">accueil</button></a>
        <a href="create.php"><button class ="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">créer une nouvelle recette</button></a>
        <a href="delete.php"><button class ="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">supprimer une recette</button></a>
        <?php foreach ($categories as $category): ?>
            <a href="category.php?id=<?= $category['id'] ?>">
                <button class ="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <?= $category['name'] ?>
                </button>
            </a>

        <?php endforeach ?>
    </nav>
</header>
<body>
    <div class="flex flex-wrap p-16 gap-2 bg-neutral-300 justify-center">
    <?php 
    foreach ($recipes['data'] as $recipe): // lancement d'une boucle foreach qui va créer un article par entré dans notre table recipes sur notre BDD?>
    <a href="recette.php?id=<?=$recipe['recipesId']?>">
    <article class ="w-30% h-[38vw] group w-[25vw] transition-all hover:translate-y-[-50px] bg-white rounded-lg">
        <div class="w-full h-[15vw] overflow-hidden rounded-t-lg">
            <img class="object-cover w-full h-full rounded-t-lg group-hover:scale-[1.2] group-hover:saturate-[4]" src="<?=$recipe['img_url']?>" >

        </div>
        <div class="flex flex-col gap-4 p-4">
        <div class ="text-3xl"><?=$recipe['title']?></div>
        <div class ="text-2xl">
            <?= $recipe['name'] ?>
        </div>
        <time datetime="<?= $recipe['recipesCreatedAt'] ?>">
            <?= $recipe['recipesCreatedAt'] ?>
        </time>
        
        <div>
            <?= $recipe['excerpt'] ?>
        </div>
        </div>

        <div class ="flex justify-center gap-1 p-2">
        <a href="update.php?id=<?=$recipe['recipesId']?>"><button class ="bg-emerald-400 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
            modifier la recette
        </button></a>
        </div>
    </article>
    </a>
   <?php endforeach // fin de la boucle foreach ?>
</div>

</body>
    <footer class="flex justify-around bg-white">
    <div class ="flex justify-center">

    <ul class="flex items-center -space-x-px h-8 text-sm">
        <?php for ($i = 1; $i <= $recipes['page']['total_page']; $i++): ?>
            <li class ="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"><a href="?page=<?=htmlspecialchars($i)?>&perPage=<?=htmlspecialchars($perPage)//lien vers une page dont l'url comporte les informations sur la page ainsi que le nombre d'objet par page, on exclus les failles XSS avec la fonction htmlspecialchars()?>">
                    <?= htmlspecialchars($i) ?>
                </a></li>
        <?php endfor; ?>
    </ul>
    </div>
    
        <form action="" method="get">
            <label for="perPage">Nombre de recette par page:</label>
            <select name="perPage">
                <option value="3" <?php echo ($perPage == 3) ? 'selected' : ''; ?>>3</option>
                <option value="6" <?php echo ($perPage == 6) ? 'selected' : ''; ?>>6</option>
                <option value="12" <?php echo ($perPage == 12) ? 'selected' : ''; ?>>12</option>
            </select>
            <input type="submit" value="Appliquer">
        </form>
    </footer>
</html>
