<h3>Ticket Unassigned</h3>

<p>Hello <?= htmlspecialchars($oldAssignee['name'] ?? 'User') ?>,</p>

<p>
    The ticket <strong>#<?= $ticket['id'] ?></strong>
    has been reassigned to another user.
</p>

<p>
    <strong>Title:</strong>
    <?= htmlspecialchars($ticket['title'] ?? '') ?>
</p>

<p>
    You are no longer responsible for this ticket.
</p>
