<button class="icon-button theme-toggle auth-theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
    <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
</button>
<main class="auth-page">
    <section class="auth-card">
        <a class="auth-brand" href="index.html"><span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span><span><strong>adminHMD</strong><small>Sign in to your admin workspace.</small></span></a>
        <form action="" method="POST" autocomplete="off">
        <div class="mb-4">
            <p class="eyebrow mb-1">Secure Access</p>
            <h1 class="h3 mb-1">Login</h1>
            <p class="text-muted mb-0">Sign in to your admin workspace.</p>
        </div>
        <div class="mb-3">
            <label class="form-label" for="loginEmail">Usuario</label>
            <input class="form-control" id="loginEmail" type="text" name="username_login">
            <div class="invalid-feedback">Enter a valid usernames.</div>
        </div>
        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="loginPassword">Password</label>
                <a class="small fw-semibold" href="forgot-password.html">Forgot?</a>
            </div>
            <input class="form-control" id="loginPassword" type="password" name="password_login" minlength="6">
            <div class="invalid-feedback">Password must be at least 6 characters.</div>
        </div>
        
        <button class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Sign In
        </button>

        

        <!-- <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Sign In</button> -->
        </form> 
    </section>
</main>
<?php
    if(isset($_POST['username_login']) && isset($_POST['password_login'])) {
        require_once './controller/loginController.php';
        $ins_login = new loginController();
        $ins_login->log_in_controller();
    }
?>