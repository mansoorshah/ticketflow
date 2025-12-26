<?php $title = "Ticket Details"; ?>
<?php require_once "../app/views/layout/header.php"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>

<h2 class="mb-3">
    <?= htmlspecialchars($ticket['title']) ?>
</h2>

<!-- Ticket Main Info -->
<div class="card shadow-sm mb-4">
    <div class="card-body">



        <!-- Status + Assignment + Metadata -->
        <div class="row g-3">

            <!-- Status -->
            <div class="col-md-3">
                <form method="post"
                      action="/ticketflow/public/tickets/updateStatus/<?= $ticket['id'] ?>" >
                    <label class="form-label fw-bold">Status</label>
                    <select name="status"
                            class="form-select"
                            onchange="this.form.submit()">
                        <?php
                        $statuses = [
                            'open' => 'Open',
                            'in_progress' => 'In Progress',
                            'done' => 'Done',
                            'closed' => 'Closed'
                        ];
                        foreach ($statuses as $key => $label):
                        ?>
                            <option value="<?= $key ?>"
                                <?= $ticket['status'] === $key ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <!-- Assignee -->
            <div class="col-md-3">
                <form method="post"
                      action="/ticketflow/public/tickets/assign/<?= $ticket['id'] ?>">
                    <label class="form-label fw-bold">Assignee</label>
                    <select name="assignee_id"
                            class="form-select"
                            onchange="this.form.submit()">
                        <option value="">Unassigned</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"
                                <?= $ticket['assignee_id'] == $user['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <!-- Reporter -->
            <div class="col-md-3">
                <label class="form-label fw-bold">Reporter</label>
                <div class="form-control bg-light">
                    <?= htmlspecialchars($ticket['reporter']) ?>
                </div>
            </div>

            <!-- Priority -->
            <div class="col-md-3">
                <form method="post"
                      action="/ticketflow/public/tickets/updatePriority/<?= $ticket['id'] ?>">
                    <label class="form-label fw-bold">Priority</label>
                    <select name="priority"
                            class="form-select"
                            onchange="this.form.submit()">
                        <?php
                        $statuses = [
                            'low' => 'Low',
                            'medium' => 'Medium',
                            'high' => 'High',
                            'critical' => 'Critical'
                        ];
                        foreach ($statuses as $key => $label):
                        ?>
                            <option value="<?= $key ?>"
                                <?= $ticket['priority'] === $key ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- Description -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3">Issue Summary</h5>
        <div class="row g-3"> 
            <div class="col-md-3">   
                <p class="mb-4">
                    <?= nl2br(htmlspecialchars($ticket['description'])) ?>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Attachments -->
<?php if (!empty($attachments)): ?>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3">Attachments</h5>
        <ul class="list-group">
            <?php foreach ($attachments as $file): ?>
                <li class="list-group-item">
                    <a href="/ticketflow/public/<?= $file['file_path'] ?>"
                       target="_blank">
                        <?= htmlspecialchars($file['file_name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>

<!-- Comments -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="mb-3">Comments</h5>

        <?php if (empty($comments)): ?>
            <p class="text-muted">No comments yet.</p>
        <?php endif; ?>

        <?php foreach ($comments as $comment): ?>
            <div class="border-bottom pb-3 mb-3">

                <strong><?= htmlspecialchars($comment['name']) ?></strong>
                <small class="text-muted ms-2">
                    <?= $comment['created_at'] ?>
                </small>

                <p class="mb-2 mt-2">
                    <?= nl2br(htmlspecialchars($comment['body'])) ?>
                </p>

                <?php if (!empty($comment['attachments'])): ?>
                    <ul class="list-group list-group-flush mt-2">
                        <?php foreach ($comment['attachments'] as $file): ?>
                            <li class="list-group-item px-0">
                                <a href="/ticketflow/public/<?= htmlspecialchars($file['file_path']) ?>"
                                   target="_blank">
                                    <?= htmlspecialchars($file['file_name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
</div>


<!-- Add Comment -->
<div class="card shadow-sm">
    <div class="card-body">
        <form method="post"
              action="/ticketflow/public/tickets/comment/<?= $ticket['id'] ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <textarea name="body"
                          class="form-control"
                          rows="3"
                          placeholder="Write a comment..."
                          required></textarea>
                <input type="file" name="attachment" class="form-control">
            </div>
            <button class="btn btn-primary">
                Add Comment
            </button>
        </form>
    </div>
</div>

<?php require_once "../app/views/layout/footer.php"; ?>
