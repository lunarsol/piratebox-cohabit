<?php
// Gestion des messages en cas d'opérations réussies ou d'erreurs
if (!empty($_GET['type'])) {
    if ($_GET['type'] === 'success') {
        $message = "Fichier enregistré avec succès";
    } elseif ($_GET['type'] === 'error' && !empty($_GET['code'])) {
        switch ($_GET['code']) {
            case 1:
                $message = "Accès non autorisé";
                break;
            case 2:
                $message = "Saisir le champs nom et sélectionné un fichier";
                break;
            case 3:
                $message = "Erreur lors du chargement du fichier";
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="LunarSol | Raphael VERDOIT">
    <meta name="description"
          content="Système de stockage de fichiers pour égaler la piratebox pour Fablab Coh@bit Gradignant">
    <meta name="keywords" content="piratebox, ftp, scp, partage, hacking, pirate, opensource">
    <title>PirateBox</title>
</head>
<style>
    body,
    ul {
        padding: 0;
        margin: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        background-color: #f7f7f7;
        text-align: center;
        color: #333;
    }

    h1 {
        color: #3498db;
        margin-bottom: 10px;
    }

    h6 {
        color: #666;
    }

    form {
        margin: 20px;
    }

    form input {
        margin: 5px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    form input[type=submit] {
        background-color: #3498db;
        color: #fff;
        cursor: pointer;
    }

    form input[type=submit]:hover {
        background-color: #07c;
    }

    .search-bar {
        margin: 10px 0;
        position: relative;
    }

    .search-bar input {
        padding: 8px;
        border: 1px solid #ccc;

        border-radius: 4px;
        width: 65%; /* Ajustement de la largeur */
        box-sizing: border-box;
    }

    .search-bar button {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #3498db;
        color: #fff;
        cursor: pointer;
        width: 28%;
        box-sizing: border-box;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin: 5px 0;
    }

    a {
        text-decoration: none;
        color: #3498db; /* Ajustement de la couleur des liens */
    }

    a:hover {
        text-decoration: underline;
    }

    .home-redir{
        text-underline: none;
        text-decoration: none;
    }
</style>

<body>
<a href="./index.php" class="home-redir">
    <h1>Fablab Coh@bit's PirateBox</h1>
    <h6>Les hackers de qualité t'a vue</h6>
</a>

<div class="search-bar">
    <label for="searchInput">Rechercher par nom de fichier:</label>
    <input type="text" id="searchInput">
</div>

<!-- Formulaire d'upload -->
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <label for="nom">Nom du fichier:</label>
    <input required type="text" name="nom" id="nom" placeholder="Nom du fichier">

    <label for="fichier">Fichier:</label>
    <input type="file" name="fichier" id="fichier" placeholder="Fichier">

    <label for="categorie">Catégorie:</label>
    <select name="categorie" id="categorie">
        <option value="elec">Electronique</option>
        <option value="hack">Hacking</option>
        <option value="prog">Programmation</option>
        <option value="impr">Impression 3D</option>
        <option value="autre">Autre</option>
    </select>

    <input type="submit" name="envoyer" value="Envoyer le fichier">
</form>

<?php
// Chemin de base du répertoire de stockage
$baseDirectory = '/mnt/stockage/';

$directory = null;

if (isset($_GET['folder'])) {
    // Si le paramètre 'folder' est défini dans l'URL, ouvrir le dossier correspondant
    $currentFolder = $baseDirectory . $_GET['folder'];
} else {
    // Sinon, ouvrir le dossier principal
    $currentFolder = $baseDirectory;
}

// Continue with common parts
$directory = opendir($currentFolder);

// Tableau pour stocker les fichiers par extension
$fileByExtension = array();

while (($file = readdir($directory))) {
    if ($file !== '.' && $file !== '..') {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        // Ajouter le fichier au tableau associatif par extension
        $fileByExtension[$extension][] = $file;
    }
}

closedir($directory);

// Trier le tableau par clé (l'extension)
ksort($fileByExtension);

// Afficher les fichiers par extension
echo '<div class="files-container">';
echo '<ul id="fileList">';

foreach ($fileByExtension as $extension => $files) {
    echo '<li><strong>' . strtoupper($extension) . '</strong>';
    echo '<ul>';
    foreach ($files as $file) {
        $filePath = $currentFolder . DIRECTORY_SEPARATOR . $file;
        $isDirectory = is_dir($filePath);

        echo '<li>';

        // Si le lien pointe vers un dossier, afficher un lien pour explorer le dossier
        if ($isDirectory) {
            $newFolderPath = $currentFolder . DIRECTORY_SEPARATOR . $file;
            $relativePath = ltrim(substr($newFolderPath, strlen($baseDirectory)), DIRECTORY_SEPARATOR);
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?folder=' . urlencode($relativePath) . '">' . $file . '</a>';
        } else {
            // Sinon, afficher un lien vers le fichier avec un bouton de téléchargement
            echo '<div>';
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?folder=' . urlencode($currentFolder) . '&file=' . urlencode($file) . '">' . $file . '</a>';
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?folder=' . urlencode($currentFolder) . '&file=' . urlencode($file) . '&action=download"><button>Télécharger</button></a>';
            echo '</div>';
        }

        echo '</li>';
    }
    echo '</ul>';
    echo '</li>';
}

echo '</ul>';
echo '</div>';

// Afficher le contenu du fichier si un fichier est sélectionné
if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']);
    $folder = $_GET['folder'] ?? '';

    // Construire le chemin complet du fichier en utilisant le dossier et le nom du fichier
    $filePath = $baseDirectory . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $file;

    if (is_file($filePath)) {
        // Vérifier que le fichier est lisible (pour des raisons de sécurité)
        if (is_readable($filePath)) {
            // Lire le contenu du fichier
            $fileContent = file_get_contents($filePath);

            // Afficher le contenu du fichier dans une balise pre (préformaté) pour maintenir le format
            echo '<pre>' . htmlspecialchars($fileContent) . '</pre>';
        } else {
            echo 'Le fichier ne peut pas être lu pour des raisons de sécurité.';
        }
    } else {
        echo 'Le fichier spécifié n\'existe pas.';
    }
} else {
    echo 'Le fichier n\'a pas été spécifié.';
}
?>

<!-- Script pour la recherche dynamique -->
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const fileList = document.getElementById('fileList');
        const files = fileList.getElementsByTagName('li');

        for (let i = 0; i < files.length; i++) {
            const fileName = files[i].innerText.toLowerCase();
            if (fileName.includes(searchValue)) {
                files[i].style.display = 'block';
            } else {
                files[i].style.display = 'none';
            }
        }
    });
</script>
</body>
</html>
