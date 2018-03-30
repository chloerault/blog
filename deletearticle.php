<!-- connexion à la base de données -->
<?php include('include/pdo.php'); ?>

<!-- connexion avec le fichier functions.php -->
<?php include('include/functions.php'); ?>

<?php

// Condition si l'id de l'article est présent dans l'URL
if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Articles à supprimer
    $sql = "SELECT * FROM articles WHERE id = :id";
    
    $query = $pdo->prepare($sql);

    $query->bindValue(':id',$id,PDO::PARAM_INT);

    $query->execute();
    
    $articles = $query->fetch();

    // debug($articles);

    // Supprimer l'article
    if(!empty($articles['id'])) {

        $sql = "DELETE FROM articles WHERE id = :id";
        
        $query = $pdo->prepare($sql);

        $query->bindValue(':id',$id,PDO::PARAM_INT);

        $query->execute();

        // $articles = $query->fetch();
        
    }

} else {
    // Fausse redirection
    die('Error 404 Not Found');
}

// Redirection
header('Location: dashboard.php');

?>