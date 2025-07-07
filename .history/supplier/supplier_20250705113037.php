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
                <h3 class="fw-bold mb-2" style="color:#0369a1;letter-spacing:1px;">Supplier</h3>
            </div>
            <div class="page-content" style="background:#f8fbff;border-radius:2rem 0 0 0;box-shadow:0 2px 8px 0 #e0e7ef;min-height:calc(100vh - 2rem);padding-bottom:2rem;">
                <section class="row justify-content-center">
                    <div class="col-12">
                        <div class="card border-0 rounded-4 shadow-sm" style="background:#f8fbff;">
                            <div class="card-header bg-white border-0 rounded-top-4 d-flex align-items-center justify-content-between" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;">
                                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Tabel Supplier</h4>
                                <button type="button" class="btn btn-primary btn-lg px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#inlineForm" style="border-radius: 2rem; font-size: 1rem; background:#38b6ff; border:none;">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Supplier
                                </button>
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-0">
                                    <p class="card-text text-dark mb-3" style="font-size:1.05rem;">
                                        Data supplier yang akan dievaluasi:
                                    </p>
                                </div>
                                <div class="table-responsive rounded-4 overflow-hidden">
                                    <table class="table table-hover align-middle mb-0" style="background:#fff;">
                                        <caption class="text-secondary ps-2">Tabel Supplier S<sub>i</sub></caption>
                                        <thead style="background:#e0f2fe;">
                                            <tr style="font-size:1.05rem; color:#0369a1;">
                                                <!--<th class="text-center" style="width:48px;">No</th>-->
                                                <th colspan="2" class="ps-3">Nama Supplier</th>
                                                <th class="text-center" style="width:150px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql = 'SELECT id_supplier, name, foto FROM supplier ORDER BY id_supplier ASC';
                                        $result = $db->query($sql);
                                        while ($row = $result->fetch_object()) {
                                            echo "<tr>\n";
                                            // Kolom foto supplier
                                            echo "    <td class='text-center' style='width:56px;'>";
                                            if (!empty($row->foto)) {
                                                $imgPath = (strpos($row->foto, 'http') === 0) ? $row->foto : '../' . ltrim($row->foto, '/');
                                                echo "<img src='" . htmlspecialchars($imgPath) . "' alt='Foto' style='width:48px;height:48px;object-fit:cover;border-radius:50%;border:2px solid #38b6ff;background:#e0f2fe;display:block;margin:auto;'> ";
                                            } else {
                                                echo "<span class='d-inline-block rounded-circle bg-light border border-2 border-sky' style='width:48px;height:48px;background:#e0f2fe;'></span> ";
                                            }
                                            echo "</td>\n";
                                            // Kolom nama supplier
                                            echo "    <td class='ps-2 fw-semibold text-dark' style='font-size:1.05rem;'>" . htmlspecialchars($row->name) . "</td>\n";
                                            // Kolom aksi
                                            echo "    <td class='text-center'>";
                                            echo "<div class='d-inline-flex gap-2'>";
                                            echo "<a href='./supplier-edit.php?id=" . $row->id_supplier . "' class='btn btn-outline-primary btn-sm px-3 py-1 fw-bold d-inline-flex align-items-center' style='border-radius:1.5rem;background:#f0f9ff;border:1.5px solid #38b6ff;color:#0369a1;gap:4px;'><i class='bi bi-pencil-square' style='margin-right:0;'></i><span>Edit</span></a>";
                                            echo "<a href='./supplier-hapus.php?id=" . $row->id_supplier . "' class='btn btn-outline-danger btn-sm px-3 py-1 fw-bold d-inline-flex align-items-center' style='border-radius:1.5rem;background:#f0f9ff;border:1.5px solid #e11d48;color:#e11d48;gap:4px;' onclick=\"return confirm('Yakin ingin menghapus data ini?')\"><i class='bi bi-trash' style='margin-right:0;'></i><span>Hapus</span></a>";
                                            echo "</div>";
                                            echo "    </td>\n";
                                            echo "  </tr>\n";
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
            <?php require "../layout/footer.php";?>
        </div>
    </div>
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content rounded-4 border-0" style="background:#f8fbff;">
                <div class="modal-header bg-white border-bottom-0 rounded-top-4" style="background:#e0f2fe;">
                    <h4 class="modal-title fw-bold text-primary" id="myModalLabel33"><i class="bi bi-person-plus me-2"></i>Tambah Supplier</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body py-4 px-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Nama Supplier</label>
                            <input type="text" name="name" placeholder="Nama Supplier..." class="form-control form-control-lg rounded-3" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Foto</label>
                            <input type="file" name="foto" accept="image/*" class="form-control form-control-lg rounded-3" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4 border-0 py-3 px-4">
                        <button type="button" class="btn btn-outline-secondary btn-lg px-4 fw-bold" data-bs-dismiss="modal" style="border-radius:1.5rem;background:#f0f9ff;">
                            <i class="bi bi-x-lg me-1"></i>Batal
                        </button>
                        <button type="submit" name="submit" class="btn btn-primary btn-lg px-4 fw-bold ms-2" style="border-radius:1.5rem;background:#38b6ff;border:none;">
                            <i class="bi bi-check2-circle me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
        $name = trim($_POST['name']);
        $foto = '';
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $newName = '../uploads/alt_' . time() . '_' . rand(100,999) . '.' . $ext;
            if (!is_dir('../uploads')) mkdir('../uploads');
            move_uploaded_file($_FILES['foto']['tmp_name'], $newName);
            $foto = ltrim($newName, './');
        }
        if ($name && $foto) {
            $stmt = $db->prepare('INSERT INTO supplier (name, foto) VALUES (?, ?)');
            $stmt->bind_param('ss', $name, $foto);
            $stmt->execute();
            echo '<script>location.href="supplier.php";</script>';
            exit;
        } else {
            echo '<div class="alert alert-danger m-4">Nama dan foto supplier wajib diisi!</div>';
        }
    }
    require "../layout/js.php";
    ?>
</body>
</html>