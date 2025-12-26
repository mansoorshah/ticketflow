<?php $title = "Dashboard"; ?>
<?php require_once "../app/views/layout/header.php"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>
<?php
require_once "../app/models/Ticket.php";

$ticketModel = new Ticket();
$userId = $_SESSION['user']['id'];
$assignedCount = $ticketModel->countAssignedToUser($userId);
?>


<h2 class="mb-4">Dashboard</h2>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Role</h6>
                <h4><?= htmlspecialchars(Auth::user()['role']) ?></h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Email</h6>
                <h4><?= htmlspecialchars(Auth::user()['email']) ?></h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
    <a href="/ticketflow/public/tickets/assigned" class="text-decoration-none">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted">Tickets assigned to Me</h6>
                <h3 class="fw-bold text-primary">
                    <?= $assignedCount ?? 0 ?>
                </h3>
            </div>
        </div>
    </a>
    </div>

</div>

<?php require_once "../app/views/layout/footer.php"; ?>
