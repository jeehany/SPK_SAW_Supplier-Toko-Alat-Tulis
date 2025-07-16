<?php
require "../include/conn.php";

$id = $_POST['id_supplier'];
$name = $_POST['name'];
$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$telepon = isset($_POST['telepon']) ? $_POST['telepon'] : '';
$jenis_dokumen = isset($_POST['jenis_dokumen']) ? $_POST['jenis_dokumen'] : '';

// Get old data
$sql = "SELECT foto, dokumen FROM supplier WHERE id_supplier='$id'";
$result = $db->query($sql);
$old = $result->fetch_object();

// Handle foto upload
$foto = $old->foto;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    // Delete old photo if exists
    if ($old->foto && file_exists("../" . $old->foto)) {
        unlink("../" . $old->foto);
    }
    // Upload new photo
    $targetDir = '../images/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('foto_', true) . '.' . $ext;
    $targetFile = $targetDir . $filename;
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
        $foto = "images/$filename";
    }
}

// Handle dokumen upload  
$dokumen = $old->dokumen;
if (isset($_FILES['dokumen']) && $_FILES['dokumen']['error'] == 0) {
    // Delete old document if exists
    if ($old->dokumen && file_exists("../" . $old->dokumen)) {
        unlink("../" . $old->dokumen);
    }
    // Upload new document
    $dokumen_ext = strtolower(pathinfo($_FILES['dokumen']['name'], PATHINFO_EXTENSION));
    $allowed = array('pdf', 'doc', 'docx');
    if (in_array($dokumen_ext, $allowed)) {
        $targetDir = '../uploads/dokumen/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $filename = 'doc_' . uniqid() . '.' . $dokumen_ext;
        $targetFile = $targetDir . $filename;
        if (move_uploaded_file($_FILES['dokumen']['tmp_name'], $targetFile)) {
            $dokumen = "uploads/dokumen/$filename";
        }
    }
}

$stmt = $db->prepare("UPDATE supplier SET name=?, deskripsi=?, alamat=?, email=?, telepon=?, foto=?, dokumen=?, jenis_dokumen=? WHERE id_supplier=?");
$stmt->bind_param("ssssssssi", $name, $deskripsi, $alamat, $email, $telepon, $foto, $dokumen, $jenis_dokumen, $id);

if($stmt->execute()) {
    echo "<script>alert('Data berhasil diupdate');window.location='supplier.php';</script>";
} else {
    echo "<script>alert('Data gagal diupdate');window.location='supplier.php';</script>";
}
