<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes enseignants</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row">

        <!-- À ÉVALUER -->
        <div class="col-md-7">

            <h4 class="mb-3">📚 Enseignants à évaluer</h4>

            <div class="row g-3">

                <?php foreach($teachers_to_evaluate as $teacher): ?>

                    <div class="col-md-6">
                        <div class="card shadow p-3">

                            <h5><?= $teacher['name'] ?></h5>
                            <p><?= $teacher['course'] ?></p>

                            <a href="/student/evaluate/<?= $teacher['id'] ?>" class="btn btn-primary btn-sm">
                                Évaluer
                            </a>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        </div>

        <!-- DÉJÀ ÉVALUÉS -->
        <div class="col-md-5">

            <h4 class="mb-3 text-success">✔ Déjà évalués</h4>

            <?php foreach($teachers_evaluated as $teacher): ?>

                <div class="card mb-3 shadow-sm p-3 border-success">

                    <h6><?= $teacher['name'] ?></h6>
                    <small><?= $teacher['course'] ?></small>

                    <button class="btn btn-success btn-sm mt-2" disabled>
                        Déjà évalué
                    </button>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

</body>
</html>