<?php
require "../include/conn.php";
// Ambil id_supplier dari parameter GET
$id = $_GET['id'];
$sql = "SELECT * FROM supplier WHERE id_supplier = '$id' ";
$result = $db->query($sql);
$row = $result->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">
<?php require "../layout/head.php";?>
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
                <h3 class="fw-bold mb-2" style="color:#0369a1;letter-spacing:1px;">Edit Supplier</h3>
            </div>
            <div class="page-content" style="background:#f8fbff;border-radius:2rem 0 0 0;box-shadow:0 2px 8px 0 #e0e7ef;min-height:calc(100vh - 2rem);padding-bottom:2rem;">
                <section class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-7">
                        <div class="card border-0 rounded-4 shadow-sm" style="background:#f8fbff;">
                            <div class="card-header bg-white border-0 rounded-top-4" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;">
                                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Edit Data Supplier</h4>
                            </div>
                            <div class="card-body py-4 px-4">
                                <form action="supplier-edit-act.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id_supplier" value="<?=$row['id_supplier'];?>">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-semibold text-dark">Nama Supplier</label>
                                        <input type="text" class="form-control form-control-lg rounded-3" id="name" name="name" value="<?=htmlspecialchars($row['name']);?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label fw-semibold text-dark">Deskripsi</label>
                                        <textarea class="form-control form-control-lg rounded-3" id="deskripsi" name="deskripsi" rows="2" placeholder="Deskripsi singkat perusahaan..."><?=htmlspecialchars($row['deskripsi'] ?? '')?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label fw-semibold text-dark">Alamat</label>
                                        <input type="text" class="form-control form-control-lg rounded-3" id="alamat" name="alamat" value="<?=htmlspecialchars($row['alamat'] ?? '')?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold text-dark">Email</label>
                                        <input type="email" class="form-control form-control-lg rounded-3" id="email" name="email" value="<?=htmlspecialchars($row['email'] ?? '')?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="telepon" class="form-label fw-semibold text-dark">Telepon</label>
                                        <input type="text" class="form-control form-control-lg rounded-3" id="telepon" name="telepon" value="<?=htmlspecialchars($row['telepon'] ?? '')?>">
                                    </div>                                        <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">Foto</label>
                                        <?php if (!empty($row['foto'])): ?>
                                            <div class="d-flex align-items-center justify-content-center mb-2">
                                                <?php $imgPath = (strpos($row['foto'], 'http') === 0) ? $row['foto'] : '../' . $row['foto']; ?>
                                                <img src="<?=$imgPath;?>" alt="Foto" style="width:70px;height:70px;object-fit:cover;border-radius:50%;border:2.5px solid #38b6ff;background:#e0f2fe;box-shadow:0 2px 8px #bae6fd;">
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" name="foto" accept="image/*" class="form-control form-control-lg rounded-3">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jenis_dokumen" class="form-label fw-semibold text-dark">Jenis Dokumen</label>
                                        <select class="form-select form-select-lg rounded-3" id="jenis_dokumen" name="jenis_dokumen">
                                            <option value="">- Pilih Jenis Dokumen -</option>
                                            <option value="MoU" <?=$row['jenis_dokumen']=='MoU'?'selected':''?>>MoU (Memorandum of Understanding)</option>
                                            <option value="Kontrak" <?=$row['jenis_dokumen']=='Kontrak'?'selected':''?>>Kontrak Kerja Sama</option>
                                            <option value="Proposal" <?=$row['jenis_dokumen']=='Proposal'?'selected':''?>>Proposal Penawaran</option>
                                            <option value="Legal" <?=$row['jenis_dokumen']=='Legal'?'selected':''?>>Dokumen Legal</option>
                                            <option value="Lainnya" <?=$row['jenis_dokumen']=='Lainnya'?'selected':''?>>Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-dark">Upload Dokumen</label>
                                        <?php if (!empty($row['dokumen'])): ?>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-file-earmark-text me-2 fs-4"></i>
                                                <a href="../<?=$row['dokumen']?>" target="_blank" class="text-decoration-none">
                                                    Lihat dokumen saat ini
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" name="dokumen" accept=".pdf,.doc,.docx" class="form-control form-control-lg rounded-3">
                                        <small class="text-muted">Format yang didukung: PDF, DOC, DOCX. Kosongkan jika tidak ingin mengubah dokumen.</small>
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