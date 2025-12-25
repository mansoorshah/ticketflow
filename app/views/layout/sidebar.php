<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-2 sidebar p-3">
            <h4 class="mb-4">TicketFlow</h4>

            <a href="/ticketflow/public/dashboard">Dashboard</a>
            <a href="/ticketflow/public/projects">Projects</a>

            <hr>

            <small class="text-muted">Logged in as</small>
            <div><?= htmlspecialchars(Auth::user()['name']) ?></div>

            <a class="mt-3 text-danger" href="/ticketflow/public/auth/logout">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-10 content">
