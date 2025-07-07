<?php
require 'include/conn.php';
header('Content-Type: text/html; charset=utf-8');
echo '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Laporan Dashboard SPK SAW</title>';
echo '<link rel="stylesheet" href="assets/css/bootstrap.css">';
echo '<link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">';
echo '<style>body{background:#f8fbff;font-family:Nunito,sans-serif;padding:2rem;}h2{color:#0369a1;}table{background:#fff;}th,td{font-size:1rem;}th{background:#e0f2fe;color:#0369a1;}tr:nth-child(even){background:#f0f9ff;}</style>';
echo '</head><body>';
echo '<h2 class="mb-4"><i class="bi bi-bar-chart-fill me-2"></i>Laporan Data Dashboard SPK SAW</h2>';

// Supplier
echo '<h4 class="mt-4 mb-2">Daftar Supplier</h4>';
echo '<table class="table table-bordered mb-4"><thead><tr><th>No</th><th>Nama Supplier</th><th>Deskripsi</th><th>Alamat</th><th>Email</th><th>Telepon</th><th>Foto</th></tr></thead><tbody>';
$sql = 'SELECT name, deskripsi, alamat, email, telepon, foto FROM supplier';
$result = $db->query($sql);
$i = 0;
while ($row = $result->fetch_object()) {
    echo '<tr>';
    echo '<td>' . (++$i) . '</td>';
    echo '<td>' . htmlspecialchars($row->name ?? '') . '</td>';
    echo '<td>' . nl2br(htmlspecialchars($row->deskripsi ?? '')) . '</td>';
    echo '<td>' . htmlspecialchars($row->alamat ?? '') . '</td>';
    echo '<td>' . htmlspecialchars($row->email ?? '') . '</td>';
    echo '<td>' . htmlspecialchars($row->telepon ?? '') . '</td>';
    echo '<td>';
    if (!empty($row->foto)) {
        echo '<img src="' . htmlspecialchars($row->foto) . '" alt="Foto" style="width:36px;height:36px;object-fit:cover;border-radius:50%;border:1.5px solid #38b6ff;background:#e0f2fe;">';
    } else {
        echo '-';
    }
    echo '</td>';
    echo '</tr>';
}
echo '</tbody></table>';

// Kriteria
echo '<h4 class="mt-4 mb-2">Daftar Kriteria</h4>';
echo '<table class="table table-bordered mb-4"><thead><tr><th>No</th><th>Kriteria</th><th>Bobot</th><th>Atribut</th></tr></thead><tbody>';
$sql = 'SELECT criteria, weight, attribute FROM saw_criterias';
$result = $db->query($sql);
$i = 0;
while ($row = $result->fetch_object()) {
    echo '<tr>';
    echo '<td>' . (++$i) . '</td>';
    echo '<td>' . htmlspecialchars($row->criteria) . '</td>';
    echo '<td>' . $row->weight . '</td>';
    echo '<td>' . $row->attribute . '</td>';
    echo '</tr>';
}
echo '</tbody></table>';

// Evaluasi
// Matriks Evaluasi Interaktif

echo '<h4 class="mt-4 mb-2">Daftar Evaluasi</h4>';
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
echo '<table class="table table-bordered align-middle mb-4"><thead><tr><th style="min-width:120px;">Supplier</th>';
foreach ($kriteria as $idc => $namak) {
    echo '<th class="text-center">' . htmlspecialchars($namak) . '</th>';
}
echo '</tr></thead><tbody>';
foreach ($supplier as $ida => $namaa) {
    echo '<tr>';
    echo '<td class="fw-semibold text-dark" style="min-width:120px;white-space:nowrap;">S' . $ida . ' - ' . htmlspecialchars($namaa) . '</td>';
    foreach ($kriteria as $idc => $namak) {
        $v = isset($nilai[$ida][$idc]) ? $nilai[$ida][$idc] : '-';
        if ($v !== '-') {
            echo '<td class="text-center"><span class="badge bg-primary-subtle text-primary fw-bold" style="font-size:1rem;min-width:40px;">' . htmlspecialchars($v) . '</span></td>';
        } else {
            echo '<td class="text-center text-secondary">-</td>';
        }
    }
    echo '</tr>';
}
echo '</tbody></table>';

// Preferensi (menggunakan matriks ternormalisasi seperti preferensi.php)
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
echo '<h4 class="mt-4 mb-2">Hasil Nilai Preferensi Supplier (P)</h4>';
echo '<table class="table table-bordered mb-4"><thead><tr><th>No</th><th>Supplier</th><th>Nilai Preferensi</th></tr></thead><tbody>';
$no = 0;
foreach ($sorted as $id => $nilai) {
    $name = isset($P[$id . '_name']) ? $P[$id . '_name'] : '';
    $no++;
    echo '<tr><td class="text-center">' . $no . '</td><td>' . htmlspecialchars($name) . '</td><td>' . round($nilai,4) . '</td></tr>';
}
echo '</tbody></table>';
echo '<div class="mt-5 text-end text-secondary small">Laporan dihasilkan pada: ' . date('d-m-Y H:i') . '</div>';
echo '</body></html>';
