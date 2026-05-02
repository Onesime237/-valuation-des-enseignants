<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
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
        .badge-role { background: #10b981; color: #fff; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 999px; font-weight: 600; }
        .main { padding: 2rem; }
        .welcome-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
        }
        .welcome-card h2 { font-size: 1.3rem; font-weight: 700; color: #f1f5f9; }
        .welcome-card p { color: #94a3b8; margin: 0; font-size: 0.9rem; }
        .stat-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 1.5rem;
            text-decoration: none;
            display: block;
            transition: all 0.2s;
        }
        .stat-card:hover {
            border-color: #10b981;
            transform: translateY(-3px);
        }
        .stat-card .number { font-size: 2rem; font-weight: 700; color: #10b981; }
        .stat-card .label { color: #94a3b8; font-size: 0.875rem; margin-top: 0.25rem; }
        .stat-card .icon { font-size: 1.8rem; margin-bottom: 0.5rem; }
        .btn-logout { background: transparent; border: 1px solid #ef4444; color: #ef4444; border-radius: 8px; padding: 0.4rem 1rem; font-size: 0.875rem; text-decoration: none; }
        .btn-logout:hover { background: #ef4444; color: #fff; }
        .card-dark { background: #1e293b; border: 1px solid #334155; border-radius: 12px; }
        .table-dark-custom { color: #f1f5f9; }
        .table-dark-custom thead th { background: #0f172a; border-color: #334155; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase; }
        .table-dark-custom td { border-color: #334155; vertical-align: middle; }
        .btn-download { background: #10b981; color: #fff; border-radius: 8px; padding: 0.4rem 1rem; font-size: 0.75rem; text-decoration: none; }
        .btn-download:hover { background: #059669; color: #fff; }
        .badge-score { background: #6366f1; color: #fff; padding: 0.3rem 0.8rem; border-radius: 999px; font-size: 0.875rem; font-weight: 600; }
    </style>
</head>
<body>

<div class="topbar">
    <div class="d-flex align-items-center gap-3">
        <h1>Teacher Evaluation</h1>
        <span class="badge-role">Teacher</span>
    </div>
    <div class="d-flex align-items-center gap-4">
        <a href="/teacher/dashboard" class="nav-link active" style="color:#f1f5f9">Dashboard</a>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>
</div>

<div class="main">

    <div class="welcome-card">
        <h2>Welcome, <?= esc($user_name) ?> 👋</h2>
        <p>You are logged in as Teacher. View your evaluation results and feedback from students.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon">📚</div>
                <div class="number"><?= count($courses) ?></div>
                <div class="label">Courses Assigned</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon">📝</div>
                <div class="number"><?= $total_evaluations ?></div>
                <div class="label">Total Evaluations</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="icon">📄</div>
                <div class="number"><?= $total_pdfs ?></div>
                <div class="label">PDF Reports</div>
            </div>
        </div>
    </div>

    <!-- Average Scores by Course -->
    <?php if (!empty($averageScores)): ?>
    <h3 style="font-size:1.1rem;font-weight:600;margin-bottom:1rem">Average Scores by Course</h3>
    <div class="row g-3 mb-4">
        <?php foreach ($averageScores as $course => $score): ?>
        <div class="col-md-4">
            <div class="card-dark" style="padding:1.25rem">
                <div style="color:#94a3b8;font-size:0.875rem;margin-bottom:0.5rem"><?= esc($course) ?></div>
                <div style="font-size:1.5rem;font-weight:700;color:#10b981">
                    <span class="badge-score"><?= $score ?>/5</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Evaluation PDFs List -->
    <h3 style="font-size:1.1rem;font-weight:600;margin-bottom:1rem">Your Evaluation Reports</h3>
    <div class="card-dark">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course</th>
                    <th>Generated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pdfs)): ?>
                    <tr><td colspan="5" class="text-center" style="color:#94a3b8;padding:2rem">No evaluation reports yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($pdfs as $pdf): ?>
                    <tr>
                        <td><?= esc($pdf['id']) ?></td>
                        <td><?= esc($pdf['course_name']) ?></td>
                        <td style="color:#94a3b8;font-size:0.875rem"><?= date('M d, Y H:i', strtotime($pdf['generated_at'])) ?></td>
                        <td>
                            <a href="/teacher/download-pdf/<?= $pdf['id'] ?>" class="btn-download">📥 Download</a>
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
