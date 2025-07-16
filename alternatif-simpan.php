<?php
require "include/conn.php";

$name = $_POST['name'];
$foto = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $targetDir = 'images/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('foto_', true) . '.' . $ext;
    $targetFile = $targetDir . $filename;
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
        $foto = $targetFile;
    }
}
$sql = "INSERT INTO saw_alternatives (name, foto) VALUES ('$name', " . ($foto ? "'$foto'" : "NULL") . ")";

if ($db->query($sql) === true) {
    header("location:./alternatif.php");
} else {
    echo "Error: " . $sql . "<br>" . $db->error;
}

