<?php
require "../include/conn.php";

$name = $_POST['name'];
$deskripsi = $_POST['deskripsi'];
$alamat = $_POST['alamat'];
$email = $_POST['email'];
$telepon = $_POST['telepon'];
$jenis_dokumen = $_POST['jenis_dokumen'];

// Upload foto
$foto = '';
if (!empty($_FILES['foto']['name'])) {
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto = 'uploads/' . basename($foto_name);
    move_uploaded_file($foto_tmp, "../" . $foto);
}

// Upload dokumen
$dokumen = '';
if (!empty($_FILES['dokumen']['name'])) {
    $dokumen_name = $_FILES['dokumen']['name'];
    $dokumen_tmp = $_FILES['dokumen']['tmp_name'];
    $dokumen_ext = strtolower(pathinfo($dokumen_name, PATHINFO_EXTENSION));
    
    // Validasi tipe file (PDF, DOC, DOCX)
    $allowed = array('pdf', 'doc', 'docx');
    if (in_array($dokumen_ext, $allowed)) {
        $dokumen = 'uploads/dokumen/' . basename($dokumen_name);
        if (!file_exists("../uploads/dokumen")) {
            mkdir("../uploads/dokumen", 0777, true);
        }
        move_uploaded_file($dokumen_tmp, "../" . $dokumen);
    }
}

$sql = "INSERT INTO supplier (name, deskripsi, alamat, email, telepon, foto, dokumen, jenis_dokumen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $db->prepare($sql);
$stmt->bind_param("ssssssss", $name, $deskripsi, $alamat, $email, $telepon, $foto, $dokumen, $jenis_dokumen);

if ($stmt->execute()) {
    echo "<script>alert('Data berhasil ditambahkan'); window.location='supplier.php';</script>";
} else {
    echo "<script>alert('Data gagal ditambahkan'); window.location='supplier.php';</script>";
}
