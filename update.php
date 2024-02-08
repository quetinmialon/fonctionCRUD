<?php
require ('functions.php');

// lancement de nos fonctions pour récuperer les valeurs des champs de l'entré ciblé (et present dans l'url via son ID)
$pdo = getPDO("mysql:host=localhost;dbname=recipes", "root", "");
$recipes = getrecipesWithCategories($pdo);
$recipe = getrecipeWithCategory($pdo, intval($_GET['id'])); // utilisation de la fonction intval pour empecher la faille XSS, $_GET recupère une partie de l'URL pour faire un affichage dynamique de la page
$categories = getAllCategories($pdo);


if (! empty($_POST)) { // si la superglobale $_POST contient quelque chose ça signigie qu'il faut lancer une modification sur la page en cours, donc appel de la fonction updaterecipe()
    $status = updaterecipe($pdo, $_POST['title'], $_POST['excerpt'],$_POST['category_id'],$_POST['body'],$_POST['img_url']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>modification</title>
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
<form action="" method="post" class="p-8 max-w-md mx-auto">
    <div class = "relative z-0 w-full mb-5 group">
    <label for="title" class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">titre</label>
    <input type="text" name ="title" value = "<?= $recipe['title']?>" maxlength="100" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
    </div>
    <div class = "relative z-0 w-full mb-5 group">
    <label for="excerpt" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">extrait</label>
    <input type="text" name ="excerpt"value ="<?= $recipe['excerpt']?>" maxlength="250" class= "block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
    </div>
    <div class = "relative z-0 w-full mb-5 group">
    <label for="img_url" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">URL de l'image</label>
    <input type="text" name ="img_url"value ="<?= $recipe['img_url']?>" class= "block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer">
    </div>
    <select name="category_id" id="" class ="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
        <option value="<?=$recipe['category_id']?>"><?=$recipe['name']?></option>
        <?php foreach($categories as $category) :?>
            <option value = "<?= $category['id']?>"><?= $category['name']?></option>
        <?php endforeach; ?>
       
   
    </select>
    <label for="body" class = "block mb-2 text-sm font-medium text-gray-900 ">body</label>
    <textarea value="<?=$recipe['body']?>" name="body" id="" cols="60" rows="20" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"><?=$recipe['body']?></textarea>
     <input type="submit" value="modifier votre recette" class = "bg-emerald-400 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
    </form>
    
</body>
</html>