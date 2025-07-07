<?php
require "../include/conn.php";
$id = $_POST['id_supplier'];
$name = $_POST['name'];
$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$telepon = isset($_POST['telepon']) ? $_POST['telepon'] : '';
$foto_sql = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $targetDir = '../images/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('foto_', true) . '.' . $ext;
    $targetFile = $targetDir . $filename;
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
        // Simpan ke database hanya 'images/filename.jpg' tanpa '../'
        $foto_sql = ", foto='images/$filename'";
    }
}
$sql = "UPDATE supplier SET name='$name', deskripsi='$deskripsi', alamat='$alamat', email='$email', telepon='$telepon'" . $foto_sql . " WHERE id_supplier='$id'";
$result = $db->query($sql);
header("location:./supplier.php");
