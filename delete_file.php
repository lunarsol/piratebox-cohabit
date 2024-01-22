<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Vérifier si le paramètre 'file' est défini dans l'URL
if (isset($_GET['file'])) {
    $fileName = urldecode($_GET['file']);
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $fileName;

    // Vérifier si le fichier existe avant de le supprimer
    if (file_exists($filePath)) {
        unlink($filePath); // Supprimer le fichier
        header('Location: index.php?type=success'); // Rediriger avec un message de succès
        exit();
    } else {
        header('Location: index.php?type=error&code=4'); // Rediriger avec un message d'erreur
        exit();
    }
} else {
    header('Location: index.php?type=error&code=5'); // Rediriger avec un message d'erreur si le paramètre 'file' n'est pas défini
    exit();
}
?>
