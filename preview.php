<?php
$file = isset($_GET['file']) ? $_GET['file'] : null;

if ($file && file_exists($file)) {
    $info = pathinfo($file);
    $extension = strtolower($info['extension']);

    // Déterminer le type de contenu en fonction de l'extension
    $contentTypes = [
        'txt' => 'text/plain',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'mp3' => 'audio/mpeg',
        'mp4' => 'video/mp4',
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'tar' => 'application/x-tar',
        'gz' => 'application/gzip',
        'csv' => 'text/csv',
        'html' => 'text/html',
        'xml' => 'application/xml',
        'json' => 'application/json',
        'js' => 'application/javascript',
        'css' => 'text/css',
        'php' => 'text/php',
        'java' => 'text/x-java-source',
        'c' => 'text/x-c',
        'cpp' => 'text/x-c++',
        'cs' => 'text/x-csharp',
        'py' => 'text/x-python',
        'rb' => 'text/x-ruby',
        'pl' => 'text/x-perl',
        'sh' => 'application/x-sh',
        'bat' => 'application/bat',
        'ini' => 'text/plain',
        'conf' => 'text/plain',
        'md' => 'text/markdown',
        'epub' => 'application/epub+zip',
        // Ajoutez d'autres types de fichiers selon vos besoins
    ];

    // Utilisez le type de contenu par défaut pour les extensions non répertoriées
    $contentType = $contentTypes[$extension] ?? 'application/octet-stream';

    header('Content-Type: ' . $contentType);

    // Lire et afficher le contenu du fichier
    readfile($file);
} else {
    echo 'Fichier non trouvé.';
}
?>
