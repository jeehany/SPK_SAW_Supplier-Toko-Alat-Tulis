<?php require "../include/conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<?php require "../layout/head.php";?>
<body style="background:linear-gradient(135deg,#e0f2fe 0%,#f0f9ff 100%); min-height:100vh;">
    <div id="app">
        <?php require "../layout/navbar.php";?>
        <div id="main" style="padding:32px 0 0 0;">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading mb-4">
                <h3 class="fw-bold mb-2" style="color:#0369a1;letter-spacing:1px;">Input Nilai Supplier</h3>
            </div>
            <div class="page-content">
                <section class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-7">
                        <div class="card border-0 rounded-4 shadow-sm" style="background:#f8fbff;">
                            <div class="card-header bg-white border-0 rounded-top-4" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;">
                                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Form Input Nilai</h4>
                            </div>
                            <div class="card-body py-4 px-4">
                                <form action="matrik-simpan.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">ID Supplier</label>
                                        <input type="text" name="id_alternative" class="form-control form-control-lg rounded-3" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">ID Kriteria</label>
                                        <input type="text" name="id_criteria" class="form-control form-control-lg rounded-3" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">Nilai</label>
                                        <input type="number" name="value" class="form-control form-control-lg rounded-3" required>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-lg px-4 fw-bold" style="border-radius:1.5rem;background:#38b6ff;border:none;">
                                            <i class="bi bi-check2-circle me-1"></i>Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php require "../layout/footer.php";?>
        </div>
    </div>
    <?php require "../layout/js.php";?>
</body>
</html>
