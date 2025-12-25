<?php $title = "Create Project"; ?>
<?php require_once "../app/views/layout/header.php"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>

<h2>Create Project</h2>

<div class="card shadow-sm col-md-6">
    <div class="card-body">
        <form method="post" action="/ticketflow/public/projects/store">

            <div class="mb-3">
                <label class="form-label">Project Name</label>
                <input class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Project Key</label>
                <input class="form-control" name="key" maxlength="10" required>
            </div>

            <button class="btn btn-primary">Create Project</button>
            <a href="/ticketflow/public/projects" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once "../app/views/layout/footer.php"; ?>
