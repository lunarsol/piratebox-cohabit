<?php
if (isset($_POST['envoyer'])) {
    // Vérifie que le formulaire est bien à l'origine
    if (!empty($_POST['nom']) && !empty($_FILES['fichier'])) {
        // Contrôle de la présence du fichier et du nom de fichier
        if ($_FILES['fichier']['error'] === 0) {
            // Contrôle de l'absence d'erreur du chargement du fichier depuis le formulaire

            $uploadDirectory = '/mnt/stockage/'; // Dossier d'upload
            $fileInfo = new SplFileInfo($_FILES['fichier']['name']); // Préparation du fichier pour upload
            $extension = $fileInfo->getExtension();

            // Récupérer la catégorie sélectionnée
            $categorie = $_POST['categorie'];

            // Déterminer le dossier en fonction de la catégorie sélectionnée
            $dossierCategorie = '';
            switch ($categorie) {
                case 'elec':
                    $dossierCategorie = 'electronique';
                    break;
                case 'hack':
                    $dossierCategorie = 'hacking';
                    break;
                case 'prog':
                    $dossierCategorie = 'programmation';
                    break;
                case 'impr':
                    $dossierCategorie = 'impression3D';
                    break;
                // Ajoutez d'autres cas selon vos catégories
                default:
                    $dossierCategorie = 'autre';
                    break;
            }

// Construire le chemin complet du nouveau fichier avec le dossier de catégorie
            $nouveauFichier = $dossierCategorie . DIRECTORY_SEPARATOR . $_POST['nom'] . '.' . $extension;

// Créer le dossier de catégorie s'il n'existe pas
            if (!is_dir($uploadDirectory . $dossierCategorie)) {
                mkdir($uploadDirectory . $dossierCategorie);
            }

// Déplacement du fichier vers le dossier d'upload
            if (move_uploaded_file($_FILES['fichier']['tmp_name'], $uploadDirectory . $nouveauFichier)) {
                echo 'Le fichier a été correctement déplacé.<br>';
            } else {
                echo 'Erreur lors du déplacement du fichier.<br>';
            }

            header('location: index.php?type=success');
        } else {
            header('location: index.php?type=error&code=3');
        }
    } elseif (!empty($_FILES['fichier'])) {
        // Si le nom n'est pas renseigné, utilise le nom d'origine du fichier
        $uploadDirectory = '/mnt/stockage/';//__DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR; // Dossier d'upload
        $fileInfo = new SplFileInfo($_FILES['fichier']['name']); // Préparation du fichier pour upload
        $extension = $fileInfo->getExtension();
        $nouveauFichier = pathinfo($_FILES['fichier']['name'], PATHINFO_FILENAME) . '.' . $extension;
    } else {
        header('location: index.php?type=error&code=2');
    }
} else {
    header('location: index.php?type=error&code=1');
}
?>;