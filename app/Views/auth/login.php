<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">

    <div class="card shadow p-4" style="width:350px; border-radius:15px;">

        <h3 class="text-center mb-4">Connexion</h3>

            <form action="/student/teachers" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label>Matricule / Email</label>
                <input type="text" class="form-control" placeholder="Entrez votre identifiant">
            </div>

            <div class="mb-3">
                <label>Mot de passe</label>
                <input type="password" class="form-control" placeholder="Mot de passe">
            </div>

            <button class="btn btn-primary w-100">Se connecter</button>

        </form>

    </div>

</div>

</body>
</html>