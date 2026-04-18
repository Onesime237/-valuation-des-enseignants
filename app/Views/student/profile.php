<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Étudiant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4 mx-auto" style="max-width:600px; border-radius:15px;">

        <h3 class="text-center mb-4">Complétez vos informations</h3>

        <form>

            <!-- FILIERE -->
            <div class="mb-3">
                <label>Filière</label>
                <select class="form-select">
                    <option>HYMAE</option>
                    <option>Génie Civil</option>
                    <option>INFOTEL</option>
                    <option>AGEPT</option>
                    <option>ESB</option>
                </select>
            </div>

            <!-- NIVEAU -->
            <div class="mb-3">
                <label>Niveau</label>
                <select class="form-select">
                    <option>Licence 1</option>
                    <option>Licence 2</option>
                    <option>Licence 3</option>
                    <option>Master 1</option>
                    <option>Master 2</option>
                </select>
            </div>

            <!-- OPTION -->
            <div class="mb-3">
                <label>Option</label>
                <input type="text" class="form-control" placeholder="Ex: Réseaux, IA, BTP...">
            </div>

            <!-- CLASSE -->
            <div class="mb-3">
                <label>Classe</label>
                <input type="text" class="form-control" placeholder="Ex: GI3 A">
            </div>

            <button class="btn btn-primary w-100">
                Voir mes enseignants
            </button>

        </form>

    </div>

</div>

</body>
</html>