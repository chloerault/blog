<!-- connexion à la base de données -->
<?php include('include/pdo.php'); ?>

<!-- connexion avec le fichier functions.php -->
<?php include('include/functions.php'); ?>

<?php

// Afficher les 3 premiers articles (LIMIT 3) de la base de données "articles"
// Déclarer la requête
// $sql = "SELECT title, content, auteur, created_at, statut FROM articles ORDER BY created_at DESC";
$sql = "SELECT id, title, content, auteur, created_at, statut FROM articles WHERE statut = 'actif' ORDER BY created_at DESC";
// Préparer la requête
$query = $pdo->prepare($sql);
// Exécuter la requête
$query->execute();
// Dire sous quelle forme
$articles = $query->fetchAll();

// debug($articles);

?>

<?php include('include/headerfront.php'); ?>

    <!-- CONTENU PRINCIPAL -->
    <div class="main-content">

        <!-- LISTE DES ARTICLES -->
        <div class="liste">

            <?php foreach ($articles as $article) { ?>
                <?php $date = date('d/m/Y', strtotime($article['created_at'])); ?>
                <?php $heure = date('H:i', strtotime($article['created_at'])); ?>
                <?php $contenu = substr($article['content'], 0, 175); ?>
                <article class="article">
                    <a href="single.php?id=<?php echo $article['id'];?>" class="singlearticle" title="Lire la suite">
                        <div class="titre"><?php echo $article['title']; ?></div>                
                        <p class="contenu">&quot;<?php echo $contenu; ?>...&quot;</p>
                        <div class="auteur"><?php echo $article['auteur']; ?></div>                
                        <div class="date"><?php echo $date .' '. $heure; ?></div>
                    </a>
                </article>
            <?php } ?>

        </div> <!-- fin .liste -->

    </div> <!-- fin .main-content -->


<?php include('include/footerback.php'); ?>