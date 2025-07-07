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
                        </div>
                        <!-- Daftar Supplier, Kriteria, Evaluasi, dst -->
                        <!-- ...existing code tabel supplier, kriteria, evaluasi... -->
                        <!-- Tabel preferensi SAW -->
                        <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:#f8fbff;">
                            <div class="card-header bg-white border-0 rounded-top-4" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;">
                                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Hasil Nilai Preferensi (P)</h4>
                            </div>
                            <div class="card-body table-responsive rounded-4 overflow-hidden">
                                <?php
                                // --- Perhitungan SAW (normalisasi) ---
                                // Ambil bobot
                                $W = array();
                                $wq = $db->query('SELECT weight FROM saw_criterias ORDER BY id_criteria');
                                while ($w = $wq->fetch_object()) $W[] = $w->weight;
                                // Ambil supplier dan kriteria
                                $supplier = [];
                                $sql = 'SELECT id_supplier, name, deskripsi, alamat, email, telepon, foto FROM supplier ORDER BY id_supplier';
                                $result = $db->query($sql);
                                while ($row = $result->fetch_object()) {
                                    $supplier[$row->id_supplier] = [
                                        'name' => $row->name,
                                        'deskripsi' => $row->deskripsi,
                                        'alamat' => $row->alamat,
                                        'email' => $row->email,
                                        'telepon' => $row->telepon,
                                        'foto' => $row->foto
                                    ];
                                }
                                $result->free();
                                $kriteria = [];
                                $sql = 'SELECT id_criteria, attribute FROM saw_criterias ORDER BY id_criteria';
                                $result = $db->query($sql);
                                while ($row = $result->fetch_object()) {
                                    $kriteria[$row->id_criteria] = $row->attribute;
                                }
                                $result->free();
                                // Ambil semua nilai asli untuk normalisasi
                                $X = array();
                                $sql = "SELECT id_supplier, id_criteria, value FROM saw_evaluations ORDER BY id_criteria, id_supplier";
                                $result = $db->query($sql);
                                while ($row = $result->fetch_object()) {
                                    $X[$row->id_criteria][$row->id_supplier] = $row->value;
                                }
                                // Normalisasi sesuai metode SAW
                                $R = array();
                                $supplier_ids = array_keys($supplier);
                                $kriteria_ids = array_keys($kriteria);
                                foreach ($supplier_ids as $id_supplier) {
                                    $R[$id_supplier] = array();
                                    foreach ($kriteria_ids as $idx => $id_criteria) {
                                        $values = isset($X[$id_criteria]) ? $X[$id_criteria] : array();
                                        $v = isset($X[$id_criteria][$id_supplier]) ? $X[$id_criteria][$id_supplier] : 0;
                                        $attr = $kriteria[$id_criteria];
                                        if ($attr == 'benefit') {
                                            $max = !empty($values) ? max($values) : 1;
                                            $norm = $max ? $v / $max : 0;
                                        } else {
                                            $min = !empty($values) ? min($values) : 1;
                                            $norm = $v ? $min / $v : 0;
                                        }
                                        $R[$id_supplier][$idx] = $norm;
                                    }
                                }
                                // Hitung preferensi
                                $P = array();
                                $m = count($W);
                                foreach ($R as $i => $r) {
                                    $P[$i] = 0;
                                    for ($j = 0; $j < $m; $j++) {
                                        $P[$i] += $r[$j] * $W[$j];
                                    }
                                    $P[$i . '_data'] = $supplier[$i];
                                }
                                // Urutkan dari yang tertinggi
                                $sorted = array();
                                foreach ($P as $k => $v) {
                                    if (strpos($k, '_data') === false) $sorted[$k] = $v;
                                }
                                arsort($sorted);
                                ?>
                                <table class="table table-hover align-middle mb-0" style="background:#fff;">
                                    <thead style="background:#e0f2fe;">
                                        <tr style="font-size:1.05rem; color:#0369a1;">
                                            <th>Foto</th>
                                            <th>Supplier</th>
                                            <th>Deskripsi</th>
                                            <th>Alamat</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                            <th>Nilai Preferensi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($sorted as $id => $nilai) {
                                            $data = isset($P[$id . '_data']) ? $P[$id . '_data'] : null;
                                            if (!$data) continue;
                                            $foto = !empty($data['foto']) && file_exists('uploads/' . $data['foto']) ? 'uploads/' . $data['foto'] : 'images/foto-default.png';
                                            echo "<tr>";
                                            echo "<td><img src='".htmlspecialchars($foto)."' alt='foto' style='width:48px;height:48px;object-fit:cover;border-radius:8px;'></td>";
                                            echo "<td class='fw-semibold text-dark'>".htmlspecialchars($data['name'])."</td>";
                                            echo "<td>".htmlspecialchars($data['deskripsi'])."</td>";
                                            echo "<td>".htmlspecialchars($data['alamat'])."</td>";
                                            echo "<td>".htmlspecialchars($data['email'])."</td>";
                                            echo "<td>".htmlspecialchars($data['telepon'])."</td>";
                                            echo "<td class='fw-semibold text-dark'>".round($nilai,4)."</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- ...existing code tabel/tampilan dashboard lainnya... -->
                    </div>
                </section>
            </div>
            <?php require "layout/footer.php";?>
        </div>
    </div>
    <?php require "layout/js.php";?>
</body>
</html>