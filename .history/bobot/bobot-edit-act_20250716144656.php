<?php
require "../include/conn.php";

$id = $_POST['id_criteria'];
$criteria = $_POST['criteria'];
$weight = $_POST['weight'];
$attribute = $_POST['attribute'];

$stmt = $db->prepare("UPDATE saw_criterias SET criteria=?, weight=?, attribute=? WHERE id_criteria=?");
$stmt->bind_param("sdsi", $criteria, $weight, $attribute, $id);

if($stmt->execute()) {
    echo "<script>alert('Kriteria berhasil diupdate');window.location='bobot.php';</script>";
} else {
    echo "<script>alert('Kriteria gagal diupdate');window.location='bobot.php';</script>";
}
