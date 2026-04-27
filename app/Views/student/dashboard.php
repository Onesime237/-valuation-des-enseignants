<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f1f5f9; }
        .topbar { background: #1e293b; border-bottom: 1px solid #334155; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        .topbar h1 { font-size: 1.1rem; font-weight: 700; margin: 0; color: #f1f5f9; }
        .badge-role { background: #6366f1; color: #fff; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; }
        .main { padding: 2rem; }
        .welcome-card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 1.5rem 2rem; margin-bottom: 2rem; }
        .welcome-card h2 { font-size: 1.3rem; font-weight: 700; color: #f1f5f9; }
        .welcome-card p { color: #94a3b8; margin: 0; font-size: 0.9rem; }
        .card-dark { background: #1e293b; border: 1px solid #334155; border-radius: 12px; }
        .table-dark-custom { color: #f1f5f9; }
        .table-dark-custom thead th { background: #0f172a; border-color: #334155; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; }
        .table-dark-custom td { border-color: #334155; vertical-align: middle; }
        .btn-logout { background: transparent; border: 1px solid #ef4444; color: #ef4444; border-radius: 8px; padding: 0.4rem 1rem; font-size: 0.875rem; text-decoration: none; }
        .btn-logout:hover { background: #ef4444; color: #fff; }
        .nav-link { color: #94a3b8; font-size: 0.875rem; text-decoration: none; }
        .nav-link:hover { color: #f1f5f9; }
        .nav-link.active { color: #6366f1; font-weight: 600; }
        .badge-submitted { background: #10b981; color: #fff; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.75rem; }
        .badge-pending { background: #f59e0b; color: #fff; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.75rem; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="d-flex align-items-center gap-3">
        <h1>Teacher Evaluation</h1>
        <span class="badge-role">Student</span>
    </div>
    <div class="d-flex align-items-center gap-4">
        <a href="/student/dashboard" class="nav-link active">Dashboard</a>
        <a href="/student/evaluate" class="nav-link">Evaluate</a>
        <a href="/student/my-evaluations" class="nav-link">My Evaluations</a>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>
</div>

<div class="main">

    <div class="welcome-card">
        <h2>Welcome, <?= esc($user_name) ?> 👋</h2>
        <p>You are logged in as Student. Evaluate your teachers and view your submission history.</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size:1.1rem;font-weight:600">Recent Evaluations</h3>
        <a href="/student/evaluate" class="btn" style="background:#6366f1;color:#fff;border-radius:8px;font-size:0.875rem">+ New Evaluation</a>
    </div>

    <div class="card-dark">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>Teacher</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($evaluations)): ?>
                    <tr><td colspan="4" class="text-center" style="color:#94a3b8;padding:2rem">No evaluations yet. <a href="/student/evaluate" style="color:#6366f1">Start evaluating!</a></td></tr>
                <?php else: ?>
                    <?php foreach ($evaluations as $eval): ?>
                    <tr>
                        <td><?= esc($eval['teacher_name']) ?></td>
                        <td><?= esc($eval['course_name']) ?></td>
                        <td>
                            <?php if ($eval['status'] === 'submitted'): ?>
                                <span class="badge-submitted">Submitted</span>
                            <?php else: ?>
                                <span class="badge-pending">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td style="color:#94a3b8;font-size:0.875rem"><?= date('M d, Y', strtotime($eval['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</body>
</html>
