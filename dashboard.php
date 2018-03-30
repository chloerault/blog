<!-- connexion à la base de données -->
<?php include('include/pdo.php'); ?>

<!-- connexion avec le fichier functions.php -->
<?php include('include/functions.php'); ?>

<?php

$sql = "SELECT id, title, content, auteur, created_at, statut, update_at  FROM articles ORDER BY created_at DESC";

$query = $pdo->prepare($sql);

$query->execute();

$articles = $query->fetchAll();

// debug($articles);

?>

<?php include('include/headerback.php'); ?>

            <span class="menu"><a href="index.php" class="menu">blog</a></span>
            <!-- <span class="menu"><a href="dashboard.php" class="menu">articles</a></span> -->
            <span class="menu"><a href="newpost.php" class="menu">nouvel article</a></span>
        </div>
    </header>

    <!-- CONTENU PRINCIPAL -->
    <div class="main-content">

        <!-- LISTE DES ARTICLES -->
        <span class="liste">

            <?php foreach ($articles as $article) {
                $date = date('d/m/Y', strtotime($article['created_at']));
                $dateUpdate = date('d/m/Y', strtotime($article['update_at']));
                $heure = date('H:i', strtotime($article['created_at']));
                $heureUpdate = date('H:i', strtotime($article['update_at']));
                $contenu = substr($article['content'], 0, 100); ?>
                <a href="editpost.php?id=<?php echo $article['id'];?>" class="single">

                    <img src="assets/img/croix.png" title="Supprimer" class="suppr1">

                    <div class="titre1"><?php echo $article['title']; ?></div>
                    <div class="aperc1">&quot;<?php echo $contenu; ?>...&quot;</div>
                    <div class="date1"><?php echo $date .' '. $heure; ?></div>
                    <div class="dateUpdate">
                        <?php if($article['update_at'] != NULL) {
                                echo 'Modifié le ' . $dateUpdate .' à '. $heureUpdate;
                            } ?>
                    </div>
                </a>
            <?php } ?>

        <div class="clear"></div>            

        </span> <!-- fin .liste -->

    </div> <!-- fin .main-content -->

<div class="clear"></div>

<?php include('include/footerback.php'); ?>