<?php 
require("functions.php");

$pdo = getPDO("mysql:host=localhost;dbname=blog","root","");
$categories = getAllCategories($pdo);
if (! empty($_POST)) {
$status = createPost($pdo, $_POST['title'], $_POST['excerpt'], $_POST ['category_id'],$_POST['body']);
unset($_POST);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<header>
<nav style="display : flex; flex-direction : row; gap : 20px">
        <a href="create.php"><button>créer un nouveau poste</button></a>
        <a href="delete.php"><button>supprimer un poste</button></a>
        <?php foreach ($categories as $category): ?>
            <a href="category.php?id=<?= $category['id'] ?>">
                <button>
                    <?= $category['name'] ?>
                </button>
            </a>

        <?php endforeach ?>
        <button>sans categories</button>
    </nav>
</header>
<body>
    <form action="" method="post">
    <label for="title">Titre du poste</label>
    <input type="text" name ="title" value = "title" maxlength="100">
    <label for="excerpt">extrait du poste</label>
    <input type="text" name ="excerpt"value ="excerpt" maxlength="150">
    <select name="category_id" id="">
        <option value="-1">sans catégorie</option>
        <?php foreach($categories as $category) :?>
            <option value = "<?= $category['id']?>"><?= $category['name']?></option>
        <?php endforeach; ?>
   
    </select>
    <label for="body">contenu de votre publication</label>
    <textarea value="body" name="body" id="" cols="60" rows="20" style="resize: both"></textarea>
     <input type="submit" value="poster votre publication">
    </form>
</body>
</html>