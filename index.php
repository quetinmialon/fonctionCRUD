<?php
require("functions.php");
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = isset($_GET['perPage']) ? $_GET['perPage'] : 5;
$pdo = getPDO("mysql:host=localhost;dbname=blog", "root", "");
$posts = getPostsWithCategories($pdo, $page, $perPage);
$categories = getAllCategories($pdo);
// Seulement des appels de fonctions ici ! Aucune définition
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
    <div class="conteneur">
    <?php 
    foreach ($posts['data'] as $post): ?>
   <article style ='display : flex; flex-direction : column; padding : 25px;'>
        <div><?=$post['title']?></div>
        <time datetime="<?= $post['postsCreatedAt'] ?>">
            <?= $post['postsCreatedAt'] ?>
        </time>
        <div>
            <?= $post['excerpt'] ?>
        </div>
        <div>
            <?= $post['name'] ?>
        </div>
        <a href="update.php?id=<?=$post['postsId']?>"><button>
            modifier le post
        </button></a>

        <a href="poste.php?id=<?=$post['postsId']?>"><button>consulter le poste</button></a>
   </article>
   <?php endforeach ?>
</div>

</body>
    <footer style="display : flex; flex-direction : row; gap : 30px">

    <ul>
        <?php for ($i = 1; $i <= $posts['page']['total_page']; $i++): ?>
            <li><a href="?page=<?=htmlspecialchars($i)?>&perPage=<?=htmlspecialchars($perPage)?>">
                    <?= htmlspecialchars($i) ?>
                </a></li>
        <?php endfor; ?>
    </ul>
        <form action="" method="get">
            <label for="perPage">Nombre de poste par page:</label>
            <select name="perPage">
                <option value="5" <?php echo ($perPage == 5) ? 'selected' : ''; ?>>5</option>
                <option value="10" <?php echo ($perPage == 10) ? 'selected' : ''; ?>>10</option>
                <option value="15" <?php echo ($perPage == 15) ? 'selected' : ''; ?>>15</option>
            </select>
            <input type="submit" value="Appliquer">
        </form>
    </footer>
</html>
