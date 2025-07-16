<!DOCTYPE html>
<html lang="en">
    <?php
require "layout/head.php";
require "include/conn.php";
?>

    <body>
        <div id="app">
            <?php require "layout/sidebar.php";?>
            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>
                <div class="page-heading">
                    <h3>Alternatif</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-header">
                                    <h4 class="card-title">Tabel Alternatif</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <p class="card-text">
                                            Data-data mengenai kandidat yang akan dievaluasi di representasikan dalam
                                            tabel berikut:
                                        </p>
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm m-2" data-bs-toggle="modal"
                                        data-bs-target="#inlineForm">
                                        Tambah Alternatif
                                    </button>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <caption>
                                                Tabel Alternatif A<sub>i</sub>
                                            </caption>
                                            <tr>
                                                <th>No</th>
                                                <th colspan="2">Name</th>
                                            </tr>
                                            <?php
$sql = 'SELECT id_alternative, name, foto FROM saw_alternatives';
$result = $db->query($sql);
$i = 0;
$i = 0;
while ($row = $result->fetch_object()) {
    echo "<tr>\n";
    echo "    <td class='right'>" . (++$i) . "</td>\n";
    echo "    <td class='center'>";
    if (!empty($row->foto)) {
        echo "<img src='" . htmlspecialchars($row->foto) . "' alt='Foto' style='width:40px;height:40px;object-fit:cover;border-radius:50%;margin-right:8px;'> ";
    }
    echo htmlspecialchars($row->name) . "</td>\n";
    echo "    <td>";
    echo "<a href='alternatif-edit.php?id=" . $row->id_alternative . "' class='btn btn-edit btn-sm'>Edit</a> ";
    echo "<a href='alternatif-hapus.php?id=" . $row->id_alternative . "' class='btn btn-delete btn-sm' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>";
    echo "    </td>\n";
    echo "  </tr>\n";
}
$result->free();
?>
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
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Login Form </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="alternatif-simpan.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <label>Name: </label>
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Nama Kandidat..." class="form-control"
                                    required>
                            </div>
                            <label>Foto: </label>
                            <div class="form-group">
                                <input type="file" name="foto" accept="image/*" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" name="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php require "layout/js.php";?>
    </body>

</html>