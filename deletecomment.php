<!-- connexion à la base de données -->
<?php include('include/pdo.php'); ?>

<!-- connexion avec le fichier functions.php -->
<?php include('include/functions.php'); ?>

<?php

// Condition si l'id de l'article est présent dans l'URL
if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Articles à supprimer
    $sql = "SELECT * FROM comments WHERE id = :id";
    
    $query = $pdo->prepare($sql);

    $query->bindValue(':id',$id,PDO::PARAM_INT);

    $query->execute();
    
    $comments = $query->fetch();

    // debug($articles);

    // Supprimer l'article
    if(!empty($comments['id'])) {

        $sql = "DELETE FROM comments WHERE id = :id";
        
        $query = $pdo->prepare($sql);

        $query->bindValue(':id',$id,PDO::PARAM_INT);

        $query->execute();

        // $comments = $query->fetch();
        
        }

} else {
    // Fausse redirection
    die('Error 404 Not Found');
}

// Redirection
header('Location: editpost.php?id=' . $comments['id_article']);

?>