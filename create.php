<?php 
require("functions.php");

$pdo = getPDO("mysql:host=localhost;dbname=recipes","root","");
$categories = getAllCategories($pdo);
if (! empty($_POST)) { // si la superglobale n'est pas vide, on appel la fonction de création d'une recette car le formulaire a été rempli (car la methode post en HTML permet de stocker des info dans la superglobale et de raffraichir la page avec ces info conservées)
$status = createRecipe($pdo, $_POST['title'], $_POST['excerpt'], $_POST ['category_id'],$_POST['body'],$_POST['img_url']);
unset($_POST);// on vide post pour éviter de surcharger la superglobal dans l'éventualité de plusieurs raffraichissement successif ou pour éviter d'avoir des informations résiduel d'un autre ajout.
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>création</title>
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
    <form action="" method="post" class = "p-8 max-w-md mx-auto">
        <div class = "relative z-0 w-full mb-5 group">
            <label for="title" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Titre de la recette</label>
            <input type="text" name ="title" value = "title" maxlength="100" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer">
        </div>
        <div class = "relative z-0 w-full mb-5 group">
            <label for="excerpt"  class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">extrait de la recette</label>
            <input type="text" name ="excerpt"value ="excerpt" maxlength="250" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer">
        </div>
        <div class = "relative z-0 w-full mb-5 group">
            <label for="img_url" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600  peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">URL de l'image</label>
            <input type="text" name="img_url" value ="img_url" maxLength="500" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer">
    <select name="category_id" id="" class ="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
        <?php foreach($categories as $category) :?>
            <option value = "<?= $category['id']?>"><?= $category['name']?></option>
        <?php endforeach; ?>
   
    </select>
    <label for="body" class = "block mb-2 text-sm font-medium text-gray-900 ">la recette en détails</label>
    <textarea value="body" name="body" id="" cols="60" rows="20" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
     <input type="submit" value="poster votre recette" class = "bg-emerald-400 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
    </form>
</body>
</html>