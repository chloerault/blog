<!-- connexion à la base de données -->
<?php include('include/pdo.php'); ?>

<!-- connexion avec le fichier functions.php -->
<?php include('include/functions.php'); ?>

<?php

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

    // FONCTION
    $error = validation($error,$name,'name',2,20);
    
    // IF/ELSE
    // if(!empty($name)){
    //     if(strlen($name) <= 2 ) {
    //         $error['name'] = 'Votre nom est trop court (min 3 caractères).';
    //     } else if(strlen($name) >= 20) {
    //         $error['name'] = 'Votre nom est trop long (max 20 caractères).';
    //     }
    // } else {
    //     $error['name'] = 'Donne ton pseudo !';
    // }

    /*
     * TAILLE TITRE
     */
    
    // FONCTION
    $error = validation($error,$titre,'titre',2,40);

    // IF/ELSE
    // if(!empty($titre)) {
    //     if(strlen($titre) < 2 ) {
    //         $error['titre'] = 'Titre trop court (min 3 caractères).';
    //     } elseif(strlen($titre) > 40) {
    //         $error['titre'] = 'Titre trop long (max 40 caractères).';
    //     }
    // } else {
    //     $error['titre'] = 'C\'est quoi le petit nom de ton article ?';
    // }

    /*
     * TAILLE ARTICLE
     */

    // FONCTION
    $error = validation($error,$article,'article',2,1000);

    // IF/ELSE
    // if(!empty($article)){
    //     if(strlen($article) <= 2 ) {
    //         $error['article'] = 'Fais pas ton radin !';
    //     } else if(strlen($article) >= 1000) {
    //         $error['article'] = 'Moins de 1000 caractères stp';
    //     }
    // } else {
    //     $error['article'] = 'Et ton article ?';
    // }

    /*
     * CHOIX STATUT
     */

    // IF/ELSE
    if(empty($statut)){
        $error['statut'] = 'Public ou privé ?';
    }

    // si aucune erreur
    if(count($error) == 0) {
        $success = true;

        // Déclarer la requête
        $sql = "INSERT INTO articles (title, content, auteur, created_at, statut) VALUES (:titre,:article,:name,NOW(),:statut)";

        // Préparer la requête
        $query = $pdo->prepare($sql);

        $query->bindValue(':titre',$titre,PDO::PARAM_STR);
        $query->bindValue(':article',$article,PDO::PARAM_STR);
        $query->bindValue(':name',$name,PDO::PARAM_STR);
        $query->bindValue(':statut',$statut,PDO::PARAM_STR);
        
        // Exécuter la requête
        $query->execute();

        // Redirection vers la page dashboard
        header('Location: dashboard.php');
    
    } // fin condition pour ajouter un article

}

?>

<?php include('include/headerback.php'); ?>

            <span class="menu"><a href="index.php" class="menu">blog</a></span>
            <span class="menu"><a href="dashboard.php" class="menu">articles</a></span>
            <!-- <span class="menu"><a href="newpost.php" class="menu">nouvel article</a></span> -->
        </div>
    </header>

    <div class="main-content">
        
        <form action="newpost.php" class="form" method="post" novalidate>

            <div class="nom"> <!-- NOM -->
                <label for="name">Nom de l'auteur :</label>
                <input type="text" name="name" value="<?php if(!empty($_POST['name'])) { echo $_POST['name']; } ?>">
                <!-- Message d'erreur -->            
                <div class="error"><?php if(!empty($error['name'])) { echo $error['name']; } ?></div>
            </div>

            <div class="titre"> <!-- TITRE -->
                <label for="titre">Titre de l'article :</label>
                <input type="text" name="titre" value="<?php if(!empty($_POST['titre'])) { echo $_POST['titre']; } ?>">            
                <!-- Message d'erreur -->
                <div class="error"><?php if(!empty($error['titre'])) { echo $error['titre']; } ?></div>
            </div>

            <div class="article"> <!-- CHAMP ARTICLE -->
                <textarea name="article" placeholder="écrire son article ici..."><?php if(!empty($_POST['article'])) { echo $_POST['article']; } ?></textarea>
                <!-- Message d'erreur -->
                <div class="error"><?php if(!empty($error['article'])) { echo $error['article']; } ?></div>
            </div>

            <label for="statut">Actif/inactif :</label>
            <?php $articles = array(
                'actif' => 'Public',
                'inactif' => 'Privé'
            ); ?>
            <select name="statut">
            <option value="<?php if(!empty($_POST['statut'])) { echo $_POST['statut']; } ?>"></option>
                <?php foreach ($articles as $key => $article) { ?>
                    <option value="<?php echo $key; ?>" <?php if(!empty($_POST['statut'])) { if($_POST['statut'] == $article) { echo 'selected="selected"';}} ?>>
                    <?php echo $article; ?>
                    </option>
                <?php } ?>
            </select>
            <!-- Message d'erreur -->            
            <div class="error"><?php if(!empty($error['statut'])) { echo $error['statut']; } ?></div>

            <input type="submit" class="submit" name="submit" value="Ajouter">
        </form>

    </div>

<?php include('include/footerback.php'); ?>