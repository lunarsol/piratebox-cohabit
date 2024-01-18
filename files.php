<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des fichiers</title>
    <link rel="stylesheet" href="files.css">
</head>

<div class="container">
    <h2>Liste des fichiers</h2>
    <input type="text" id="searchInput" class="search-bar" oninput="filterFiles()" placeholder="Rechercher par nom...">
    <table id="filesTable">
        <thead>
        <tr>
            <th>Nom du fichier</th>
            <th>Extension</th>
            <th>Taille</th>
            <th>Date de création</th>
            <th>Téléchargement</th>
            <th>Aperçu</th>
        </tr>
        </thead>
        <tbody>
        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $folder = 'files';
        $files = scandir($folder);

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $filePath = $folder . '/' . $file;
                $fileInfo = pathinfo($filePath);
                $fileSize = formatSize(filesize($filePath));
                $fileCreationDate = date("Y-m-d H:i:s", filectime($filePath));

                echo "<tr>
					                <td>{$fileInfo['filename']}</td>
					                <td>{$fileInfo['extension']}</td>
					                <td>{$fileSize}</td>
					                <td>{$fileCreationDate}</td>
					                <td><a href='{$filePath}' download class='download-link'>Télécharger</a></td>
					                <td><button class='preview-button' onclick='openPreview(\"{$filePath}\")'>Aperçu</button></td>
					              </tr>";
            }
        }

        function formatSize($bytes)
        {
            $size = ['B', 'KB', 'MB', 'GB', 'TB'];
            $factor = floor((strlen($bytes) - 1) / 3);
            return sprintf("%.2f", $bytes / pow(1024, $factor)) . $size[$factor];
        }
        ?>
        </tbody>
    </table>
    <button class="back-button" onclick="window.location.href='index.php'">Retour</button>
</div>
<div id="preview-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePreview()">&times;</span>
        <iframe id="preview-iframe"></iframe>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('preview-modal').style.display = "none";
    });

    function openPreview(filePath) {
        document.getElementById('preview-iframe').src = "preview.php?file=" + encodeURIComponent(filePath);
        document.getElementById('preview-modal').style.display = "block";
    }

    function closePreview() {
        document.getElementById('preview-modal').style.display = "none";
        document.getElementById('preview-iframe').src = "";
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initial loading of the table
        filterFiles();
    });

    function filterFiles() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("filesTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those that don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0]; // Assuming the file name is in the first column

            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
</html>
