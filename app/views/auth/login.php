<?php $title = "Login"; ?>
<?php require_once "../app/views/layout/header.php"; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-4">

        <div class="card shadow-sm">
            <div class="card-body p-4">

                <h3 class="text-center mb-3">TicketFlow</h3>
                <p class="text-center text-muted mb-4">
                    Sign in to your account
                </p>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="/ticketflow/public/auth/authenticate">

                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="you@company.com"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="••••••••"
                               required>
                    </div>

                    <button class="btn btn-primary w-100">
                        Sign In
                    </button>
                </form>

            </div>
        </div>

        <p class="text-center text-muted mt-3">
            © <?= date('Y') ?> TicketFlow
        </p>
    </div>
</div>

<?php require_once "../app/views/layout/footer.php"; ?>
