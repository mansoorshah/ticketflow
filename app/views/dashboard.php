<?php $title = "Dashboard"; ?>
<?php require_once "../app/views/layout/header.php"; ?>
<?php require_once "../app/views/layout/sidebar.php"; ?>

<h2 class="mb-4">Dashboard</h2>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-9 col-md-8">
        <!-- Tickets Assigned Over Time -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">📈 Tickets Assigned to Me Over Time (Last 30 Days)</h5>
                        <canvas id="ticketsOverTimeChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tickets and Critical Tickets -->
        <div class="row mb-4">
            <!-- Recent Tickets Stream -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">🕒 Recent Tickets</h5>
                        <?php if (empty($recentTickets)): ?>
                            <p class="text-muted">No recent tickets.</p>
                        <?php else: ?>
                            <div class="ticket-list">
                                <?php foreach ($recentTickets as $ticket): ?>
                                    <a href="/ticketflow/public/tickets/show/<?= $ticket['id'] ?>" 
                                       class="ticket-item">
                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1"><?= htmlspecialchars($ticket['title']) ?></h6>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($ticket['project_name'] ?? 'No Project') ?> • 
                                                    <?= BadgeHelper::status($ticket['status']) ?>
                                                </small>
                                            </div>
                                            <small class="text-muted"><?= date('M d', strtotime($ticket['created_at'])) ?></small>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Top Critical Tickets -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">🔥 Top Critical Tickets</h5>
                        <?php if (empty($criticalTickets)): ?>
                            <p class="text-muted">No critical tickets.</p>
                        <?php else: ?>
                            <div class="ticket-list">
                                <?php foreach ($criticalTickets as $ticket): ?>
                                    <a href="/ticketflow/public/tickets/show/<?= $ticket['id'] ?>" 
                                       class="ticket-item">
                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1"><?= htmlspecialchars($ticket['title']) ?></h6>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($ticket['project_name'] ?? 'No Project') ?> • 
                                                    <?= BadgeHelper::priority($ticket['priority']) ?>
                                                </small>
                                            </div>
                                            <small class="text-muted"><?= $ticket['assignee_name'] ?? 'Unassigned' ?></small>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="col-lg-3 col-md-4">
        <div class="card shadow-sm sticky-top" style="top: 20px;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="avatar-circle mx-auto mb-3">
                        <span class="avatar-text">
                            <?= strtoupper(substr(Auth::user()['name'], 0, 2)) ?>
                        </span>
                    </div>
                    <h5 class="mb-1"><?= htmlspecialchars(Auth::user()['name']) ?></h5>
                    <p class="text-muted mb-0 small"><?= htmlspecialchars(Auth::user()['role']) ?></p>
                </div>

                <hr>

                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Email</small>
                    <p class="mb-0 small"><?= htmlspecialchars(Auth::user()['email']) ?></p>
                </div>

                <hr>

                <a href="/ticketflow/public/tickets/assigned" class="text-decoration-none">
                    <div class="text-center p-3 rounded" style="background-color: var(--bg-secondary);">
                        <h2 class="mb-1 fw-bold text-primary"><?= $assignedCount ?? 0 ?></h2>
                        <small class="text-muted">Tickets Assigned to Me</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Prepare data for chart
const chartData = <?= json_encode($assignedOverTime) ?>;

// Fill in missing dates to create continuous timeline
const dates = [];
const counts = [];
const today = new Date();
for (let i = 29; i >= 0; i--) {
    const date = new Date(today);
    date.setDate(date.getDate() - i);
    const dateStr = date.toISOString().split('T')[0];
    dates.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
    
    const found = chartData.find(d => d.date === dateStr);
    counts.push(found ? parseInt(found.count) : 0);
}

// Create chart
const ctx = document.getElementById('ticketsOverTimeChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: dates,
        datasets: [{
            label: 'Tickets Assigned',
            data: counts,
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>

<?php require_once "../app/views/layout/footer.php"; ?>
