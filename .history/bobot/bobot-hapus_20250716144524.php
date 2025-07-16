<?php
require "../include/conn.php";

$id = $_GET['id'];

// Cek apakah kriteria ini digunakan di tabel keputusan
$sql = "SELECT COUNT(*) as total FROM saw_evaluations WHERE id_criteria = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_object();

if($row->total > 0) {
    echo "<script>alert('Kriteria ini tidak dapat dihapus karena masih digunakan dalam penilaian');window.location='bobot.php';</script>";
    exit;
}

// Jika aman, hapus kriteria
$stmt = $db->prepare("DELETE FROM saw_criterias WHERE id_criteria = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()) {
    echo "<script>alert('Kriteria berhasil dihapus');window.location='bobot.php';</script>";
} else {
    echo "<script>alert('Kriteria gagal dihapus');window.location='bobot.php';</script>";
}
