<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Évaluation Enseignant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }
    </style>
</head>

<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow p-4">

        <h3 class="text-center mb-3">Évaluation de l’enseignant</h3>

        <form>

            <!-- PROGRESSION -->
            <div class="mb-3 text-center">
                <span id="stepText">Étape 1 / 3</span>
            </div>

            <!-- ETAPE 1 -->
            <div class="step active">

                <h5>📘 Pédagogie</h5>

                <div class="mb-3">
                    <label>Ponctualité : <span id="p1">5</span>/10</label>
                    <input type="range" min="0" max="10" value="5" class="form-range"
                        oninput="updateValue('p1', this.value)">
                </div>

                <div class="mb-3">
                    <label>Clarté du cours : <span id="p2">5</span>/10</label>
                    <input type="range" min="0" max="10" value="5" class="form-range"
                        oninput="updateValue('p2', this.value)">
                </div>

                <div class="mb-3">
                    <label>Maîtrise du contenu : <span id="p3">5</span>/10</label>
                    <input type="range" min="0" max="10" value="5" class="form-range"
                        oninput="updateValue('p3', this.value)">
                </div>

            </div>

            <!-- ETAPE 2 -->
            <div class="step">

                <h5>📗 Organisation</h5>

                <div class="mb-3">
                    <label>Gestion du temps : <span id="o1">5</span>/10</label>
                    <input type="range" min="0" max="10" value="5" class="form-range"
                        oninput="updateValue('o1', this.value)">
                </div>

                <div class="mb-3">
                    <label>Organisation du cours : <span id="o2">5</span>/10</label>
                    <input type="range" min="0" max="10" value="5" class="form-range"
                        oninput="updateValue('o2', this.value)">
                </div>

                <div class="mb-3">
                    <label>Supports pédagogiques : <span id="o3">5</span>/10</label>
                    <input type="range" min="0" max="10" value="5" class="form-range"
                        oninput="updateValue('o3', this.value)">
                </div>

            </div>

            <!-- ETAPE 3 -->
            <div class="step">

                <h5>📙 Impact et perception</h5>

                <div class="mb-3">
                    <label>Amélioration des connaissances : <span id="i1">5</span>/10</label>
                    <input type="range" min="0" max="10" value="5" class="form-range"
                        oninput="updateValue('i1', this.value)">
                </div>

                <div class="mb-3">
                    <label>Dynamisme : <span id="i2">5</span>/10</label>
                    <input type="range" min="0" max="10" value="5" class="form-range"
                        oninput="updateValue('i2', this.value)">
                </div>

                <div class="mb-3">
                    <label>Commentaires</label>
                    <textarea class="form-control"></textarea>
                </div>

            </div>

            <!-- BOUTONS -->
            <div class="d-flex justify-content-between mt-4">

                <button type="button" class="btn btn-secondary" onclick="prevStep()">
                    Précédent
                </button>

                <button type="button" class="btn btn-primary" onclick="nextStep()">
                    Suivant
                </button>

            </div>

        </form>

    </div>

</div>

<script>
let currentStep = 0;
const steps = document.querySelectorAll(".step");
const stepText = document.getElementById("stepText");

function showStep(index) {
    steps.forEach((step, i) => {
        step.classList.remove("active");
        if (i === index) step.classList.add("active");
    });

    stepText.innerText = `Étape ${index + 1} / ${steps.length}`;
}

function nextStep() {
    if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
    }
}

function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
}

function updateValue(id, value) {
    document.getElementById(id).innerText = value;
}
</script>

</body>
</html>