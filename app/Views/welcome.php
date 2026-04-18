<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Plateforme ENSPM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .card-role {
            transition: 0.3s;
            cursor: pointer;
            border: none;
            border-radius: 15px;
        }

        .card-role:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .icon {
            font-size: 50px;
        }
    </style>
</head>

<body>

<div class="container text-center mt-5">

    <h1 class="fw-bold">Plateforme d’Évaluation des Enseignants</h1>
    <p class="text-muted mb-5">Choisissez votre espace</p>

    <div class="row justify-content-center g-4">

        <!-- ETUDIANT -->
        <div class="col-md-3">
            <a href="/login" class="text-decoration-none text-dark">
                <div class="card card-role p-4 shadow-sm">
                    <div class="icon">🎓</div>
                    <h4 class="mt-3">Étudiant</h4>
                    <p class="text-muted">Évaluer vos enseignants</p>
                </div>
            </a>
        </div>

        <!-- ENSEIGNANT -->
        <div class="col-md-3">
            <a href="/teacher/login" class="text-decoration-none text-dark">
                <div class="card card-role p-4 shadow-sm">
                    <div class="icon">👨‍🏫</div>
                    <h4 class="mt-3">Enseignant</h4>
                    <p class="text-muted">Consulter vos évaluations</p>
                </div>
            </a>
        </div>

        <!-- ADMIN -->
        <div class="col-md-3">
            <a href="/admin/login" class="text-decoration-none text-dark">
                <div class="card card-role p-4 shadow-sm">
                    <div class="icon">🛠️</div>
                    <h4 class="mt-3">Administrateur</h4>
                    <p class="text-muted">Gérer la plateforme</p>
                </div>
            </a>
        </div>

    </div>

</div>

</body>
</html>