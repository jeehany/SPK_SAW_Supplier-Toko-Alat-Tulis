<?php
require "../include/conn.php";

$criteria = $_POST['criteria'];
$weight = $_POST['weight'];
$attribute = $_POST['attribute'];

// Dapatkan id_criteria terakhir
$sql = "SELECT MAX(id_criteria) as max_id FROM saw_criterias";
$result = $db->query($sql);
$row = $result->fetch_object();
$next_id = ($row->max_id !== null) ? $row->max_id + 1 : 1;

// Insert dengan id_criteria baru
$stmt = $db->prepare("INSERT INTO saw_criterias (id_criteria, criteria, weight, attribute) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isds", $next_id, $criteria, $weight, $attribute);

if($stmt->execute()) {
    echo "<script>alert('Kriteria berhasil ditambahkan');window.location='bobot.php';</script>";
} else {
    echo "<script>alert('Kriteria gagal ditambahkan');window.location='bobot.php';</script>";
}
