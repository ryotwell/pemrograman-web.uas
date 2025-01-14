<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Models\Major;
use App\Models\Student;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request; 
use App\Models\User;

$app->get('/', function (Request $request, Response $response) {
    return redirect($response, '/login');
});

// Dashboard routes
$app->get('/dashboard', function (Request $request, Response $response) {
    $data = [
        'students_count' => Student::count(),
        'users_count' => User::count(),
        'majors_count' => Major::count(),
        'students' => Student::with('major')->latest()->get(),
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

$app->get('/students/export/word', function (Request $request, Response $response) {
    return exportToWord(Student::with('major')->get());
})->add(new AuthMiddleware);

// Migration route
$app->get('/migrate', function (Request $request, Response $response) {
    \App\Migration::run();
    $response->getBody()->write("Migration successful.");

    return $response;
});