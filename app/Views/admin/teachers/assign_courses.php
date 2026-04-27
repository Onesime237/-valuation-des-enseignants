<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Courses — Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f1f5f9; }
        .topbar { background: #1e293b; border-bottom: 1px solid #334155; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .topbar h1 { font-size: 1.1rem; font-weight: 700; margin: 0; color: #f1f5f9; }
        .badge-role { background: #6366f1; color: #fff; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; }
        .main { padding: 2rem; }
        .form-card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 2rem; max-width: 560px; }
        .course-item { background: #0f172a; border: 1px solid #334155; border-radius: 8px; padding: 0.75rem 1rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem; cursor: pointer; transition: border-color 0.2s; }
        .course-item:hover { border-color: #6366f1; }
        .course-item input[type="checkbox"] { accent-color: #6366f1; width: 16px; height: 16px; }
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
        <a href="/admin/teachers" style="color:#94a3b8;text-decoration:none;font-size:0.9rem">← Back to Teachers</a>
    </div>

    <div class="form-card">
        <h2 style="font-size:1.2rem;font-weight:700;margin-bottom:0.25rem">Assign Courses</h2>
        <p style="color:#94a3b8;font-size:0.875rem;margin-bottom:1.5rem">Teacher: <strong style="color:#f1f5f9"><?= esc($teacher['name']) ?></strong></p>

        <?php if (empty($allCourses)): ?>
            <p style="color:#94a3b8">No active courses available. <a href="/admin/courses/create" style="color:#6366f1">Create one first.</a></p>
        <?php else: ?>
        <form action="/admin/teachers/assign/<?= esc($teacher['id']) ?>" method="POST">
            <?= csrf_field() ?>

            <?php foreach ($allCourses as $course): ?>
                <label class="course-item">
                    <input
                        type="checkbox"
                        name="courses[]"
                        value="<?= esc($course['id']) ?>"
                        <?= in_array($course['id'], $assignedIds) ? 'checked' : '' ?>
                    >
                    <span><?= esc($course['name']) ?></span>
                    <?php if ($course['description']): ?>
                        <span style="color:#475569;font-size:0.8rem;margin-left:auto"><?= esc($course['description']) ?></span>
                    <?php endif; ?>
                </label>
            <?php endforeach; ?>

            <button type="submit" class="btn w-100 mt-3" style="background:#6366f1;color:#fff;border-radius:8px;font-weight:600">Save Assignments</button>
        </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>