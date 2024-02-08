<?php 
require ('functions.php');
//appel des fonctions liant a notre BDD
$pdo = getPDO("mysql:host=localhost;dbname=recipes", "root", "");
$recipes = getRecipesWithCategories($pdo);
$categories = getAllCategories($pdo);
if(! empty($_POST)){ // si la superglobale post n'est pas vide, ça signifie qu'on doit supprimer l'entrée présente dans la BDD
    $status = deleteRecipe($pdo,$_POST['id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>suppression</title>
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
    <form action="" method ="post" class="p-8 max-w-md mx-auto">
        <label for="id"></label>
        <select name="id" class ="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
            <?php foreach ($recipes['data'] as $recipe): ?>
                <option value="<?= $recipe['recipesId'] ?>"><?= $recipe['title'] ?></option>
            <?php endforeach ?>   
        </select>
        <input type="submit" value="Supprimer la recette" class ="bg-emerald-400 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
    </form>
</body>
</html>