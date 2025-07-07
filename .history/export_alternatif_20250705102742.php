<?php
require 'include/conn.php';
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=supplier.csv');
$output = fopen('php://output', 'w');
fputcsv($output, ['No', 'Nama Kandidat', 'Foto']);
$sql = 'SELECT name, foto FROM saw_alternatives';
$result = $db->query($sql);
$i = 0;
while ($row = $result->fetch_object()) {
    fputcsv($output, [++$i, $row->name, $row->foto]);
}
fclose($output);
exit;
