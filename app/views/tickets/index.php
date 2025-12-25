<?php require_once "../app/views/layout/header.php"; ?>
<?php $title = "Tickets"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>

<div class="d-flex justify-content-between mb-3">
    <h2>Tickets</h2>
    <a href="/ticketflow/public/tickets/create/<?= $projectId ?>"
       class="btn btn-primary">
        + New Ticket
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Assignee</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tickets)): ?>
                    <tr><td colspan="6" class="text-center">No tickets yet</td></tr>
                <?php endif; ?>

                <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= $ticket['id'] ?></td>
					<td>
						<a href="/ticketflow/public/tickets/show/<?= $ticket['id'] ?>">
							<?= htmlspecialchars($ticket['title']) ?>
						</a>
					</td>
                    <td>
					<?php
					$priorityColors = [
						'critical' => 'bg-dark text-danger',   // maroon-like
						'high'     => 'bg-danger',
						'medium'   => 'bg-warning text-dark',
						'low'      => 'bg-primary'
					];
					?>

					<td>
						<span class="badge <?= $priorityColors[$ticket['priority']] ?>">
							<?= ucfirst($ticket['priority']) ?>
						</span>
					</td>

                    </td>
					
					<?php
					$statusColors = [
						'open' => 'secondary',
						'in_progress' => 'info',
						'done' => 'success',
						'closed' => 'dark'
					];
					?>

					<td>
						<span class="badge bg-<?= $statusColors[$ticket['status']] ?>">
							<?= ucfirst(str_replace('_',' ', $ticket['status'])) ?>
						</span>
					</td>

                    <td><?= $ticket['assignee'] ?? 'Unassigned' ?></td>
                    <td><?= $ticket['created_at'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once "../app/views/layout/footer.php"; ?>
