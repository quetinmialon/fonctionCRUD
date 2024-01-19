<?php


function getPDO(string $dsn, string $user='root', string $pass = ''){

    $pdo = new PDO($dsn, $user, $pass);
    return $pdo;
}


// Seulement des définitions de fonctions ici ! Aucun appel
function getPostsWithCategories(PDO $pdo, int $page = 1, int $perPage= 9999999){
    $offset = ($page - 1) * $perPage;
    $query = $pdo->query('SELECT COUNT(*) FROM posts'); 
    $totalItems = $query->fetchColumn(); 
    $totalPages = ceil($totalItems / $perPage); 
    $query = $pdo->prepare('SELECT posts.id AS postsId, title, excerpt, posts.created_at AS postsCreatedAt, body, category_id, 
    categories.name FROM posts 
    LEFT JOIN categories ON category_id = categories.id
    ORDER BY posts.created_at DESC LIMIT :limit OFFSET :offset');
    $query->bindValue('offset', $offset, PDO::PARAM_INT);
    $query->bindValue('limit', $perPage, PDO::PARAM_INT);
    $query->execute();
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);
    $data = [
        'count'=> $totalItems,
        'per_page'=> $perPage,
        'page'=> [
            'current'=> $page,
            'total_page'=> $totalPages,
        ],
        'data'=> $posts
    ];
    return $data;
    
} 
function getPostWithCategory(PDO $pdo, int $id) {

        $query = $pdo->prepare('SELECT posts.id AS postsId, title, excerpt, posts.created_at AS postsCreatedAt, body, category_id, 
            categories.name FROM posts 
            LEFT JOIN categories ON category_id = categories.id
            WHERE posts.id = :postsId');
        $query->bindParam("postsId", $id, PDO::PARAM_INT);
        $query->execute();
        $post = $query->fetch(PDO::FETCH_ASSOC);
        return $post;
}


function getPostsByCategory(PDO $pdo, int $idCategorie, array $posts, int $page =1, int $perPage=1) {
    if (array_key_exists($idCategorie, $posts)){
    $offset = ($page - 1) * $perPage;
    $query = $pdo->prepare('SELECT COUNT(*) FROM posts JOIN categories ON category_id = categories.id WHERE category_id = :id'); 
    $query->bindParam('id', $idCategorie, PDO::PARAM_INT);
    $query->execute();
    $totalItems = $query->fetchColumn(); 
    $totalPages = ceil($totalItems / $perPage); 
    $query = $pdo->prepare('SELECT posts.id AS postsId, title, excerpt, posts.created_at AS postsCreatedAt, body, category_id, 
    categories.name FROM posts 
    JOIN categories ON category_id = categories.id    
    WHERE category_id = :id LIMIT :limit OFFSET :offset');
    $query->bindParam('limit', $perPage, PDO::PARAM_INT); 
    $query->bindValue('offset', $offset, PDO::PARAM_INT);
    $query->bindParam('id', $idCategorie, PDO::PARAM_INT);
    $query->execute();
    $postsCategorie = $query->fetchAll(PDO::FETCH_ASSOC);
    $data = [
        'count'=> $totalItems,
        'per_page'=> $perPage,
        'page'=> [
            'current'=> $page,
            'total_page'=> $totalPages,
        ],
        'data'=> $postsCategorie
    ];
    
    return $data;}
    else{
        return false;
    }}

function getAllCategories($pdo){
        $query = $pdo->query('SELECT name, id FROM categories', PDO :: FETCH_ASSOC);
        $categories = $query->fetchAll();
        return $categories;
    }

function createPost(PDO $pdo, string $title, string $excerpt, int $category_id, string $body ){
        if(! empty($title) && ! empty ($excerpt) && !empty($body)){

        $query = $pdo->prepare('INSERT INTO posts(title, excerpt, category_id, body)VALUES (:title, :excerpt, :category_id, :body)');
            if ($category_id == -1) {
                $query->bindValue('category_id', NULL, PDO::PARAM_NULL);
            } else {
                $query->bindParam('category_id', $category_id, PDO::PARAM_INT);
            }        $query->bindParam('title', $title,PDO::PARAM_STR);
        $query->bindParam('excerpt', $excerpt,PDO::PARAM_STR);
        $query->bindParam('body', $body,PDO::PARAM_STR);
        $query->execute();
        $status = 'poste publié';
        // header('location: create.php');
        return $status;
    }else{
        unset($_POST);
        $status = 'poste non publié';
        header('location: create.php');

    }}


function updatePost(PDO $pdo, string $title, string $excerpt, int $category_id, string $body, int $id){
        if(! empty($title) && ! empty ($excerpt) && !empty($body)){

            $query = $pdo->prepare('UPDATE posts SET title = :title, excerpt = :excerpt, category_id = :category_id, body = :body WHERE id = :id');
                if ($category_id == -1) {
                    $query->bindValue('category_id', NULL, PDO::PARAM_NULL);
                } else {
                    $query->bindParam('category_id', $category_id, PDO::PARAM_INT);
                }        $query->bindParam('title', $title,PDO::PARAM_STR);
            $query->bindParam('excerpt', $excerpt,PDO::PARAM_STR);
            $query->bindParam('body', $body,PDO::PARAM_STR);
            $query->bindValue('id', $_GET['id'], PDO::PARAM_INT);
            $query->execute();
            $_POST['status'] = 'poste modifié';
            return $_POST['status'];
        }else{
            unset($_POST);
            $_POST['status'] = 'poste non modifié';
            header('location: index.php');
    
        }}
function deletePost(PDO $pdo, int $id){
    $query = $pdo->prepare('DELETE FROM posts WHERE id = :id');
    $query->bindParam('id',$id, PDO::PARAM_INT);
    $query->execute();
    $status = 'poste supprimé';
    return $status;
}


function getAllCommentsOfAPost(PDO $pdo, int $id){
    $query = $pdo->prepare('SELECT id, post_id, content FROM comments WHERE post_id = :id');
    $query->bindParam('id',$id, PDO::PARAM_INT);
    $query->execute();
    $comments = $query->fetchAll(PDO::FETCH_ASSOC);
    return $comments;
}

function postComment(PDO $pdo, int $id, string $content){
    $query = $pdo->prepare('INSERT INTO comments(content, post_id) VALUES (:content, :post_id)');
    $query->bindParam('post_id',$id, PDO::PARAM_INT);
    $query->bindParam('content',$content, PDO::PARAM_STR);
    $query->execute();
    $status = 'commentaire posté';
    return $status;

}