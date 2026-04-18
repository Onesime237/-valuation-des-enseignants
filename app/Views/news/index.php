<div class="container mt-5">
    <h1 class="mb-4"><?= esc($title) ?></h1>

    <div class="row">
        <?php foreach ($news_list as $news_item): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($news_item['title']) ?></h5>
                        <p class="card-text">
                            <?= esc(substr($news_item['body'], 0, 100)) ?>...
                        </p>
                        <a href="/news/<?= esc($news_item['slug']) ?>" class="btn btn-primary">
                            Lire plus
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<main class="flex-fill">
    <div class="container mt-5">
        <!-- ton contenu -->
    </div>
</main>