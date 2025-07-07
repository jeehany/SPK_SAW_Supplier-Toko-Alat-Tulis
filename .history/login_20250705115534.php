<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAW</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
</head>


<body style="background:linear-gradient(135deg,#e0f2fe 0%,#f0f9ff 100%); min-height:100vh;">
    <div id="auth" class="d-flex align-items-center justify-content-center" style="min-height:100vh;">
        <div class="card border-0 rounded-4 shadow-lg overflow-hidden" style="max-width:900px;width:100%;background:#f8fbff;">
            <div class="row g-0">
                <div class="col-lg-6 col-12 d-flex align-items-center" style="background:#e0f2fe;">
                    <div class="w-100 p-5">
                        <div class="text-center mb-4">
                            <img src="assets/images/favicon.png" alt="Logo" style="width:56px;height:56px;">
                        </div>
                        <h2 class="fw-bold mb-3 text-primary" style="letter-spacing:1px;">SPK SAW</h2>
                        <h4 class="mb-4" style="color:#0369a1;">Login ke Sistem</h4>
                        <form action="login-act.php" method="post">
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-lg rounded-3" placeholder="Username" name="username" required autofocus style="background:#f0f9ff;">
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" class="form-control form-control-lg rounded-3" placeholder="Password" name="password" required style="background:#f0f9ff;">
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" style="border-radius:1.5rem;background:#38b6ff;border:none;">Log in</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block" style="background:linear-gradient(135deg,#38b6ff 0%,#e0f2fe 100%);">
                    <div class="h-100 d-flex align-items-center justify-content-center">
                        <div class="text-center p-5">
                            <img src="assets/images/logo-remove.png" alt="Login Illustration" style="max-width:320px;width:100%;">
                            <div class="mt-4">
                                <div class="badge mb-2" style="font-size:1rem;background:#38b6ff;color:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.10);">
                                    Selamat datang<br>
                                    <span >di Sistem Pendukung Keputusan</span>
                                </div>
                                <div class="mt-3" style="font-size:1.08rem;line-height:1.5;color:#f0f9ff;text-shadow:0 1px 4px rgba(0,0,0,0.13);">
                                    <span class="badge mb-2" style="font-size:1rem;background:#38b6ff;color:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.10);">Metode SAW</span><br>
                                    <span class="badge mb-2" style="font-size:1rem;background:#38b6ff;color:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.10);">Pemilihan Supplier Alat Tulis</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
