<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Models\Major;
use App\Models\Student;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request; 
use App\Models\User;

// Dashboard routes
$app->get('/dashboard', function (Request $request, Response $response) {
    $data = [
        'students_count' => Student::count(),
        'users_count' => User::count(),
        'majors_count' => Major::count(),
        'students' => Student::with('major')->get(),
    ];
    return renderView($response, 'dashboard.php', $data);
})->add(new AuthMiddleware);

// Authentication routes
$app->get('/login', function (Request $request, Response $response) {
    return renderView($response, 'auth/login.php');
})->add(new GuestMiddleware);

$app->post('/login', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user = User::where('email', $data['email'])->first();
    
    if ($user && password_verify($data['password'], $user->password)) {
        $_SESSION['user'] = $user->id;
        return redirect($response, '/dashboard');
    }
    
    return $response->getBody()->write("Invalid credentials.");
})->add(new GuestMiddleware);

$app->get('/register', function (Request $request, Response $response) {
    return renderView($response, 'auth/register.php');
})->add(new GuestMiddleware);

$app->post('/register', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    validateRegistration($data);
    
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => password_hash($data['password'], PASSWORD_DEFAULT)
    ]);
    
    return redirect($response, '/login');
})->add(new GuestMiddleware);

$app->get('/logout', function (Request $request, Response $response) {
    session_destroy();
    return redirect($response, '/login');
});

// Student routes
$app->get('/students/{id}/edit', function (Request $request, Response $response, $args) {
    $student = Student::findOrFail($args['id']);
    $majors = Major::all();
    
    return renderView($response, 'students/edit.php', [
        'student' => $student,
        'majors' => $majors
    ]);
})->add(new AuthMiddleware);

$app->post('/students/{id}/edit', function (Request $request, Response $response, $args) {
    $student = Student::findOrFail($args['id']);
    $data = $request->getParsedBody();
    
    validateStudent($data, $args['id']);
    $student->update($data);
    
    return redirect($response, '/dashboard');
})->add(new AuthMiddleware);

$app->get('/students/{id}/delete', function (Request $request, Response $response, $args) {
    $student = Student::findOrFail($args['id']);
    $student->delete();
    
    return redirect($response, '/dashboard');
})->add(new AuthMiddleware);

$app->get('/students/create', function (Request $request, Response $response) {
    return renderView($response, 'students/create.php', [
        'majors' => Major::all()
    ]);
})->add(new AuthMiddleware);

$app->post('/students/create', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    validateStudent($data);
    
    Student::create($data);
    return redirect($response, '/dashboard');
})->add(new AuthMiddleware);

// Export routes
$app->get('/students/export/excel', function (Request $request, Response $response) {
    return exportToExcel(Student::with('major')->get());
})->add(new AuthMiddleware);

$app->get('/students/export/pdf', function (Request $request, Response $response) {
    return exportToPdf(Student::with('major')->get());
})->add(new AuthMiddleware);

// Migration route
$app->get('/migrate', function (Request $request, Response $response) {
    \App\Migration::run();
    return $response->getBody()->write("Migration successful.");
});

// Helper functions
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