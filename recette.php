<?php
require('functions.php');
//appel des fonctions liant la page à la BDD
$pdo = getPDO("mysql:host=localhost;dbname=recipes", "root", "");
$recipes = getRecipesWithCategories($pdo);
$recipe = getRecipeWithCategory($pdo, intval($_GET['id']));
$categories = getAllCategories($pdo);
$comments = getAllCommentsOfArecipe($pdo, intval($_GET['id']));
if (!empty($_POST['content'])) { // vérifie si la superglobale POST est vide ou non, si elle contient des info, alors on lance la création d'un commentaire
    $status = recipeComment($pdo, intval($_GET['id']), $_POST['content']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>recette</title>
</head>
<header>
    <nav class="flex justify-center gap-1 p-2 bg-neutral-400 color-white">
        <a href="index.php"><button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">accueil</button></a>
        <a href="create.php"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">créer
                une nouvelle recette</button></a>
        <a href="delete.php"><button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">supprimer une
                recette</button></a>
        <?php foreach ($categories as $category): ?>
            <a href="category.php?id=<?= $category['id'] ?>">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <?= $category['name'] ?>
                </button>
            </a>

        <?php endforeach ?>
    </nav>
</header>

<body>
    <div class="container my-24 mx-auto md:px-6">
       
        <section class="mb-32">
            
            <div class="container mx-auto text-center lg:text-left xl:px-32">
                <article class="flex grid items-center lg:grid-cols-2">
                    <div class="mb-12 lg:mb-0">
                        <div
                            class="relative z-[1] block rounded-lg bg-[hsla(0,0%,100%,0.55)] px-6 py-12 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] backdrop-blur-[30px] md:px-12 lg:-mr-14">

                            <h2 class="mb-8 text-3xl font-bold">
                                <?= $recipe['title'] ?>
                            </h2>
                            <div class="mx-auto mb-8 flex flex-col md:flex-row md:justify-around lg:justify-between">
                                <time class="mx-auto mb-4 flex items-center md:mx-0 md:mb-2 lg:mb-0"
                                    datetime="<?= $recipe['recipesCreatedAt'] ?>">
                                    <?= $recipe['recipesCreatedAt'] ?>
                                </time>
                                <div class="mx-auto mb-4 flex items-center md:mx-0 md:mb-2 lg:mb-0">
                                    <?= $recipe['name'] ?>
                                </div>
                                <a href="update.php?id=<?= $recipe['recipesId'] ?>"><button
                                        class="bg-emerald-400 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
                                        modifier la recette
                                    </button></a>
                            </div>
                            <div>

                                <?= $recipe['body'] ?>

                            </div>




                        </div>

                    </div>
                    <img class="w-full rounded-lg shadow-lg" src="<?= $recipe['img_url'] ?>"
                        alt="">
                </article>
            </div>
        </section>
        <section class="bg-white py-8 lg:py-16 antialiased">
            <div class="max-w-2xl mx-auto px-4">
                <div class="flex justify-between items-center mb-6">
                     <h2 class="text-lg lg:text-2xl font-bold text-gray-900">Commentaires</h2>
                </div>
                <form action="" method="post" class="mb-6">
                    <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 ">
                        <label for="content" class="sr-only">contenu du commentaire</label>
                        <textarea name="content" rows="6" class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none"></textarea>
                    </div>    
                    <input placeholder="écrivez votre commentaire..." type="submit" value="poster le commentaire" class = "bg-emerald-400 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
                    
                </form>
                <?php foreach ($comments as $comment): ?>
                    <div class="text-gray-500 p-6">
                        <?= $comment['content'] ?>
                    </div>
                <?php endforeach ?>
        </section>

</body>

</html>