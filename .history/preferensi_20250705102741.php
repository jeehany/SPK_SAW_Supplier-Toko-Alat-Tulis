<!DOCTYPE html>
<html lang="en">
<?php require "layout/head.php"; require "include/conn.php"; require "W.php"; require "R.php"; ?>
<body style="background:linear-gradient(135deg,#e0f2fe 0%,#f0f9ff 100%); min-height:100vh;">
  <div id="app">
    <?php require "layout/navbar.php";?>
        <div id="" style="padding:0;min-height:100vh;background:#f4faff;" class="m-5 p-5 rounded rounded-4 shadow-sm">
      <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
          <i class="bi bi-justify fs-3"></i>
        </a>
      </header>
      <div class="page-heading mb-4">
        <h3 class="fw-bold mb-2" style="color:#0369a1;letter-spacing:1px;">Nilai Preferensi (P)</h3>
      </div>
            <div class="page-content" style="background:#f8fbff;border-radius:2rem 0 0 0;box-shadow:0 2px 8px 0 #e0e7ef;min-height:calc(100vh - 2rem);padding-bottom:2rem;">
        <section class="row justify-content-center">
                    <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm" style="background:#f8fbff;">
              <div class="card-header bg-white border-0 rounded-top-4" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;">
                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Tabel Nilai Preferensi Supplier (P)</h4>
              </div>
              <div class="card-content">
                <div class="card-body pb-0">
                  <p class="card-text text-dark mb-3" style="font-size:1.05rem;">
                    Nilai preferensi (P) merupakan penjumlahan dari perkalian matriks ternormalisasi R dengan vektor bobot W.
                  </p>
                </div>
                <div class="table-responsive rounded-4 overflow-hidden mb-4">
                  <table class="table table-hover align-middle mb-0" style="background:#fff;">
                    <caption class="text-secondary ps-2">Nilai Preferensi Supplier (P)</caption>
                    <thead style="background:#e0f2fe;">
                      <tr style="font-size:1.05rem; color:#0369a1;">
                        <th class="text-center">No</th>
                        <th>Supplier</th>
                        <th>Hasil</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $P = array();
                    $m = count($W);
                    $no = 0;
                    foreach ($R as $i => $r) {
                        // Pastikan hanya supplier yang ada di tabel supplier
                        $supplier = $db->query("SELECT name FROM supplier WHERE id_supplier=$i")->fetch_object();
                        if ($supplier) {
                            for ($j = 0; $j < $m; $j++) {
                                $P[$i] = (isset($P[$i]) ? $P[$i] : 0) + $r[$j] * $W[$j];
                            }
                            echo "<tr>";
                            echo "<td class='text-center fw-bold text-secondary'>" . (++$no) . "</td>";
                            echo "<td class='fw-semibold text-dark'>S{$i} - {$supplier->name}</td>";
                            echo "<td class='fw-semibold text-primary'>" . round($P[$i], 4) . "</td>";
                            echo "</tr>\n";
                        }
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
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
