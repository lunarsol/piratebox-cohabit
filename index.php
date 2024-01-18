<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="LunarSol | Raphael VERDOIT">
    <meta name="description" content="Système de stockage de fichiers pour égaler la piratebox pour Fablab Coh@bit Gradignant">
    <meta name="keywords" content="piratebox, ftp, scp, partage, hacking, pirate, opensource">
    <link rel="stylesheet" href="style.css">
	<title></title>
</head>
<body>
    <h1>Fablab Coh@bit's PirateBox</h1>
    <h6>Les hacker de qualité t'as vue</h6>
    <br>
    <a href="files.php" class="dir-files">Liste des fichiers</a>

    <div id="drop-area" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
        <p>Drop files here</p><br>
        <p style="color:red" size="6px">les fichiers audio ne sont pas accepter</p>
    </div>
    <div id="upload-message"></div>

    <script>
        function dropHandler(event) {
            event.preventDefault();
            var files = event.dataTransfer.files;
            uploadFiles(files);
        }

        function dragOverHandler(event) {
            event.preventDefault();
        }

        function uploadFiles(files) {
            var formData = new FormData();
            for (var i = 0; i < files.length; i++) {
                formData.append('file[]', files[i]);
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload.php', true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    var uploadMessage = document.getElementById('upload-message');

                    if (xhr.status === 200) {
                        // Affichez le message de réussite dans la div
                        uploadMessage.innerHTML = 'Files uploaded successfully!';
                        uploadMessage.style.backgroundColor = 'lightgreen';
                        uploadMessage.style.borderColor = 'lightgreen';
                        uploadMessage.style.display = 'block';
                    } else {
                        // Affichez le message d'erreur dans la div
                        uploadMessage.innerHTML = 'Error uploading files!';
                        uploadMessage.style.backgroundColor = 'lightcoral';
                        uploadMessage.style.borderColor = 'lightcoral';
                        uploadMessage.style.display = 'block';
                    }

                    // Masquer le message après 5 secondes
                    setTimeout(function() {
                        uploadMessage.style.display = 'none';
                    }, 5000);
                }
            };

            xhr.send(formData);
        }
    </script>
    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    ?>
</body>
</html>