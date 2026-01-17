<?php $title = "Login"; ?>
<?php require_once "../app/views/layout/header.php"; ?>

<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    body::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(99, 102, 241, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 40% 20%, rgba(139, 92, 246, 0.3) 0%, transparent 50%);
        animation: drift 20s ease-in-out infinite;
    }

    @keyframes drift {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(50px, 50px) rotate(5deg); }
    }

    .login-container {
        position: relative;
        z-index: 1;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 40px;
        max-width: 450px;
        width: 100%;
    }

    [data-theme="dark"] .login-card {
        background: rgba(31, 41, 55, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .login-card h3 {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .login-card .subtitle {
        color: #6b7280;
        margin-bottom: 30px;
    }

    [data-theme="dark"] .login-card .subtitle {
        color: #9ca3af;
    }

    .login-card .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #374151;
    }

    [data-theme="dark"] .login-card .form-label {
        color: #f9fafb;
    }

    .login-card .form-control {
        padding: 12px 16px;
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
        background-color: #ffffff;
        color: #111827;
    }

    [data-theme="dark"] .login-card .form-control {
        background-color: #1f2937;
        color: #f9fafb;
        border-color: #374151;
    }

    .login-card .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background-color: #ffffff;
        color: #111827;
    }

    [data-theme="dark"] .login-card .form-control:focus {
        background-color: #1f2937;
        color: #f9fafb;
        border-color: #667eea;
    }

    .login-card .form-control::placeholder {
        color: #9ca3af;
    }

    [data-theme="dark"] .login-card .form-control::placeholder {
        color: #6b7280;
    }

    .login-card .btn-primary {
        padding: 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1.05rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .login-card .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .login-footer {
        text-align: center;
        margin-top: 20px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }

    .alert {
        border-radius: 10px;
        border: none;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <h3 class="text-center">TicketFlow</h3>
        <p class="text-center subtitle">
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

            <button type="submit" class="btn btn-primary w-100">
                Sign In
            </button>
        </form>

        <p class="login-footer">
            © <?= date('Y') ?> TicketFlow
        </p>
    </div>
</div>

<?php require_once "../app/views/layout/footer.php"; ?>
