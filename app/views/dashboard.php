<?php $title = "Dashboard"; ?>
<?php require_once "../app/views/layout/header.php"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>

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
</div>

<?php require_once "../app/views/layout/footer.php"; ?>
