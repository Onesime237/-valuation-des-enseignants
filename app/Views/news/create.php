<div class="container mt-5">
    <h2 class="mb-4"><?= esc($title) ?></h2>

    <!-- Message d'erreur -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Erreurs de validation -->
    <div class="text-danger mb-3">
        <?= validation_list_errors() ?>
    </div>

    <form action="/news" method="post">
        <?= csrf_field() ?>

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label"><center>Titre</center></label>
            <input 
                type="text" 
                class="form-control" 
                name="title" 
                value="<?= set_value('title') ?>" 
                placeholder="Entrez le titre">
        </div>

        <!-- Body -->
        <div class="mb-3">
            <label for="body" class="form-label">Contenu</label>
            <textarea 
                class="form-control" 
                name="body" 
                rows="5"
                placeholder="Entrez le contenu"><?= set_value('body') ?></textarea>
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn btn-primary">
            Créer un article
        </button>
    </form>
</div>