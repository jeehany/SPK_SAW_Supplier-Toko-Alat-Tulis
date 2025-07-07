<?php
require "../include/conn.php";
$id = $_GET['id'];
// Ambil nama file foto
$foto = '';
$q = $db->query("SELECT foto FROM supplier WHERE id_supplier='$id'");
if ($row = $q->fetch_object()) {
    $foto = $row->foto;
}
// Hapus file foto jika ada dan bukan url eksternal
if (!empty($foto) && strpos($foto, 'http') !== 0) {
    $fotoPath = '../' . ltrim($foto, '/');
    if (file_exists($fotoPath)) {
        unlink($fotoPath);
    }
}
// Hapus data supplier
mysqli_query($db, "DELETE FROM supplier WHERE id_supplier='$id'");
header("location:./supplier.php");
