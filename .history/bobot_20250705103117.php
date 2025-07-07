<!DOCTYPE html>
<html lang="en">
<?php require "layout/head.php"; require "include/conn.php"; ?>
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
        <h3 class="fw-bold mb-2" style="color:#0369a1;letter-spacing:1px;">Bobot Kriteria Supplier</h3>
      </div>
            <div class="page-content" style="background:#f8fbff;border-radius:2rem 0 0 0;box-shadow:0 2px 8px 0 #e0e7ef;min-height:calc(100vh - 2rem);padding-bottom:2rem;">
        <section class="row justify-content-center">
                    <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm" style="background:#f8fbff;">
              <div class="card-header bg-white border-0 rounded-top-4 d-flex align-items-center" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;">
                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Tabel Bobot Kriteria Penilaian Supplier</h4>
              </div>
              <div class="card-content">
                <div class="card-body pb-0">
                  <p class="card-text text-dark mb-3" style="font-size:1.05rem;">
                    Pengambil keputusan memberi bobot preferensi dari setiap kriteria penilaian supplier alat tulis, dengan masing-masing jenisnya (<span style='color:#0ea5e9'>benefit</span> atau <span style='color:#0ea5e9'>cost</span>):
                  </p>
                </div>
                <div class="table-responsive rounded-4 overflow-hidden">
                  <table class="table table-hover align-middle mb-0" style="background:#fff;">
                    <caption class="text-secondary ps-2">Tabel Kriteria Penilaian Supplier (C<sub>i</sub>)</caption>
                    <thead style="background:#e0f2fe;">
                      <tr style="font-size:1.05rem; color:#0369a1;">
                        <th class="text-center">No</th>
                        <th>Simbol</th>
                        <th>Kriteria</th>
                        <th>Bobot</th>
                        <th>Atribut</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = 'SELECT id_criteria,criteria,weight,attribute FROM saw_criterias';
                      $result = $db->query($sql);
                      $i = 0;
                      while ($row = $result->fetch_object()) {
                          echo "<tr>\n";
                          echo "<td class='text-center fw-bold text-secondary'>" . (++$i) . "</td>\n";
                          echo "<td class='fw-bold text-primary'>C{$i}</td>\n";
                          echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($row->criteria) . "</td>\n";
                          echo "<td class='fw-semibold text-dark'>" . htmlspecialchars($row->weight) . "</td>\n";
                          echo "<td class='fw-semibold' style='color:#0ea5e9;'>" . htmlspecialchars($row->attribute) . "</td>\n";
                          echo "<td class='text-center'><a href='bobot-edit.php?id={$row->id_criteria}' class='btn btn-outline-primary btn-sm px-3 py-1 fw-bold' style='border-radius:1.5rem;background:#f0f9ff;border:1.5px solid #38b6ff;color:#0369a1;'><i class='bi bi-pencil-square me-1'></i>Edit</a></td>\n";
                          echo "</tr>\n";
                      }
                      $result->free();
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