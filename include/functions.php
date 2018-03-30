<?php include('include/pdo.php'); ?>

<?php

function debug($array) {
    echo '<pre>';
    print_r ($array);
    echo '</pre>';
}

// Validation des champs du formulaire
function validation($error,$value,$key,$min,$max) {
    if(!empty($value)) {
        if(strlen($value) < $min ) {
            $error[$key] = 'Trop court (entre '.$min.' et '.$max.' caractères).';
        } elseif(strlen($value) > $max) {
            $error[$key] = 'Trop long (entre '.$min.' et '.$max.' caractères).';
        }
    } else {
        $error[$key] = 'Veuillez renseigner ce champ.';
    }

    return $error;
}

// Mot de passe oublié
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

// Voir si on est connecté ou pas (fonction booléenne, @return bool => true or false)
function isLogged() {
    if(!empty($_SESSION)) {
        if(!empty($_SESSION['id']) && is_numeric($_SESSION['id'])) {
            if(!empty($_SESSION['pseudo']) && (!empty($_SESSION['role'])) && (!empty($_SESSION['ip']))) {
                $ip = $_SERVER['REMOTE_ADDR'];
                if($ip == $_SESSION['ip']) {
                    return true;
                }
            }
        }
    }

    return false;
}

?>