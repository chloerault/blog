<!-- connexion à la base de données -->
<?php include('include/pdo.php'); ?>

<!-- connexion avec le fichier functions.php -->
<?php include('include/functions.php'); ?>

<?php

if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    // echo $id;
} else {
    die('404');
}

///////////////////////////////////////////

// MONTRER LE FORMULAIRE PRE-REMPLI

$sql = "SELECT id, title, content, auteur, created_at FROM articles WHERE id = $id";

$query = $pdo->prepare($sql);

$query->execute();

$articles = $query->fetch();

// debug($articles);

///////////////////////////////////////////

// MONTRER LES COMMENTAIRES

$sql = "SELECT id, id_article, content, auteur, created_at, statut FROM comments WHERE statut = 'inactif' ORDER BY created_at DESC";

$query = $pdo->prepare($sql);

$query->execute();

$comments = $query->fetchAll();

// debug($comments);

/*
 * VERIFICATION DU FORMULAIRE
 */

// laisser vide le tableau de l'erreur que l'on rempli pour chaque vérification
$error = array();

// si on appuie sur le bouton "ajouter"
if (!empty($_POST['submit'])) {
    // debug($_POST);
    // die();

    // Protections XSS    
    $name = trim(strip_tags($_POST['name']));
    $titre = trim(strip_tags($_POST['titre']));
    $article = trim(strip_tags($_POST['article']));
    $statut = trim(strip_tags($_POST['statut']));
    
    /*
     * TAILLE AUTEUR
     */

    $error = validation($error,$name,'name',2,20);

    /*
     * TAILLE TITRE
     */
    
    $error = validation($error,$titre,'titre',2,40);

    /*
     * TAILLE ARTICLE
     */

    $error = validation($error,$article,'article',2,1000);

    /*
     * CHOIX STATUT
     */

    if(empty($statut)){
        $error['statut'] = 'Public ou privé ?';
    }

    // si aucune erreur dans le formulaire, update de la base de données
    if(count($error) == 0) {
        $success = true;
        // die('michel');

        // Mettre à jour les données dans la table "articles"
        $sql = "UPDATE articles SET title=:titre, content=:article, auteur=:name, update_at=NOW(), statut=:statut WHERE id = :id"; 

        $query = $pdo->prepare($sql);

        $query->bindValue(':titre',$titre,PDO::PARAM_STR);
        $query->bindValue(':article',$article,PDO::PARAM_STR);
        $query->bindValue(':name',$name,PDO::PARAM_STR);
        $query->bindValue(':statut',$statut,PDO::PARAM_STR);
        $query->bindValue(':id',$id,PDO::PARAM_INT);
      
        $query->execute();

        // Redirection vers la page dashboard
        header('Location: dashboard.php');
    
    } // fin du if si aucune erreur, update fait

} // fin du if (clique sur le bouton 'modifier')

?>


<?php include('include/headerback.php'); ?>

            <span class="menu"><a href="index.php" class="menu">blog</a></span>
            <span class="menu"><a href="dashboard.php" class="menu">articles</a></span>
            <!-- <span class="menu"><a href="newpost.php" class="menu">nouvel article</a></span> -->
        </div>
    </header>

    <!-- CONTENU PRINCIPAL -->
    <div class="main-content">

        <h4>Article</h4>

        <hr class="hr">

        <a href="deletearticle.php?id=<?php echo $articles['id'];?>">
            <img src="assets/img/croix2.png" title="Supprimer" class="suppr2">        
        </a>

        <form action="" method="post" class="form" novalidate>

            <div class="nom"> <!-- NOM -->
            <label for="name">Nom de l'auteur :</label>
            <input type="text" name="name" value="<?php echo $articles['auteur']; ?>">
            <!-- Message d'erreur -->            
            <div class="error"><?php if(!empty($error['name'])) { echo $error['name']; } ?></div>
            </div>

            <div class="titre"> <!-- TITRE -->
            <label for="titre">Titre de l'article :</label>
            <input type="text" name="titre" value="<?php echo $articles['title']; ?>">            
            <!-- Message d'erreur -->
            <div class="error"><?php if(!empty($error['titre'])) { echo $error['titre']; } ?></div>
            </div>

            <div class="article"> <!-- CHAMP ARTICLE -->
            <textarea name="article" placeholder="écrire son article ici..."><?php echo $articles['content']; ?></textarea>
            <!-- Message d'erreur -->
            <div class="error"><?php if(!empty($error['article'])) { echo $error['article']; } ?></div>
            </div>

            <label for="statut">Actif/inactif :</label>
            <?php $articles = array(
            'actif' => 'Public',
            'inactif' => 'Privé'
            ); ?>
            <select name="statut">
            <?php foreach ($articles as $key => $article) { ?>
                <option value="<?php echo $key; ?>" <?php if(!empty($articles['statut'])) { if($articles['statut'] == $article) { echo 'selected="selected"';}} ?>>
                <?php echo $article; ?>
                </option>
            <?php } ?>
            </select>
            <!-- Message d'erreur -->            
            <div class="error"><?php if(!empty($error['statut'])) { echo $error['statut']; } ?></div>

            <input type="submit" class="submit" name="submit" value="Modifier">
        </form>

        <br>

        <h4>Commentaires</h4>

        <hr class="hr">

        <!-- LISTE DES COMMENTAIRES -->
        <span class="liste">

            <?php foreach ($comments as $comment) {
                if($id == $comment['id_article']) {
                $date = date('d/m/Y', strtotime($comment['created_at']));
                $heure = date('H:i', strtotime($comment['created_at'])); ?>
                <div class="singleCom">
                    <a href="deletecomment.php?id=<?php echo $comment['id'];?>">
                        <img src="assets/img/croix.png" title="Supprimer" class="suppr3">
                    </a>
                    
                    <div class="apercCom">&quot;<?php echo $comment['content']; ?>&quot;</div>
                    <span class="pseudoCom"><?php echo $comment['auteur']; ?></span>
                    <span class="dateCom">, <?php echo $date .' '. $heure; ?></span>

                    <a href="publish.php?id=<?php echo $comment['id'];?>">
                        <img src="assets/img/tic.png" title="Publier" class="publi">
                    </a>
                    
                </div>
                <?php } ?>
            <?php } ?>         

        </span> <!-- fin .liste -->
        
        <div class="clear"></div>

    </div> <!-- fin .main-content -->

<div class="clear"></div>

<?php include('include/footerback.php'); ?>