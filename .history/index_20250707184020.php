<!DOCTYPE html>
<html lang="en">
<?php require "layout/head.php"; require "include/conn.php"; ?>
<body style="background:linear-gradient(135deg,#e0f2fe 0%,#f0f9ff 100%); min-height:100vh;">
    <div id="app">
        <?php require "layout/navbar.php";?>
        <div id="" style="padding:0;min-height:100vh;background:#f4faff;" class="m-5 p-5 rounded rounded-4 shadow-sm">
            <header class="mb-2" style="background:transparent;padding:0;min-height:0;">
                <a href="#" class="burger-btn d-block d-xl-none" style="margin:0.5rem 0 0 0.5rem;">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="d-flex align-items-center justify-content-between mb-4" style="margin-top:0.5rem;gap:1rem;">
                <div class="page-heading">
                    <h3 class="fw-bold mb-2" style="color:#0369a1;letter-spacing:1px;">Dashboard</h3>
                    <div class="alert alert-info d-flex align-items-center gap-3 shadow-sm mt-2 mb-0" style="max-width:700px;background:linear-gradient(90deg,#e0f2fe 0%,#f0f9ff 100%);border-left:6px solid #38b6ff;font-size:1.12rem;">
                        <i class="bi bi-info-circle-fill flex-shrink-0" style="font-size:1.7rem;color:#38b6ff;margin-right:0.7rem;"></i>
                        <span class="mb-1 fw-bold text-secondary" style="line-height:1.7;display:block;">
                        <b>SPK Supplier Toko Alat Tulis XYZ</b> — Sistem Pendukung Keputusan untuk pemilihan supplier terbaik menggunakan metode <b>Simple Additive Weighting (SAW)</b>.<br>Penilaian, perhitungan, dan perankingan supplier dilakukan otomatis dan transparan.
                        </span>
                    </div>
                </div>
                <a href="laporan_dashboard.php" target="_blank" class="btn btn-primary btn-lg d-inline-flex align-items-center" style="border-radius:2rem;font-size:1.1rem;gap:0.5rem;">
                    <i class="bi bi-printer"></i>
                    <span>Lihat & Cetak Laporan</span>
                </a>
            </div>
            <div class="page-content" style="background:#f8fbff;border-radius:2rem 0 0 0;box-shadow:0 2px 8px 0 #e0e7ef;min-height:calc(100vh - 2rem);padding-bottom:2rem;">
                <section class="row justify-content-center">
                    <div class="col-12">
                        <div class="row g-4 mb-4">
                            <?php
                            // Statistik
                            $alt = $db->query('SELECT COUNT(*) as total FROM supplier');
                            $alt_total = $alt->fetch_object()->total;
                            $krit = $db->query('SELECT COUNT(*) as total FROM saw_criterias');
                            $krit_total = $krit->fetch_object()->total;
                            $eval = $db->query('SELECT COUNT(*) as total FROM saw_evaluations');
                            $eval_total = $eval->fetch_object()->total;
                            // $user = $db->query('SELECT COUNT(*) as total FROM saw_users');
                            // $user_total = $user->fetch_object()->total;
                            ?>
                            <div class="col-6 col-md-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm text-center" style="border:2px solid #e0f2fe;">
                                    <h5 class="mb-1 fw-bold text-secondary">Supplier</h5>
                                    <h2 class="fw-bold" style="color:#38b6ff;"><?=$alt_total?></h2>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm text-center" style="border:2px solid #e0f2fe;">
                                    <h5 class="mb-1 fw-bold text-secondary">Kriteria</h5>
                                    <h2 class="fw-bold" style="color:#0ea5e9;"><?=$krit_total?></h2>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="p-4 bg-white rounded-4 shadow-sm text-center" style="border:2px solid #e0f2fe;">
                                    <h5 class="mb-1 fw-bold text-secondary">Evaluasi</h5>
                                    <h2 class="fw-bold" style="color:#f59e42;"><?=$eval_total?></h2>
                                </div>
                            </div>
                            <!-- Box User dihapus sesuai permintaan -->
                        </div>
                        <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:#f8fbff;">
                            <div class="card-header bg-white border-0 rounded-top-4 d-flex align-items-center justify-content-between flex-wrap" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;gap:1rem;">
                                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Daftar Supplier</h4>
                            </div>
                            <div class="card-body table-responsive rounded-4 overflow-hidden">
                                <table class="table table-hover align-middle mb-0" style="background:#fff;">
                                    <thead style="background:#e0f2fe;">
                                        <tr style="font-size:1.05rem; color:#0369a1;">
                                            <th class="text-center">No</th>
                                            <th>Nama Supplier</th>
                                            <th class="text-center">Logo Perusahaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = 'SELECT name, foto FROM supplier';
                                    $result = $db->query($sql);
                                    $i = 0;
                                    while ($row = $result->fetch_object()) {
                                        echo "<tr>\n";
                                        echo "    <td class='text-center fw-bold text-secondary'>" . (++$i) . "</td>\n";
                                        echo "    <td class='fw-semibold text-dark'>" . htmlspecialchars($row->name) . "</td>\n";
                                        echo "    <td class='text-center align-middle'>";
                                        if (!empty($row->foto)) {
                                            echo "<div class='d-flex justify-content-center align-items-center' style='height:40px;'><img src='" . htmlspecialchars($row->foto) . "' alt='Foto' style='width:36px;height:36px;object-fit:cover;border-radius:50%;border:1.5px solid #38b6ff;background:#e0f2fe;'></div>";
                                        } else {
                                            echo "<div class='d-flex justify-content-center align-items-center' style='height:40px;'><span class='d-inline-block rounded-circle bg-light border border-2 border-sky' style='width:36px;height:36px;background:#e0f2fe;'></span></div>";
                                        }
                                        echo "</td>\n";
                                        echo "  </tr>\n";
                                    }
                                    $result->free();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:#f8fbff;">
                            <div class="card-header bg-white border-0 rounded-top-4 d-flex align-items-center justify-content-between flex-wrap" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;gap:1rem;">
                                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Daftar Kriteria</h4>
                            </div>
                            <div class="card-body table-responsive rounded-4 overflow-hidden">
                                <table class="table table-hover align-middle mb-0" style="background:#fff;">
                                    <thead style="background:#e0f2fe;">
                                        <tr style="font-size:1.05rem; color:#0369a1;">
                                            <th class="text-center">No</th>
                                            <th>Kriteria</th>
                                            <th>Bobot</th>
                                            <th>Atribut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = 'SELECT criteria, weight, attribute FROM saw_criterias';
                                    $result = $db->query($sql);
                                    $i = 0;
                                    while ($row = $result->fetch_object()) {
                                        echo "<tr>\n";
                                        echo "    <td class='text-center fw-bold text-secondary'>" . (++$i) . "</td>\n";
                                        echo "    <td class='fw-semibold text-dark'>" . htmlspecialchars($row->criteria) . "</td>\n";
                                        echo "    <td class='fw-semibold text-dark'>" . $row->weight . "</td>\n";
                                        echo "    <td class='fw-semibold text-dark'>" . $row->attribute . "</td>\n";
                                        echo "  </tr>\n";
                                    }
                                    $result->free();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:#f8fbff;">
                            <div class="card-header bg-white border-0 rounded-top-4 d-flex align-items-center justify-content-between flex-wrap" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;gap:1rem;">
                                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Daftar Evaluasi</h4>
                            </div>
                            <div class="card-body table-responsive rounded-4 overflow-hidden">
                                <?php
                                // Ambil semua supplier dan kriteria
                                $supplier = [];
                                $sql = 'SELECT id_supplier, name FROM supplier ORDER BY id_supplier';
                                $result = $db->query($sql);
                                while ($row = $result->fetch_object()) {
                                    $supplier[$row->id_supplier] = $row->name;
                                }
                                $result->free();
                                $kriteria = [];
                                $sql = 'SELECT id_criteria, criteria FROM saw_criterias ORDER BY id_criteria';
                                $result = $db->query($sql);
                                while ($row = $result->fetch_object()) {
                                    $kriteria[$row->id_criteria] = $row->criteria;
                                }
                                $result->free();
                                // Ambil nilai evaluasi
                                $nilai = [];
                                $sql = 'SELECT id_supplier, id_criteria, value FROM saw_evaluations';
                                $result = $db->query($sql);
                                while ($row = $result->fetch_object()) {
                                    $nilai[$row->id_supplier][$row->id_criteria] = $row->value;
                                }
                                $result->free();
                                ?>
                                <table class="table table-bordered align-middle mb-0" style="background:#fff;">
                                    <thead style="background:#e0f2fe;">
                                        <tr style="font-size:1.05rem; color:#0369a1;">
                                            <th style="min-width:120px;">Supplier</th>
                                            <?php foreach ($kriteria as $idc => $namak): ?>
                                                <th class="text-center"><?= htmlspecialchars($namak) ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($supplier as $ida => $namaa): ?>
                                            <tr>
                                                <td class="fw-semibold text-dark" style="min-width:120px;white-space:nowrap;"><?= htmlspecialchars($namaa) ?></td>
                                                <?php foreach ($kriteria as $idc => $namak): ?>
                                                    <td class="text-center">
                                                        <?php
                                                        $v = isset($nilai[$ida][$idc]) ? $nilai[$ida][$idc] : '-';
                                                        if ($v !== '-') {
                                                            echo '<span class="badge bg-primary-subtle text-primary fw-bold" style="font-size:1rem;min-width:40px;">' . htmlspecialchars($v) . '</span>';
                                                        } else {
                                                            echo '<span class="text-secondary">-</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:#f8fbff;">
                            <div class="card-header bg-white border-0 rounded-top-4" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;">
                                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Hasil Nilai Preferensi (P)</h4>
                            </div>
                            <div class="card-body table-responsive rounded-4 overflow-hidden">
                                <?php
                                // --- Perhitungan SAW (normalisasi) ---
                                // Ambil bobot dan matriks normalisasi dari W.php dan R.php (agar identik dengan preferensi.php)
                                require_once "W.php";
                                require_once "R.php";
                                $P = array();
                                $m = count($W);
                                foreach ($R as $i => $r) {
                                    $supplier_obj = $db->query("SELECT name FROM supplier WHERE id_supplier=$i")->fetch_object();
                                    if ($supplier_obj) {
                                        for ($j = 0; $j < $m; $j++) {
                                            $P[$i] = (isset($P[$i]) ? $P[$i] : 0) + $r[$j] * $W[$j];
                                        }
                                        $P[$i . '_name'] = $supplier_obj->name;
                                    }
                                }
                                $sorted = array();
                                foreach ($P as $k => $v) {
                                    if (strpos($k, '_name') === false) $sorted[$k] = $v;
                                }
                                arsort($sorted);
                                $no = 0;
                                ?>
                                <table class="table table-hover align-middle mb-0" style="background:#fff;">
                                    <thead style="background:#e0f2fe;">
                                        <tr style="font-size:1.05rem; color:#0369a1;">
                                            <th class="text-center">No</th>
                                            <th>Supplier</th>
                                            <th>Nilai Preferensi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($sorted as $id => $nilai) {
                                            $name = isset($P[$id . '_name']) ? $P[$id . '_name'] : '';
                                            $no++;
                                            echo "<tr><td class='text-center fw-bold text-secondary'>".$no."</td><td class='fw-semibold text-dark'>".htmlspecialchars($name)."</td><td class='fw-semibold text-dark'>".round($nilai,4)."</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php require "layout/footer.php";?>
        </div>
    </div>
    <?php require "layout/js.php";?>
</body>
</html>