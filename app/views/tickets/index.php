<?php require_once "../app/views/layout/header.php"; ?>
<?php $title = "Tickets"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Tickets</h2>
    <a href="/ticketflow/public/tickets/create/<?= $projectId ?>"
       class="btn btn-primary rounded-3 px-4 py-2 fw-semibold">
        + New Ticket
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table id="ticketsTable" class="table table-striped table-hover table-tickets">
            <thead>
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
                <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td><?= $ticket['id'] ?></td>
                        <td>
                            <a href="/ticketflow/public/tickets/show/<?= $ticket['id'] ?>">
                                <?= htmlspecialchars($ticket['title']) ?>
                            </a>
                        </td>
                        <td><?= BadgeHelper::priority($ticket['priority']) ?></td>
                        <td><?= BadgeHelper::status($ticket['status']) ?></td>
                        <td><?= $ticket['assignee_name'] ?? 'Unassigned' ?></td>
                        <td><?= $ticket['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<?php require_once "../app/views/layout/footer.php"; ?>
