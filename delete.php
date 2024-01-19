<?php 
require ('functions.php');
$pdo = getPDO("mysql:host=localhost;dbname=blog", "root", "");
$posts = getPostsWithCategories($pdo);
$categories = getAllCategories($pdo);
if(! empty($_POST)){
    $status = deletePost($pdo,$_POST['id']);
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
    <form action="" method ="post">
        <label for="id"></label>
        <select name="id">
            <?php foreach ($posts['data'] as $post): ?>
                <option value="<?= $post['postsId'] ?>"><?= $post['title'] ?></option>
            <?php endforeach ?>   
        </select>
        <input type="submit" value="Supprimer le poste">
    </form>
</body>
</html>