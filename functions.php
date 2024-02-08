<?php

//fonction de connexion a notre BDD
function getPDO(string $dsn, string $user='root', string $pass = ''){ 

    $pdo = new PDO($dsn, $user, $pass); // créer une nouvelle instance de PDO  
    return $pdo; 
} 

// fonction READ de toutes les recettes avec un système de pagination intégré
function getRecipesWithCategories(PDO $pdo, int $page = 1, int $perPage= 9999999){ 
    $offset = ($page - 1) * $perPage; // définis un offset en fonction de la page a laquelle on se situe 
    $query = $pdo->query('SELECT COUNT(*) FROM recipes');  // compte le nombre d'entrée dans la table recipe
    $totalItems = $query->fetchColumn(); //associe cette valeur a la variable
    $totalPages = ceil($totalItems / $perPage);  // compte le nombre total de page
    $query = $pdo->prepare('SELECT recipes.id AS recipesId, title, excerpt, recipes.created_at AS recipesCreatedAt, body, img_url, category_id, 
    categories.name FROM recipes  
    LEFT JOIN categories ON category_id = categories.id 
    ORDER BY recipes.created_at DESC LIMIT :limit OFFSET :offset'); // requete SQL qui se prépare en fonction des parametres donnés a la fonction
    $query->bindValue('offset', $offset, PDO::PARAM_INT); // on bindvalue (ou bindparam) les informations qui proviennent du front pour se prévenir des injections SQL
    $query->bindValue('limit', $perPage, PDO::PARAM_INT); 
    $query->execute(); // on execute de manière safe
    $recipes = $query->fetchAll(PDO::FETCH_ASSOC); // on stock les info dans un tableau associatif lié a la variable
    $data = [
        'count'=> $totalItems, 
        'per_page'=> $perPage, 
        'page'=> [ 
            'current'=> $page, 
            'total_page'=> $totalPages, 
        ],
        'data'=> $recipes 
    ]; // on range toutes les info dans un tableau de métadonnés 
    return $data; // et on renvoie ce tableau dans la variable d'appel de la fonction
    
} 
//même principe de fonction a ceci pret qu'on choisit seulement d'afficher une seule entrée de la table recipe ici
function getRecipeWithCategory(PDO $pdo, int $id) { //le parametre id réfère a la clé primaire du notre table, c'est ce parametre qui va nous permettre de recupèrer la bonne entrée

        $query = $pdo->prepare('SELECT recipes.id AS recipesId, title, excerpt, recipes.created_at AS recipesCreatedAt, body, img_url, category_id, 
            categories.name FROM recipes  
            LEFT JOIN categories ON category_id = categories.id 
            WHERE recipes.id = :recipesId'); // c'est ici qu'on indique que l'id en parametre est l'id que l'on cherche en BDD
        $query->bindParam("recipesId", $id, PDO::PARAM_INT); 
        $query->execute(); 
        $recipe = $query->fetch(PDO::FETCH_ASSOC); // ici on a pas besoin d'un tableau associatif, on peut tout stocker dans une variable avec fetch() car on a qu'une entrée
        return $recipe; 
}

// même concept de fonction, ici on recupère seulement les info d'une catégorie 
function getRecipesByCategory(PDO $pdo, int $idCategorie, array $recipes, int $page =1, int $perPage=1){
    if (array_key_exists($idCategorie, $recipes)){ // on vérifie que la catégorie existe bien 
    $offset = ($page - 1) * $perPage; 
    $query = $pdo->prepare('SELECT COUNT(*) FROM recipes JOIN categories ON category_id = categories.id WHERE category_id = :id'); 
    $query->bindParam('id', $idCategorie, PDO::PARAM_INT); 
    $query->execute(); 
    $totalItems = $query->fetchColumn();  
    $totalPages = ceil($totalItems / $perPage);  
    $query = $pdo->prepare('SELECT recipes.id AS recipesId, title, excerpt, recipes.created_at AS recipesCreatedAt, body, img_url, category_id, 
    categories.name FROM recipes  
    JOIN categories ON category_id = categories.id     
    WHERE category_id = :id LIMIT :limit OFFSET :offset'); // on indique que l'on recupère seulement les entrée qui ont la bonne valeur de categorie_id
    $query->bindParam('limit', $perPage, PDO::PARAM_INT);  
    $query->bindValue('offset', $offset, PDO::PARAM_INT); 
    $query->bindParam('id', $idCategorie, PDO::PARAM_INT);  
    $query->execute(); 
    $recipesCategorie = $query->fetchAll(PDO::FETCH_ASSOC); 
    $data = [ 
        'count'=> $totalItems, 
        'per_page'=> $perPage, 
        'page'=> [ 
            'current'=> $page, 
            'total_page'=> $totalPages, 
        ], 
        'data'=> $recipesCategorie 
    ]; 
     
    return $data;} 
    else{ 
        return false; 
    }} 
  
    // cette fonction sert a recupèrer toutes les categorie existantes, c'est elle qui gère l'affichage de notre navbar entre autres
function getAllCategories($pdo){ 
        $query = $pdo->query('SELECT name, id FROM categories', PDO :: FETCH_ASSOC); 
        $categories = $query->fetchAll(); 
        return $categories; 
    }
 
    // cette fonction gère la création d'entrée dans notre BDD, on y retrouve les mêmes codes que dans les précédentes mais avec des verif supplémentaires 
function createRecipe(PDO $pdo, string $title, string $excerpt, int $category_id, string $body, string $img_url){
        if(! empty($title) && ! empty ($excerpt) && !empty($body) && ! empty($category_id) && ! empty($img_url)){ // on vérifie ici que tout les champs qui ne doivent pas etre vides sont bien remplis
 
        $query = $pdo->prepare('INSERT INTO recipes(title, excerpt, category_id, body, img_url)VALUES (:title, :excerpt, :category_id, :body, :img_url)');
           // via la requete INSERT INTO, on prépare l'ajout d'entrés avec les valeur associés a VALUES qui iront dans les différents champs spécifiés
        $query->bindValue('category_id', $category_id, PDO::PARAM_INT); 
        $query->bindValue('img_url',$img_url,PDO::PARAM_STR);
        $query->bindParam('title', $title,PDO::PARAM_STR);
        $query->bindParam('excerpt', $excerpt,PDO::PARAM_STR); 
        $query->bindParam('body', $body,PDO::PARAM_STR); 
        $query->execute(); 
        $status = 'recette publiée';  
        return $status; 
    }else{ 
        unset($_POST); 
        $status = 'recette non publiée'; 
        header('location: create.php'); 
 
    }} 

// même fonctionnement que la fonction d'ajout a ceci pret qu'on utilise UPDATE et SET au lieu de INSERT INTO et VALUES, la syntaxe change alors légèrement
function updateRecipe(PDO $pdo, string $title, string $excerpt, int $category_id, string $body, string $img_url){
        if(! empty($title) && ! empty ($excerpt) && !empty($body)){ 

            $query = $pdo->prepare('UPDATE recipes SET title = :title, excerpt = :excerpt, category_id = :category_id, body = :body, img_url = :img_url WHERE id = :id');
 
            $query->bindParam('category_id', $category_id, PDO::PARAM_INT); 
            $query->bindValue('img_url',$img_url,PDO::PARAM_STR); 
            $query->bindParam('title', $title,PDO::PARAM_STR);  
            $query->bindParam('excerpt', $excerpt,PDO::PARAM_STR); 
            $query->bindParam('body', $body,PDO::PARAM_STR); 
            $query->bindValue('id', htmlspecialchars($_GET['id']), PDO::PARAM_INT); 
            $query->execute(); 
            $_POST['status'] = 'recette modifiée'; 
            return $_POST['status']; 
        }else{ 
            unset($_POST); 
            $_POST['status'] = 'recette non modifiée'; 
            header('location: index.php'); 
     
        }} 

        // fonction de suppression d'une entrée dans la table recipe en fonction de son ID
function deleteRecipe(PDO $pdo, int $id){ 
    $query = $pdo->prepare('DELETE FROM recipes WHERE id = :id'); 
    $query->bindParam('id',$id, PDO::PARAM_INT); 
    $query->execute(); 
    $status = 'recette supprimée'; 
    return $status; 
}

// fonction de recupèration de toutes les entrées de la table comments ou le champ recipe_id est égal a l'id entré en parametre de fonction
function getAllCommentsOfARecipe(PDO $pdo, int $id){
    $query = $pdo->prepare('SELECT id, recipe_id, content FROM comments WHERE recipe_id = :id');
    $query->bindParam('id',$id, PDO::PARAM_INT);
    $query->execute();
    $comments = $query->fetchAll(PDO::FETCH_ASSOC);
    return $comments;
}
//ajout d'une entrée dans la table commentaire, recipe_id étant un parametre de fonction permettant de savoir a quel recette est lié le commentaire
function recipeComment(PDO $pdo, int $id, string $content){
    $query = $pdo->prepare('INSERT INTO comments(content, recipe_id) VALUES (:content, :recipe_id)');
    $query->bindParam('recipe_id',$id, PDO::PARAM_INT);
    $query->bindParam('content',$content, PDO::PARAM_STR);
    $query->execute();
    $status = 'commentaire posté';
    return $status;

}