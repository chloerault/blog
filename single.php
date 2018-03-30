<!-- connexion à la base de données -->
<?php include('include/pdo.php'); ?>

<!-- connexion avec le fichier functions.php -->
<?php include('include/functions.php'); ?>

<?php

/*
 * MONTRER LES ARTICLES EN FONCTION DE L'ID
 */

if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    // echo $id;
} else {
    // Fausse redirection
    die('404');
}

// Déclarer la requête
// $sql = "SELECT title, content, auteur, created_at, statut FROM articles ORDER BY created_at DESC";
$sql = "SELECT id, title, content, auteur, created_at, update_at FROM articles";
// Préparer la requête
$query = $pdo->prepare($sql);
// Exécuter la requête
$query->execute();
// Dire sous quelle forme
$articles = $query->fetchAll();

// debug($articles);

// $sql = "SELECT title, content, auteur, created_at, statut FROM articles ORDER BY created_at DESC";
$sql = "SELECT id_article, content, auteur, created_at FROM comments WHERE statut = 'actif' ORDER BY created_at DESC";
// Préparer la requête
$query = $pdo->prepare($sql);
// Exécuter la requête
$query->execute();
// Dire sous quelle forme
$comments = $query->fetchAll();

// debug($comments);

/*
 * VALIDER LE FORMULAIRE POUR LES COMMENTAIRES
 */

// laisser vide le tableau de l'erreur que l'on rempli pour chaque vérification
$error = array();

// si on appuie sur le bouton "ajouter"
if (!empty($_POST['submit'])) {
    // debug($_POST);
    // die();

    // Protections XSS    
    $pseudo = trim(strip_tags($_POST['pseudo']));
    $comm = trim(strip_tags($_POST['comm']));
    
    /*
     * TAILLE AUTEUR
     */

    $error = validation($error,$pseudo,'pseudo',2,20);

    /*
     * TAILLE ARTICLE
     */

    $error = validation($error,$comm,'comm',2,150);

    // si aucune erreur
    if(count($error) == 0) {
        $success = true;

        // Déclarer la requête
        $sql = "INSERT INTO comments (id_article, content, auteur, created_at, statut) VALUES (:id,:comm,:pseudo,NOW(),'inactif')";

        // Préparer la requête
        $query = $pdo->prepare($sql);

        $query->bindValue(':id',$id,PDO::PARAM_INT);
        $query->bindValue(':comm',$comm,PDO::PARAM_STR);
        $query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
        
        // Exécuter la requête
        $query->execute();

        // Redirection vers la page dashboard
        header('Location: single.php?id='. $id);
    
    } // fin condition pour ajouter un commentaire

}

?>


<?php include('include/headerfront.php'); ?>

    <!-- CONTENU PRINCIPAL -->
    <div class="main-content">

        <?php foreach ($articles as $article) { ?>
            <?php if($id == $article['id']) { ?>
                <?php $date = date('d/m/Y', strtotime($article['created_at'])); ?>
                <?php $dateModif = date('d/m/Y', strtotime($article['update_at'])); ?>
                <?php $heure = date('H:i', strtotime($article['created_at'])); ?>
                <?php $heureModif = date('H:i', strtotime($article['update_at'])); ?>
                <article class="article2">
                    <div class="titre2"><?php echo $article['title']; ?></div>
                    <hr class="hr">                    
                    <p class="contenu2">&quot;<?php echo $article['content']; ?>&quot;</p>
                    <br>
                    <span class="auteur2"><?php echo $article['auteur']; ?></span>                
                    <span class="date2">, <?php echo $date .' '. $heure; ?></span>
                    <span class="dateModif">
                        <?php if($article['update_at'] != NULL) {
                                echo 'Modifié le ' . $dateModif .' à '. $heureModif;
                            } ?>
                    </span>
                </article>
            <?php } ?>
        <?php } ?>

        <div class="clear"></div>

        <h4>Commentaires</h4>

        <hr class="hr">

        <div class="clear"></div>        

        <div class="commentaires">
            <form action="" method="post" novalidate>
                <div class="pseudo"> <!-- NOM -->
                    <h5 class="ajouterCom">Ajouter ton commentaire :</h6>
                    <input type="text" name="pseudo" id="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>" placeholder="Ton nom">            
                    <!-- Message d'erreur -->
                    <div class="error"><?php if(!empty($error['pseudo'])) { echo $error['pseudo']; } ?></div>
                </div>
    
                <div class="comm"> <!-- CHAMP COMMENTAIRE -->
                    <textarea name="comm" placeholder="écrire son commentaire ici..."><?php if(!empty($_POST['comm'])) { echo $_POST['comm']; } ?></textarea>
                    <!-- Message d'erreur -->
                    <div class="error"><?php if(!empty($error['comm'])) { echo $error['comm']; } ?></div>
                </div>
    
                <input type="submit" class="submit" name="submit" value="Commenter">
            </form>
        </div>

        <?php foreach ($comments as $comment) { ?>
            <?php if($id == $comment['id_article']) { ?>
                <?php $date = date('d/m/Y', strtotime($comment['created_at'])); ?>
                <?php $heure = date('H:i', strtotime($comment['created_at'])); ?>
                <div class="commentaires">
                    <div class="bloc">
                        <p class="comm2"><?php echo $comment['content']; ?></p>
                        <span class="pseudo2"><?php echo $comment['auteur']; ?></span>      
                        <span class="date3">, <?php echo $date .' '. $heure; ?></span>
                    </div>
                    <hr class="hr">
                </div>
           <?php } ?>
        <?php } ?>

        <div class="clear"></div>        

    </div> <!-- fin .main-content -->

    <div class="clear"></div>    

<?php include('include/footerfront.php'); ?>