<?php
require "../include/conn.php";

$criteria = $_POST['criteria'];
$weight = $_POST['weight'];
$attribute = $_POST['attribute'];

$stmt = $db->prepare("INSERT INTO saw_criterias (criteria, weight, attribute) VALUES (?, ?, ?)");
$stmt->bind_param("sds", $criteria, $weight, $attribute);

if($stmt->execute()) {
    echo "<script>alert('Kriteria berhasil ditambahkan');window.location='bobot.php';</script>";
} else {
    echo "<script>alert('Kriteria gagal ditambahkan');window.location='bobot.php';</script>";
}
