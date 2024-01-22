<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté, le rediriger vers la page d'accueil
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

// Vérifier si le formulaire de connexion a été soumis
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier les identifiants
    if ($username === 'Fab_Admin' && $password === 'Fablab_Coh@bit_OpenSourceKnowledge') {
        // Identifiants valides, définir la session utilisateur
        $_SESSION['user'] = $username;

        // Rediriger vers la page d'accueil
        header('Location: index.php');
        exit();
    } else {
        // Identifiants invalides, afficher un message d'erreur
        $error = 'Identifiants invalides';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            text-align: center;
            color: #333;
            margin-top: 50px;
        }

        h1 {
            color: #3498db;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #07c;
        }

        .error {
            color: #e74c3c;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<h1>Connexion</h1>
<form action="" method="post">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <input type="submit" name="submit" value="Se connecter">
</form>

<?php if (isset($error)) : ?>
    <div class="error"><?= $error; ?></div>
<?php endif; ?>
</body>
</html>
