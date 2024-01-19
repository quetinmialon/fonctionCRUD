<?php
require('functions.php');
$pdo = getPDO("mysql:host=localhost;dbname=blog", "root", "");
$posts = getPostsWithCategories($pdo);
$post = getPostWithCategory($pdo, intval($_GET['id']));
$categories = getAllCategories($pdo);
$comments = getAllCommentsOfAPost($pdo, intval($_GET['id']));
if(! empty($_POST['content'])){
    $status = postComment($pdo,intval($_GET['id']),$_POST['content']);
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
    <article style='display : flex; flex-direction : column; padding : 25px;'>
        <div>
            <?= $post['title'] ?>
        </div>
        <time datetime="<?= $post['postsCreatedAt'] ?>">
            <?= $post['postsCreatedAt'] ?>
        </time>
        <div>
            <?= $post['excerpt'] ?>
        </div>
        <div>
            <?= $post['name'] ?>
        </div>
        <div>
            <?= $post['body'] ?>
        </div>
        <a href="update.php?id=<?= $post['postsId'] ?>"><button>
                modifier le post
            </button></a>
    </article>
    <div>
        <?php if (!empty($comments)) { ?>
        <form action="" method="post">
            <label for="content">contenu du commentaire</label>
            <textarea name="content" id="" cols="60" rows="5"></textarea>
            <input type="submit" value="poster le commentaire">
        </form>
            <?php foreach ($comments as $comment): ?>
                <div>
                    <?= $comment['content'] ?>
                </div>
            <?php endforeach ?>
        <?php } else { ?>
            <div>
                NO COMMENT ON THIS POST
            </div>

        <form action="" method="post">
            <label for="content">contenu du commentaire</label>
            <textarea name="content" id="" cols="60" rows="5"></textarea>
            <input type="submit" value="poster le commentaire">
        </form>
        <?php } ?>
    </div>

</body>

</html>