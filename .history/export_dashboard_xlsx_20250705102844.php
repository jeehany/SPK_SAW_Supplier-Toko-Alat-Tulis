<?php
require 'include/conn.php';
require_once __DIR__ . '/assets/vendors/autoload.php'; // Composer autoload for PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Dashboard Data');

// Supplier
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama Kandidat');
$sheet->setCellValue('C1', 'Foto');
$sql = 'SELECT name, foto FROM saw_alternatives';
$result = $db->query($sql);
$i = 1;
$rowNum = 2;
while ($row = $result->fetch_object()) {
    $sheet->setCellValue('A'.$rowNum, $i);
    $sheet->setCellValue('B'.$rowNum, $row->name);
    $sheet->setCellValue('C'.$rowNum, $row->foto);
    $i++;
    $rowNum++;
}

// Kriteria
$rowNum += 2;
$sheet->setCellValue('A'.$rowNum, 'No');
$sheet->setCellValue('B'.$rowNum, 'Kriteria');
$sheet->setCellValue('C'.$rowNum, 'Bobot');
$sheet->setCellValue('D'.$rowNum, 'Atribut');
$sql = 'SELECT criteria, weight, attribute FROM saw_criterias';
$result = $db->query($sql);
$i = 1;
$rowNum++;
while ($row = $result->fetch_object()) {
    $sheet->setCellValue('A'.$rowNum, $i);
    $sheet->setCellValue('B'.$rowNum, $row->criteria);
    $sheet->setCellValue('C'.$rowNum, $row->weight);
    $sheet->setCellValue('D'.$rowNum, $row->attribute);
    $i++;
    $rowNum++;
}

// Evaluasi
$rowNum += 2;
$sheet->setCellValue('A'.$rowNum, 'Supplier');
$sheet->setCellValue('B'.$rowNum, 'Kriteria');
$sheet->setCellValue('C'.$rowNum, 'Nilai');
$sql = 'SELECT b.name, c.criteria, a.value FROM saw_evaluations a JOIN saw_alternatives b ON a.id_alternative = b.id_alternative JOIN saw_criterias c ON a.id_criteria = c.id_criteria ORDER BY a.id_alternative, a.id_criteria';
$result = $db->query($sql);
$rowNum++;
while ($row = $result->fetch_object()) {
    $sheet->setCellValue('A'.$rowNum, $row->name);
    $sheet->setCellValue('B'.$rowNum, $row->criteria);
    $sheet->setCellValue('C'.$rowNum, $row->value);
    $rowNum++;
}

// Output
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="dashboard_data.xlsx"');
header('Cache-Control: max-age=0');
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
