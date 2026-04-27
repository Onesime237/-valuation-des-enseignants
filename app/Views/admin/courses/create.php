<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course — Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f1f5f9; }
        .topbar { background: #1e293b; border-bottom: 1px solid #334155; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .topbar h1 { font-size: 1.1rem; font-weight: 700; margin: 0; color: #f1f5f9; }
        .badge-role { background: #6366f1; color: #fff; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; }
        .main { padding: 2rem; }
        .form-card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 2rem; max-width: 560px; }
        .form-label { color: #cbd5e1; font-size: 0.875rem; font-weight: 500; }
        .form-control, .form-select { background: #0f172a; border: 1px solid #334155; color: #f1f5f9; border-radius: 8px; }
        .form-control:focus, .form-select:focus { background: #0f172a; border-color: #6366f1; color: #f1f5f9; box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
        .form-control::placeholder { color: #475569; }
        .btn-logout { background: transparent; border: 1px solid #ef4444; color: #ef4444; border-radius: 8px; padding: 0.4rem 1rem; font-size: 0.875rem; text-decoration: none; }
        .btn-logout:hover { background: #ef4444; color: #fff; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="d-flex align-items-center gap-3">
        <h1>Teacher Evaluation</h1>
        <span class="badge-role">Admin</span>
    </div>
    <a href="/logout" class="btn-logout">Logout</a>
</div>

<div class="main">
    <div class="mb-3">
        <a href="/admin/courses" style="color:#94a3b8;text-decoration:none;font-size:0.9rem">← Back to Courses</a>
    </div>

    <div class="form-card">
        <h2 style="font-size:1.2rem;font-weight:700;margin-bottom:1.5rem">New Course</h2>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <div><?= esc($err) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="/admin/courses/create" method="POST">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <input type="text" name="name" class="form-control" value="<?= esc(old('name')) ?>" placeholder="e.g. Mathematics" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Description <span style="color:#475569">(optional)</span></label>
                <textarea name="description" class="form-control" rows="3" placeholder="Short description..."><?= esc(old('description')) ?></textarea>
            </div>

            <button type="submit" class="btn w-100" style="background:#6366f1;color:#fff;border-radius:8px;font-weight:600">Create Course</button>
        </form>
    </div>
</div>
</body>
</html>