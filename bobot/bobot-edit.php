<?php
require "../include/conn.php";
$id = $_GET['id'];
$sql = "SELECT * FROM saw_criterias WHERE id_criteria = '$id' ";
$result = $db->query($sql);
$row = $result->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
    <?php require "../layout/head.php";?>
    <body style="background:linear-gradient(135deg,#e0f2fe 0%,#f0f9ff 100%); min-height:100vh;">
        <div id="app">
            <?php require "../layout/navbar.php";?>
        <div id="main" style="padding:0;min-height:100vh;background:#f4faff;">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>
                <div class="page-heading mb-4">
                    <h3 class="fw-bold mb-2" style="color:#0369a1;letter-spacing:1px;">Edit Bobot Kriteria Supplier</h3>
                </div>
            <div class="page-content" style="background:#f8fbff;border-radius:2rem 0 0 0;box-shadow:0 2px 8px 0 #e0e7ef;min-height:calc(100vh - 2rem);padding-bottom:2rem;">
                    <section class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-7">
                            <div class="card border-0 rounded-4 shadow-sm" style="background:#f8fbff;">
                                <div class="card-header bg-white border-0 rounded-top-4" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;">
                                    <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Edit Data Kriteria Penilaian Supplier</h4>
                                </div>
                                <div class="card-body py-4 px-4">
                                    <form action="bobot-edit-act.php" method="POST">
                                        <input type="hidden" name="id_criteria" value="<?=$row['id_criteria'];?>">
                                        <div class="mb-3">
                                            <label for="criteria" class="form-label fw-semibold text-dark">Nama Kriteria Penilaian Supplier</label>
                                            <input type="text" class="form-control form-control-lg rounded-3" id="criteria" name="criteria" value="<?=htmlspecialchars($row['criteria']);?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="weight" class="form-label fw-semibold text-dark">Bobot</label>
                                            <input type="number" step="any" class="form-control form-control-lg rounded-3" id="weight" name="weight" value="<?=htmlspecialchars($row['weight']);?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="attribute" class="form-label fw-semibold text-dark">Atribut</label>
                                            <select class="form-select form-select-lg rounded-3" id="attribute" name="attribute" required>
                                                <option value="benefit" <?=($row['attribute']==='benefit'?'selected':'')?>>Benefit</option>
                                                <option value="cost" <?=($row['attribute']==='cost'?'selected':'')?>>Cost</option>
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary btn-lg px-4 fw-bold" style="border-radius:1.5rem;background:#38b6ff;border:none;">
                                                <i class="bi bi-check2-circle me-1"></i>Simpan Perubahan
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