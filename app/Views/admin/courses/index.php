<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses — Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f1f5f9; }
        .topbar { background: #1e293b; border-bottom: 1px solid #334155; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .topbar h1 { font-size: 1.1rem; font-weight: 700; margin: 0; color: #f1f5f9; }
        .badge-role { background: #6366f1; color: #fff; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; }
        .main { padding: 2rem; }
        .card-dark { background: #1e293b; border: 1px solid #334155; border-radius: 12px; }
        .table-dark-custom { color: #f1f5f9; }
        .table-dark-custom thead th { background: #0f172a; border-color: #334155; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; }
        .table-dark-custom td { border-color: #334155; vertical-align: middle; }
        .btn-logout { background: transparent; border: 1px solid #ef4444; color: #ef4444; border-radius: 8px; padding: 0.4rem 1rem; font-size: 0.875rem; text-decoration: none; transition: all 0.2s; }
        .btn-logout:hover { background: #ef4444; color: #fff; }
        .nav-links a { color: #94a3b8; text-decoration: none; margin-right: 1.5rem; font-size: 0.9rem; }
        .nav-links a:hover { color: #f1f5f9; }
        .badge-active { background: #10b981; color: #fff; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.75rem; }
        .badge-inactive { background: #ef4444; color: #fff; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.75rem; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="d-flex align-items-center gap-3">
        <h1>Teacher Evaluation</h1>
        <span class="badge-role">Admin</span>
        <div class="nav-links ms-3">
            <a href="/admin/dashboard">Dashboard</a>
            <a href="/admin/teachers">Teachers</a>
            <a href="/admin/students">Students</a>
            <a href="/admin/courses" style="color:#f1f5f9">Courses</a>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span style="color:#94a3b8;font-size:0.875rem"><?= esc(session()->get('user_email')) ?></span>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>
</div>

<div class="main">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="font-size:1.3rem;font-weight:700">All Courses</h2>
        <a href="/admin/courses/create" class="btn btn-sm" style="background:#6366f1;color:#fff;border-radius:8px">+ New Course</a>
    </div>

    <div class="card-dark">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($courses)): ?>
                    <tr><td colspan="5" class="text-center" style="color:#94a3b8;padding:2rem">No courses yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?= esc($course['id']) ?></td>
                        <td><?= esc($course['name']) ?></td>
                        <td style="color:#94a3b8"><?= esc($course['description'] ?? '—') ?></td>
                        <td>
                            <?php if ($course['is_active']): ?>
                                <span class="badge-active">Active</span>
                            <?php else: ?>
                                <span class="badge-inactive">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/admin/courses/edit/<?= $course['id'] ?>" class="btn btn-sm btn-outline-light btn-sm me-1" style="font-size:0.75rem">Edit</a>
                            <a href="/admin/courses/toggle/<?= $course['id'] ?>" class="btn btn-sm me-1" style="font-size:0.75rem;background:#f59e0b;color:#fff"><?= $course['is_active'] ? 'Deactivate' : 'Activate' ?></a>
                            <a href="/admin/courses/delete/<?= $course['id'] ?>" class="btn btn-sm" style="font-size:0.75rem;background:#ef4444;color:#fff" onclick="return confirm('Delete this course?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>