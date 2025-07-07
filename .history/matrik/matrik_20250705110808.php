<!DOCTYPE html>
<html lang="en">
<?php require "../layout/head.php"; require "../include/conn.php"; ?>
<body style="background:linear-gradient(135deg,#e0f2fe 0%,#f0f9ff 100%); min-height:100vh;">
  <div id="app">
    <?php require "../layout/navbar.php";?>
        <div id="" style="padding:0;min-height:100vh;background:#f4faff;" class="m-5 p-5 rounded rounded-4 shadow-sm">
      <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
          <i class="bi bi-justify fs-3"></i>
        </a>
      </header>
      <div class="page-heading mb-4">
        <h3 class="fw-bold mb-2" style="color:#0369a1;letter-spacing:1px;">Matrik</h3>
      </div>
            <div class="page-content" style="background:#f8fbff;border-radius:2rem 0 0 0;box-shadow:0 2px 8px 0 #e0e7ef;min-height:calc(100vh - 2rem);padding-bottom:2rem;">
        <section class="row justify-content-center">
          <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm" style="background:#f8fbff;">
              <div class="card-header bg-white border-0 rounded-top-4 d-flex align-items-center justify-content-between flex-wrap" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;gap:1rem;">
                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Matriks Keputusan (X) &amp; Ternormalisasi (R)</h4>
                <button type="button" class="btn btn-primary btn-lg px-4 py-2 fw-bold d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#inlineForm" style="border-radius:2rem;font-size:1rem;background:#38b6ff;border:none;gap:0.5rem;">
                  <i class="bi bi-plus-circle"></i>
                  <span>Isi Nilai Supplier</span>
                </button>
              </div>
              <div class="card-content">
                <div class="card-body pb-0">
                  <p class="card-text text-dark mb-3" style="font-size:1.05rem;">
                    Melakukan perhitungan normalisasi untuk mendapatkan matriks nilai ternormalisasi (R), dengan ketentuan:<br>
                    <span class="d-block mt-2">Jika <b>cost</b>: <code>Rij = ( min{Xij} / Xij)</code></span>
                    <span class="d-block">Jika <b>benefit</b>: <code>Rij = ( Xij/max{Xij} )</code></span>
                  </p>
                </div>
                <div class="table-responsive rounded-4 overflow-hidden mb-4">
                  <table class="table table-hover align-middle mb-0" style="background:#fff;">
                    <caption class="text-secondary ps-2">Matriks Keputusan Supplier (X)</caption>
                    <thead style="background:#e0f2fe;">
                      <tr style="color:#0369a1;font-weight:800;">
                        <th rowspan='2'>Supplier</th>
                        <th colspan='5'>Kriteria</th>
                        <th rowspan="2" class="text-center">Aksi</th>
                      </tr>
                      <tr style="color:#0369a1;font-weight:800;">
                        <th>C1</th>
                        <th>C2</th>
                        <th>C3</th>
                        <th>C4</th>
                        <th>C5</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT a.id_supplier, b.name AS supplier_name, SUM(IF(a.id_criteria=1,a.value,0)) AS C1, SUM(IF(a.id_criteria=2,a.value,0)) AS C2, SUM(IF(a.id_criteria=3,a.value,0)) AS C3, SUM(IF(a.id_criteria=4,a.value,0)) AS C4, SUM(IF(a.id_criteria=5,a.value,0)) AS C5 FROM saw_evaluations a JOIN supplier b ON a.id_supplier = b.id_supplier GROUP BY a.id_supplier, b.name ORDER BY a.id_supplier";
                    $result = $db->query($sql);
                    $X = array(1 => array(), 2 => array(), 3 => array(), 4 => array(), 5 => array());
                    while ($row = $result->fetch_object()) {
                        array_push($X[1], round($row->C1, 2));
                        array_push($X[2], round($row->C2, 2));
                        array_push($X[3], round($row->C3, 2));
                        array_push($X[4], round($row->C4, 2));
                        array_push($X[5], round($row->C5, 2));
                        echo "<tr>";
                        echo "<th>S<sub>{$row->id_supplier}</sub> {$row->supplier_name}</th>";
                        echo "<td>" . round($row->C1, 2) . "</td>";
                        echo "<td>" . round($row->C2, 2) . "</td>";
                        echo "<td>" . round($row->C3, 2) . "</td>";
                        echo "<td>" . round($row->C4, 2) . "</td>";
                        echo "<td>" . round($row->C5, 2). "</td>";
                        echo "<td class='text-center'><a href='matrik-edit.php?edit={$row->id_supplier}' class='btn btn-outline-primary btn-sm px-3 py-1 fw-bold' style='border-radius:1.5rem;background:#f0f9ff;border:1.5px solid #38b6ff;color:#0369a1;'><i class='bi bi-pencil-square me-1'></i>Edit</a></td>";
                        echo "</tr>\n";
                    }
                    $result->free();
                    ?>
                    </tbody>
                  </table>
                </div>
                <div class="table-responsive rounded-4 overflow-hidden mb-4">
                  <table class="table table-hover align-middle mb-0" style="background:#fff;">
                    <caption class="text-secondary ps-2">Matriks Ternormalisasi Supplier (R)</caption>
                    <thead style="background:#e0f2fe;">
                      <tr style="color:#0369a1;font-weight:800;">
                        <th rowspan='2'>Supplier</th>
                        <th colspan='5'>Kriteria</th>
                      </tr>
                      <tr style="color:#0369a1;font-weight:800;">
                        <th>C1</th>
                        <th>C2</th>
                        <th>C3</th>
                        <th>C4</th>
                        <th>C5</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT a.id_supplier, s.name AS supplier_name,
                        SUM(IF(a.id_criteria=1, IF(b.attribute='benefit', a.value/" . max($X[1]) . ", " . min($X[1]) . "/a.value), 0)) AS C1,
                        SUM(IF(a.id_criteria=2, IF(b.attribute='benefit', a.value/" . max($X[2]) . ", " . min($X[2]) . "/a.value), 0)) AS C2,
                        SUM(IF(a.id_criteria=3, IF(b.attribute='benefit', a.value/" . max($X[3]) . ", " . min($X[3]) . "/a.value), 0)) AS C3,
                        SUM(IF(a.id_criteria=4, IF(b.attribute='benefit', a.value/" . max($X[4]) . ", " . min($X[4]) . "/a.value), 0)) AS C4,
                        SUM(IF(a.id_criteria=5, IF(b.attribute='benefit', a.value/" . max($X[5]) . ", " . min($X[5]) . "/a.value), 0)) AS C5
                        FROM saw_evaluations a
                        JOIN saw_criterias b USING(id_criteria)
                        JOIN supplier s ON a.id_supplier = s.id_supplier
                        GROUP BY a.id_supplier, s.name
                        ORDER BY a.id_supplier";
                    $result = $db->query($sql);
                    $R = array();
                    $adaData = false;
                    while ($row = $result->fetch_object()) {
                        $adaData = true;
                        $R[$row->id_supplier] = array($row->C1, $row->C2, $row->C3, $row->C4, $row->C5);
                        echo "<tr class='center'>
            <th>S<sub>{$row->id_supplier}</sub> {$row->supplier_name}</th>
            <td>" . round($row->C1, 2) . "</td>
            <td>" . round($row->C2, 2) . "</td>
            <td>" . round($row->C3, 2) . "</td>
            <td>" . round($row->C4, 2) . "</td>
            <td>" . round($row->C5, 2) . "</td>
          </tr>\n";
                    }
                    if (!$adaData) {
                        echo "<tr><td colspan='6' class='text-center text-secondary'>Belum ada data supplier yang dinilai.</td></tr>";
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
                <!-- Tombol dipindah ke header card -->
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php require "../layout/footer.php";?>
    </div>
  </div>
  <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content" style="max-height:80vh;overflow-y:auto;">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Isi Nilai Supplier</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <label>Nama Supplier:</label>
                            <div class="form-group mb-3">
                                <select class="form-control form-select" name="id_supplier" required>
                                    <option value="">Pilih Supplier</option>
                                    <?php
                                    $sql = 'SELECT id_supplier, name FROM supplier';
                                    $result = $db->query($sql);
                                    while ($row = $result->fetch_object()) {
                                        echo '<option value="' . $row->id_supplier . '">' . htmlspecialchars($row->name) . '</option>';
                                    }
                                    $result->free();
                                    ?>
                                </select>
                            </div>
                            <div class="alert alert-info py-2 px-3 mb-3" style="font-size:0.98rem;background:linear-gradient(90deg,#e0f2fe 0%,#f0f9ff 100%);border-left:4px solid #38b6ff;">
                                <div class="mb-1 fw-bold text-secondary">                                 
                                    <b>Contoh Pengisian:</b><br>
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
                            <label>Nilai Kriteria:</label>
                            <?php
                            $sql = 'SELECT id_criteria,criteria FROM saw_criterias ORDER BY id_criteria';
                            $result = $db->query($sql);
                            while ($row = $result->fetch_object()) {
                                echo '<div class="form-group mb-2">';
                                echo '<label class="form-label">' . htmlspecialchars($row->criteria) . '</label>';
                                echo '<input type="number" step="any" name="nilai[' . $row->id_criteria . ']" class="form-control" placeholder="Contoh: 7" required>';
                                echo '</div>';
                            }
                            $result->free();
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" name="submit_inline" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_inline'], $_POST['id_supplier'], $_POST['nilai']) && is_array($_POST['nilai'])) {
      $id_supplier = intval($_POST['id_supplier']);
      foreach ($_POST['nilai'] as $id_criteria => $value) {
          $id_criteria = intval($id_criteria);
          $value = floatval($value);
          $cek = $db->query("SELECT * FROM saw_evaluations WHERE id_supplier=$id_supplier AND id_criteria=$id_criteria");
          if ($cek->num_rows > 0) {
              $db->query("UPDATE saw_evaluations SET value=$value WHERE id_supplier=$id_supplier AND id_criteria=$id_criteria");
          } else {
              $db->query("INSERT INTO saw_evaluations (id_supplier, id_criteria, value) VALUES ($id_supplier, $id_criteria, $value)");
          }
      }
      echo '<script>location.href="matrik.php";</script>';
      exit;
  }
  require "../layout/js.php";
  ?>
</body>
</html>