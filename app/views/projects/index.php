<?php $title = "Projects"; ?>
<?php require_once "../app/views/layout/header.php"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>

<div class="d-flex justify-content-between mb-3">
    <h2>Projects</h2>

    <?php if (Auth::user()['role'] === 'admin'): ?>
        <a href="/ticketflow/public/projects/create" class="btn btn-primary">
            + New Project
        </a>
    <?php endif; ?>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Key</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= $project['id'] ?></td>
					<td>
						<a href="/ticketflow/public/tickets/index/<?= $project['id'] ?>">
							<?= htmlspecialchars($project['name']) ?>
						</a>
					</td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($project['project_key']) ?></span></td>
                    <td><?= $project['created_at'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once "../app/views/layout/footer.php"; ?>
