<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers — Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f1f5f9; }
        .topbar {
            background: #1e293b;
            border-bottom: 1px solid #334155;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar h1 { font-size: 1.1rem; font-weight: 700; margin: 0; color: #f1f5f9; }
        .badge-role {
            background: #6366f1;
            color: #fff;
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-weight: 600;
        }
        .main { padding: 2rem; }
        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
        }
        .table { color: #f1f5f9; }
        .table thead th {
            background: #0f172a;
            border-color: #334155;
            color: #94a3b8;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .table tbody td { border-color: #334155; vertical-align: middle; }
        .table tbody tr:hover { background: #0f172a; }
        .btn-sm { font-size: 0.78rem; padding: 0.3rem 0.7rem; border-radius: 6px; }
        .btn-create {
            background: #6366f1;
            border: none;
            color: #fff;
            border-radius: 8px;
            padding: 0.5rem 1.2rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
        }
        .btn-create:hover { background: #4f46e5; color: #fff; }
        .badge-active { background: #10b981; color: #fff; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.75rem; }
        .badge-inactive { background: #ef4444; color: #fff; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.75rem; }
        .btn-logout {
            background: transparent;
            border: 1px solid #ef4444;
            color: #ef4444;
            border-radius: 8px;
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
            text-decoration: none;
        }
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
        <span class="badge-role">Admin</span>
    </div>
    <div class="d-flex align-items-center gap-4">
        <a href="/admin/dashboard" class="nav-link active">Dashboard</a>
        <a href="/admin/teachers" class="nav-link">Teachers</a>
        <a href="/admin/students" class="nav-link">Students</a>
        <a href="/admin/courses" class="nav-link">Courses</a>
        <a href="/admin/categories" class="nav-link">Categories</a>
        <a href="/admin/questions" class="nav-link">Questions</a>
        <a href="/admin/evaluation-pdfs" class="nav-link">PDFs</a>
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
        <h4 class="mb-0">Teachers</h4>
        <a href="/admin/teachers/create" class="btn-create">+ New Teacher</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($teachers)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No teachers found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($teachers as $teacher): ?>
                            <tr>
                                <td><?= esc($teacher['id']) ?></td>
                                <td><?= esc($teacher['name']) ?></td>
                                <td><?= esc($teacher['email']) ?></td>
                                <td>
                                    <?php if ($teacher['is_active']): ?>
                                        <span class="badge-active">Active</span>
                                    <?php else: ?>
                                        <span class="badge-inactive">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($teacher['created_at']) ?></td>
                                <td class="d-flex gap-2">
                                    <a href="/admin/teachers/edit/<?= $teacher['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a href="/admin/teachers/assign/<?= $teacher['id'] ?>" class="btn btn-sm me-1" style="font-size:0.75rem;background:#6366f1;color:#fff">Assign Courses</a>
                                    <a href="/admin/teachers/toggle/<?= $teacher['id'] ?>" class="btn btn-sm <?= $teacher['is_active'] ? 'btn-outline-warning' : 'btn-outline-success' ?>">
                                        <?= $teacher['is_active'] ? 'Deactivate' : 'Activate' ?>
                                    </a>
                                    <a href="/admin/teachers/delete/<?= $teacher['id'] ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Delete this teacher?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html><a href="/admin/teachers/edit/<?= $teacher['id'] ?>" class="btn btn-sm btn-outline-light">Edit</a>