<div class="container-fluid">
    <div class="row min-vh-100 align-items-stretch">


        <!-- Sidebar -->
        <div class="col-2 sidebar p-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">TicketFlow</h4>
                <button class="theme-toggle" id="themeToggle" title="Toggle theme">
                    <span id="themeIcon">🌙</span>
                </button>
            </div>

            <a href="/ticketflow/public/dashboard">Dashboard</a>
            <a href="/ticketflow/public/projects">Projects</a>
            <a href="/ticketflow/public/tickets/assigned">Assigned to Me</a>

            <hr>

            <small class="text-muted">Logged in as</small>
            <div><?= htmlspecialchars(Auth::user()['name']) ?></div>

            <a class="mt-3 text-danger" href="/ticketflow/public/auth/logout">Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-10 content">
