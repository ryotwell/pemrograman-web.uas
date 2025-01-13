<?php

use App\Models\Student;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\User;

function renderView(Response $response, string $view, array $data = []): Response {
    extract($data);
    ob_start();
    include __DIR__ . '/views/' . $view;
    $contents = ob_get_clean();
    $response->getBody()->write($contents);
    return $response;
}

function redirect(Response $response, string $path): Response {
    return $response->withHeader('Location', $path)->withStatus(302);
}

function validateRegistration(array $data): void {
    if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
        throw new \Exception('All fields are required');
    }
    
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new \Exception('Invalid email format');
    }
    
    if (strlen($data['password']) < 6) {
        throw new \Exception('Password must be at least 6 characters long');
    }
    
    if (User::where('email', $data['email'])->exists()) {
        throw new \Exception('Email already exists');
    }
}

function validateStudent(array $data, ?int $id = null): void {
    $required = ['name', 'email', 'phone_number', 'address', 'gender', 
                'date_of_birth', 'tahun_angkatan', 'semester', 'major_id'];
    
    foreach ($required as $field) {
        if (empty($data[$field])) {
            throw new \Exception('All fields are required');
        }
    }
    
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new \Exception('Invalid email format');
    }
    
    $query = Student::where('email', $data['email']);
    if ($id) {
        $query->where('id', '!=', $id);
    }
    
    if ($query->exists()) {
        throw new \Exception('Email already exists');
    }
}

function exportToExcel($students) {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    $headers = ['Name', 'Email', 'Phone Number', 'Address', 'Gender', 
                'Date of Birth', 'Tahun Angkatan', 'Semester', 'Major'];
    
    foreach (array_values($headers) as $i => $header) {
        $sheet->setCellValue(chr(65 + $i) . '1', $header);
    }
    
    $row = 2;
    foreach ($students as $student) {
        $sheet->setCellValue('A' . $row, $student->name);
        $sheet->setCellValue('B' . $row, $student->email);
        $sheet->setCellValue('C' . $row, $student->phone_number);
        $sheet->setCellValue('D' . $row, $student->address);
        $sheet->setCellValue('E' . $row, $student->gender);
        $sheet->setCellValue('F' . $row, $student->date_of_birth);
        $sheet->setCellValue('G' . $row, $student->tahun_angkatan);
        $sheet->setCellValue('H' . $row, $student->semester);
        $sheet->setCellValue('I' . $row, $student->major->name);
        $row++;
    }
    
    return downloadExcel($spreadsheet, 'students-' . date('Y-m-d') . '.xlsx');
}

function downloadExcel($spreadsheet, $filename) {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

function exportToPdf($students) {
    $html = generatePdfHtml($students);
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    
    return downloadPdf($dompdf, 'students-' . date('Y-m-d') . '.pdf');
}

function generatePdfHtml($students) {
    ob_start();
    ?>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; }
        th { background-color: #f4f4f4; }
    </style>
    <h2>Students List</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Major</th>
                <th>Semester</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student->name ?></td>
                <td><?= $student->email ?></td>
                <td><?= $student->phone_number ?></td>
                <td><?= $student->gender ?></td>
                <td><?= $student->major->name ?></td>
                <td><?= $student->semester ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}

function downloadPdf($dompdf, $filename) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    echo $dompdf->output();
    exit;
}

function exportToWord($students) {
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    
    $section->addText('Students List', ['bold' => true, 'size' => 16]);
    $section->addTextBreak(1);
    
    $table = $section->addTable(['borderSize' => 1, 'borderColor' => '000000']);
    
    // Add header row
    $table->addRow();
    $headers = ['Name', 'Email', 'Phone', 'Gender', 'Major', 'Semester'];
    foreach ($headers as $header) {
        $table->addCell(2000)->addText($header, ['bold' => true]);
    }
    
    // Add data rows
    foreach ($students as $student) {
        $table->addRow();
        $table->addCell(2000)->addText($student->name);
        $table->addCell(2000)->addText($student->email);
        $table->addCell(2000)->addText($student->phone_number);
        $table->addCell(2000)->addText($student->gender);
        $table->addCell(2000)->addText($student->major->name);
        $table->addCell(2000)->addText($student->semester);
    }
    
    $filename = 'students-' . date('Y-m-d') . '.docx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save('php://output');
    exit;
}