<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation PDFs — Admin</title>
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
        .btn-logout { background: transparent; border: 1px solid #ef4444; color: #ef4444; border-radius: 8px; padding: 0.4rem 1rem; font-size: 0.875rem; text-decoration: none; }
        .btn-logout:hover { background: #ef4444; color: #fff; }
        .nav-link { color: #94a3b8; font-size: 0.875rem; text-decoration: none; }
        .nav-link:hover { color: #f1f5f9; }
        .nav-link.active { color: #6366f1; font-weight: 600; }
        .btn-download { background: #10b981; color: #fff; border-radius: 8px; padding: 0.4rem 1rem; font-size: 0.75rem; text-decoration: none; }
        .btn-download:hover { background: #059669; color: #fff; }
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

    <h2 style="font-size:1.3rem;font-weight:700;margin-bottom:1.5rem">Evaluation PDFs</h2>

    <div class="card-dark">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Teacher</th>
                    <th>Course</th>
                    <th>Student</th>
                    <th>Generated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pdfs)): ?>
                    <tr><td colspan="6" class="text-center" style="color:#94a3b8;padding:2rem">No PDFs generated yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($pdfs as $pdf): ?>
                    <tr>
                        <td><?= esc($pdf['id']) ?></td>
                        <td><?= esc($pdf['teacher_name']) ?></td>
                        <td><?= esc($pdf['course_name']) ?></td>
                        <td><?= esc($pdf['student_name']) ?></td>
                        <td style="color:#94a3b8;font-size:0.875rem"><?= date('M d, Y H:i', strtotime($pdf['generated_at'])) ?></td>
                        <td>
                            <a href="/admin/evaluation-pdfs/download/<?= $pdf['id'] ?>" class="btn-download">📥 Download</a>
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
