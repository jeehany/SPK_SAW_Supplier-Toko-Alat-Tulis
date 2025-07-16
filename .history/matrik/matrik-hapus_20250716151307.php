<?php
require "../include/conn.php";

$id = $_GET['id'];

// Hapus semua nilai untuk supplier ini
$stmt = $db->prepare("DELETE FROM saw_evaluations WHERE id_supplier = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()) {
    echo "<script>alert('Data nilai supplier berhasil dihapus');window.location='matrik.php';</script>";
} else {
    echo "<script>alert('Data nilai supplier gagal dihapus');window.location='matrik.php';</script>";
}
