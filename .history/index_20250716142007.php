<!DOCTYPE html>
<html lang="en">
    <?php 
    require "layout/head.php";
    require "include/conn.php";
    ?>

    <body style="background: #e0f2fe;">
        <div id="app" style="min-height:100vh;">
            <?php require "layout/sidebar.php";?>
            <div id="main" style="background:transparent;min-height:100vh;">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>
                <div class="page-heading">
                    <h3>Dashboard</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4>Statistik Data</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Total Alternatif
                                    $alt = $db->query('SELECT COUNT(*) as total FROM saw_alternatives');
                                    $alt_total = $alt->fetch_object()->total;
                                    // Total Kriteria
                                    $krit = $db->query('SELECT COUNT(*) as total FROM saw_criterias');
                                    $krit_total = $krit->fetch_object()->total;
                                    // Total Evaluasi
                                    $eval = $db->query('SELECT COUNT(*) as total FROM saw_evaluations');
                                    $eval_total = $eval->fetch_object()->total;
                                    // Total User
                                    $user = $db->query('SELECT COUNT(*) as total FROM saw_users');
                                    $user_total = $user->fetch_object()->total;
                                    ?>
                                    <div class="row text-center">
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 bg-light rounded shadow-sm">
                                                <h5 class="mb-1">Alternatif</h5>
                                                <h2 class="text-primary"><?=$alt_total?></h2>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 bg-light rounded shadow-sm">
                                                <h5 class="mb-1">Kriteria</h5>
                                                <h2 class="text-success"><?=$krit_total?></h2>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 bg-light rounded shadow-sm">
                                                <h5 class="mb-1">Evaluasi</h5>
                                                <h2 class="text-warning"><?=$eval_total?></h2>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 bg-light rounded shadow-sm">
                                                <h5 class="mb-1">User</h5>
                                                <h2 class="text-danger"><?=$user_total?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4>Daftar Alternatif</h4>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Foto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $alt = $db->query('SELECT name, foto FROM saw_alternatives');
                                            $no = 1;
                                            while ($a = $alt->fetch_object()): ?>
                                                <tr>
                                                    <td><?=$no++?></td>
                                                    <td><?=htmlspecialchars($a->name)?></td>
                                                    <td><?php if ($a->foto): ?><img src="<?=$a->foto?>" style="width:40px;height:40px;object-fit:cover;border-radius:50%;"><?php endif; ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4>Daftar Kriteria</h4>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Kriteria</th>
                                                <th>Bobot</th>
                                                <th>Atribut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $krit = $db->query('SELECT criteria, weight, attribute FROM saw_criterias');
                                            $no = 1;
                                            while ($k = $krit->fetch_object()): ?>
                                                <tr>
                                                    <td><?=$no++?></td>
                                                    <td><?=htmlspecialchars($k->criteria)?></td>
                                                    <td><?=$k->weight?></td>
                                                    <td><?=$k->attribute?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4>Daftar Evaluasi</h4>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Alternatif</th>
                                                <th>Kriteria</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $eval = $db->query('SELECT a.id_alternative, b.name, a.id_criteria, c.criteria, a.value FROM saw_evaluations a JOIN saw_alternatives b ON a.id_alternative = b.id_alternative JOIN saw_criterias c ON a.id_criteria = c.id_criteria ORDER BY a.id_alternative, a.id_criteria');
                                            while ($e = $eval->fetch_object()): ?>
                                                <tr>
                                                    <td><?=htmlspecialchars($e->name)?></td>
                                                    <td><?=htmlspecialchars($e->criteria)?></td>
                                                    <td><?=$e->value?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4>Hasil Nilai Preferensi (P)</h4>
                                </div>
                                <div class="card-body table-responsive">
                                    <?php
                                    // Hitung preferensi sederhana (tanpa normalisasi ulang)
                                    $W = array();
                                    $wq = $db->query('SELECT weight FROM saw_criterias ORDER BY id_criteria');
                                    while ($w = $wq->fetch_object()) $W[] = $w->weight;
                                    $R = array();
                                    $alt = $db->query('SELECT id_alternative FROM saw_alternatives ORDER BY id_alternative');
                                    while ($a = $alt->fetch_object()) {
                                        $r = array();
                                        $eval = $db->query('SELECT value FROM saw_evaluations WHERE id_alternative='.$a->id_alternative.' ORDER BY id_criteria');
                                        while ($v = $eval->fetch_object()) $r[] = $v->value;
                                        $R[$a->id_alternative] = $r;
                                    }
                                    ?>
                                    <table class="table table-bordered table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Alternatif</th>
                                                <th>Nilai Preferensi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($R as $id => $r) {
                                                $P = 0;
                                                foreach ($r as $i => $val) {
                                                    $P += $val * ($W[$i] ?? 0);
                                                }
                                                $alt = $db->query('SELECT name FROM saw_alternatives WHERE id_alternative='.$id);
                                                $name = $alt->fetch_object()->name;
                                                echo "<tr><td>".htmlspecialchars($name)."</td><td>".round($P,2)."</td></tr>";
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