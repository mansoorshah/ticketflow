<?php $title = "Create Ticket"; ?>
<?php require_once "../app/views/layout/header.php"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>

<h2>Create Ticket</h2>

<div class="card shadow-sm col-md-8">
    <div class="card-body">
		<form method="post"
			  action="/ticketflow/public/tickets/store/<?= $projectId ?>"
			  enctype="multipart/form-data">


            <div class="mb-3">
                <label class="form-label">Title</label>
                <input name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description"
                          class="form-control"
                          rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Priority</label>
                <select name="priority" class="form-select">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>
            </div>
			
			<div class="mb-3">
				<label class="form-label">Attachment (optional)</label>
				<input type="file" name="attachment" class="form-control">
			</div>

            <button class="btn btn-primary">Create Ticket</button>
            <a href="javascript:history.back()" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</div>

<?php require_once "../app/views/layout/footer.php"; ?>
