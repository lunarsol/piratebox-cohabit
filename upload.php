<?php
$uploadDir = '/var/www/piratebox.com/files/'; // Le répertoire où les fichiers seront enregistrés

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if(isset($_FILES['file'])) {
    $errors = [];
    $success = [];

    foreach($_FILES['file']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['file']['name'][$key];
        $file_size = $_FILES['file']['size'][$key];
        $file_tmp = $_FILES['file']['tmp_name'][$key];
        $file_type = $_FILES['file']['type'][$key];

        // Vérifiez si le fichier existe déjà
        $baseFileName = pathinfo($file_name, PATHINFO_FILENAME);
        $fileExtension = pathinfo($file_name, PATHINFO_EXTENSION);

        $counter = 1;
        while (file_exists($uploadDir . $file_name)) {
            $file_name = $baseFileName . '_' . $counter . '.' . $fileExtension;
            $counter++;
        }

        $file_path = $uploadDir . $file_name;

        // Vérifiez si le fichier est un fichier audio
        $allowedAudioTypes = ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp3']; // Ajoutez d'autres types si nécessaire

        if (in_array($file_type, $allowedAudioTypes)) {
            if (move_uploaded_file($file_tmp, $file_path)) {
                $success[] = $file_name;
            } else {
                $errors[] = $file_name;
            }
        } else {
            $errors[] = $file_name . ' n\'est pas un fichier audio valide.';
        }
    }

    if (!empty($success)) {
        echo 'Fichiers téléchargés avec succès : ' . implode(', ', $success);
    }

    if (!empty($errors)) {
        echo 'Erreur lors du téléchargement des fichiers : ' . implode(', ', $errors);
    }
} else {
    echo 'Aucun fichier reçu.';
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

?>
