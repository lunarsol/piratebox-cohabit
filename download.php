<?php
$baseDirectory = '/mnt/stockage/';

if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']);
    $filePath = $baseDirectory . $_GET['folder'] . '/' . $file;

    if (is_file($filePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        exit;
    } else {
        echo 'Le fichier spécifié n\'existe pas.';
    }
} else {
    echo 'Le fichier n\'a pas été spécifié.';
}
?>
