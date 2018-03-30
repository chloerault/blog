<!-- connexion à la base de données -->
<?php include('include/pdo.php'); ?>

<!-- connexion avec le fichier functions.php -->
<?php include('include/functions.php'); ?>

<?php

// Condition si l'id de l'article est présent dans l'URL
if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Commentaires à publier
    $sql = "SELECT * FROM comments WHERE id = :id";
    
    $query = $pdo->prepare($sql);

    $query->bindValue(':id',$id,PDO::PARAM_INT);

    $query->execute();
    
    $comments = $query->fetch();

    // debug($comments);

    // Publier l'article
    if(!empty($comments['id'])) {

        // Mettre à jour les données dans la table "articles"
        $sql = "UPDATE comments SET statut= 'actif' WHERE id = :id"; 

        $query = $pdo->prepare($sql);

        $query->bindValue(':id',$id,PDO::PARAM_INT);
      
        $query->execute();
        
    }

} else {
    // Fausse redirection
    die('Error 404 Not Found');
}

// Redirection
header('Location: single.php?id=' . $comments['id_article']);

?>