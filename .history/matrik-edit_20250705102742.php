<?php
require "include/conn.php";
require "layout/head.php";

// Ambil id_supplier dari query string
$id_supplier = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
if ($id_supplier <= 0) {
    echo '<script>location.href="matrik/matrik.php";</script>';
    exit;
}

// Ambil data supplier
$sql_sup = "SELECT name FROM supplier WHERE id_supplier=$id_supplier";
$result_sup = $db->query($sql_sup);
$sup = $result_sup->fetch_object();
$result_sup->free();

// Ambil semua kriteria
$sql_kriteria = "SELECT id_criteria, criteria FROM saw_criterias ORDER BY id_criteria";
$result_kriteria = $db->query($sql_kriteria);
$kriterias = [];
while ($row = $result_kriteria->fetch_object()) {
    $kriterias[] = $row;
}
$result_kriteria->free();

// Ambil nilai existing
$nilai = [];
$sql_nilai = "SELECT id_criteria, value FROM saw_evaluations WHERE id_supplier=$id_supplier";
$result_nilai = $db->query($sql_nilai);
while ($row = $result_nilai->fetch_object()) {
    $nilai[$row->id_criteria] = $row->value;
}
$result_nilai->free();

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($kriterias as $k) {
        $idc = $k->id_criteria;
        $val = isset($_POST['nilai'][$idc]) ? floatval($_POST['nilai'][$idc]) : 0;
        $cek = $db->query("SELECT * FROM saw_evaluations WHERE id_supplier=$id_supplier AND id_criteria=$idc");
        if ($cek->num_rows > 0) {
            $db->query("UPDATE saw_evaluations SET value=$val WHERE id_supplier=$id_supplier AND id_criteria=$idc");
        } else {
            $db->query("INSERT INTO saw_evaluations (id_supplier, id_criteria, value) VALUES ($id_supplier, $idc, $val)");
        }
    }
    echo '<script>location.href="matrik/matrik.php";</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<body style="background:linear-gradient(135deg,#e0f2fe 0%,#f0f9ff 100%); min-height:100vh;">
  <div id="app">
    <?php require "layout/navbar.php"; ?>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10">
          <div class="card border-0 rounded-4 shadow-sm" style="background:#f8fbff;">
            <div class="card-header bg-white border-0 rounded-top-4 d-flex align-items-center" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;">
              <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Edit Nilai Supplier</h4>
            </div>
            <div class="card-body">
              <form method="POST">
                <div class="mb-3">
                  <label class="form-label fw-semibold">Nama Supplier</label>
                  <input type="text" class="form-control" value="<?= htmlspecialchars($sup->name) ?>" readonly>
                </div>
                <div class="alert alert-info py-2 px-3 mb-3" style="font-size:0.98rem;background:linear-gradient(90deg,#e0f2fe 0%,#f0f9ff 100%);border-left:4px solid #38b6ff;">
                  <b class="mb-1 fw-bold text-secondary">Contoh Pengisian:</b><br>
                  <div class="mb-1 fw-bold text-secondary">
                    <ul class="mb-1 mt-1 ps-3">
                    <li><b>Harga</b>: 7 (semakin rendah semakin baik, cost)</li>
                    <li><b>Kualitas Barang</b>: 9 (semakin tinggi semakin baik, benefit)</li>
                    <li><b>Ketepatan Waktu</b>: 8</li>
                    <li><b>Pelayanan</b>: 7</li>
                    <li><b>Ketersediaan Stok</b>: 10</li>
                  </ul>
                  </div>
                  <span class="text-secondary">Gunakan skala penilaian yang konsisten, misal 1–10. Pastikan semua kriteria diisi untuk setiap supplier.</span>
                </div>
                <?php foreach ($kriterias as $k): ?>
                <div class="mb-3">
                  <label class="form-label"><?= htmlspecialchars($k->criteria) ?></label>
                  <input type="number" step="any" name="nilai[<?= $k->id_criteria ?>]" class="form-control" value="<?= isset($nilai[$k->id_criteria]) ? htmlspecialchars($nilai[$k->id_criteria]) : '' ?>" placeholder="Contoh: 7" required>
                </div>
                <?php endforeach; ?>
                <div class="d-flex justify-content-between mt-4">
                  <a href="matrik/matrik.php" class="btn btn-light border">Batal</a>
                  <button type="submit" class="btn btn-primary px-4 fw-bold"><i class="bi bi-save me-1"></i> Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require "layout/js.php"; ?>
  </div>
</body>
</html>
