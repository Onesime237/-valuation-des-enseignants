<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Form — Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f1f5f9; }
        .topbar { background: #1e293b; border-bottom: 1px solid #334155; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .topbar h1 { font-size: 1.1rem; font-weight: 700; margin: 0; color: #f1f5f9; }
        .badge-role { background: #6366f1; color: #fff; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; }
        .main { padding: 2rem; }
        .form-card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 2rem; max-width: 700px; }
        .form-label { color: #cbd5e1; font-size: 0.875rem; font-weight: 500; }
        .question-card { background: #0f172a; border: 1px solid #334155; border-radius: 8px; padding: 1.25rem; margin-bottom: 1.5rem; }
        .question-text { font-size: 1rem; font-weight: 600; color: #f1f5f9; margin-bottom: 1rem; }
        .question-category { font-size: 0.75rem; color: #6366f1; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
        .form-control, .form-select { background: #0f172a; border: 1px solid #334155; color: #f1f5f9; border-radius: 8px; }
        .form-control:focus, .form-select:focus { background: #0f172a; border-color: #6366f1; color: #f1f5f9; box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
        .rating-options { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .rating-option { flex: 1; min-width: 50px; }
        .rating-option input[type="radio"] { display: none; }
        .rating-option label { display: block; background: #1e293b; border: 1px solid #334155; color: #94a3b8; padding: 0.5rem; text-align: center; border-radius: 6px; cursor: pointer; transition: all 0.2s; }
        .rating-option input[type="radio"]:checked + label { background: #6366f1; color: #fff; border-color: #6366f1; }
        .rating-option label:hover { border-color: #6366f1; }
        .btn-logout { background: transparent; border: 1px solid #ef4444; color: #ef4444; border-radius: 8px; padding: 0.4rem 1rem; font-size: 0.875rem; text-decoration: none; }
        .btn-logout:hover { background: #ef4444; color: #fff; }
        .nav-link { color: #94a3b8; font-size: 0.875rem; text-decoration: none; }
        .nav-link:hover { color: #f1f5f9; }
        .nav-link.active { color: #6366f1; font-weight: 600; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="d-flex align-items-center gap-3">
        <h1>Teacher Evaluation</h1>
        <span class="badge-role">Student</span>
    </div>
    <div class="d-flex align-items-center gap-4">
        <a href="/student/dashboard" class="nav-link">Dashboard</a>
        <a href="/student/evaluate" class="nav-link active">Evaluate</a>
        <a href="/student/my-evaluations" class="nav-link">My Evaluations</a>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>
</div>

<div class="main">

    <div class="mb-3">
        <a href="/student/evaluate" style="color:#94a3b8;text-decoration:none;font-size:0.9rem">← Back to Evaluation List</a>
    </div>

    <div class="form-card">
        <h2 style="font-size:1.2rem;font-weight:700;margin-bottom:0.5rem">Evaluation Form</h2>
        <p style="color:#94a3b8;font-size:0.875rem;margin-bottom:1.5rem">
            Teacher: <strong style="color:#f1f5f9"><?= esc($teacher['name']) ?></strong> | 
            Course: <strong style="color:#f1f5f9"><?= esc($course['name']) ?></strong>
        </p>

        <form action="/student/evaluate/<?= $teacher['id'] ?>/<?= $course['id'] ?>" method="POST">
            <?= csrf_field() ?>

            <?php foreach ($questions as $index => $question): ?>
            <div class="question-card">
                <?php if ($question['category_name']): ?>
                    <div class="question-category"><?= esc($question['category_name']) ?></div>
                <?php endif; ?>
                <div class="question-text"><?= ($index + 1) ?>. <?= esc($question['text']) ?></div>

                <?php if ($question['type'] === 'scored'): ?>
                    <div class="rating-options">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div class="rating-option">
                            <input type="radio" name="question_<?= $question['id'] ?>" id="q<?= $question['id'] ?>_<?= $i ?>" value="<?= $i ?>" required>
                            <label for="q<?= $question['id'] ?>_<?= $i ?>"><?= $i ?></label>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:0.5rem;font-size:0.7rem;color:#64748b">
                        <span>Poor</span>
                        <span>Excellent</span>
                    </div>
                <?php else: ?>
                    <textarea name="question_<?= $question['id'] ?>" class="form-control" rows="3" placeholder="Your answer..." required></textarea>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>

            <button type="submit" class="btn w-100" style="background:#6366f1;color:#fff;border-radius:8px;font-weight:600;padding:0.75rem">Submit Evaluation</button>
        </form>
    </div>

</div>
</body>
</html>
