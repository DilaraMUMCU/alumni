<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\SwaggerSpec;

// Gelen iste�i format farketmeksizin (JSON, raw, urlencoded, form-data) ayr��t�ran yard�mc� fonksiyon
$getPayload = function (Request $request) {
    $payload = [];

    // 1. Raw body (JSON veya query-string format�)
    $raw = $request->getContent();
    if (!empty($raw)) {
        $json = json_decode($raw, true);
        if (is_array($json)) {
            $payload = array_merge($payload, $json);
        } else {
            parse_str($raw, $parsed);
            if (is_array($parsed)) {
                $payload = array_merge($payload, $parsed);
            }
        }
    }

    // 2. php://input fallback
    if (empty($payload)) {
        $phpInput = file_get_contents('php://input');
        if (!empty($phpInput)) {
            $json = json_decode($phpInput, true);
            if (is_array($json)) {
                $payload = array_merge($payload, $json);
            } else {
                parse_str($phpInput, $parsed);
                if (is_array($parsed)) {
                    $payload = array_merge($payload, $parsed);
                }
            }
        }
    }

    // 3. Laravel Request verileri (parsed JSON + query + form params)
    $all = $request->all();
    if (!empty($all)) {
        $payload = array_merge($payload, $all);
    }

    return $payload;
};

// Ba�lang�� �rnek verileri
$getInitialUsers = function () {
    return [
        [
            'id' => 1,
            'name' => 'Dilara Mumcu',
            'email' => 'dilara@alumni.edu',
            'role' => 'alumni',
            'department' => 'Computer Engineering',
            'graduation_year' => 2024,
            'current_company' => 'Google',
            'job_title' => 'Software Engineer',
            'linkedin_url' => 'https://linkedin.com/in/dilaramumcu',
            'skills' => ['PHP', 'Laravel', 'Docker', 'MySQL'],
            'created_at' => '2024-06-15T10:00:00Z',
        ],
        [
            'id' => 2,
            'name' => 'Caner Y�lmaz',
            'email' => 'caner@alumni.edu',
            'role' => 'alumni',
            'department' => 'Industrial Engineering',
            'graduation_year' => 2023,
            'current_company' => 'Amazon',
            'job_title' => 'Product Manager',
            'linkedin_url' => 'https://linkedin.com/in/caneryilmaz',
            'skills' => ['Agile', 'Scrum', 'Product Strategy', 'Data Analysis'],
            'created_at' => '2023-07-20T14:30:00Z',
        ],
        [
            'id' => 3,
            'name' => 'Elif Demir',
            'email' => 'elif@student.edu',
            'role' => 'student',
            'department' => 'Computer Engineering',
            'graduation_year' => 2026,
            'current_company' => 'Tech Intern at Microsoft',
            'job_title' => 'Intern',
            'linkedin_url' => 'https://linkedin.com/in/elifdemir',
            'skills' => ['Python', 'Machine Learning', 'Git'],
            'created_at' => '2025-09-01T09:15:00Z',
        ],
    ];
};

// 1. & 5. Ad�m: Base URL (/) -> Temporary Main Page
Route::get('/', function () {
    return view('welcome');
});

// 2. Ad�m: Sabit hello rotas�
Route::get('/hello', function () {
    return 'Hello, world!';
});

// 3. Ad�m: Dinamik isim parametreli hello rotas�
Route::get('/hello/{name}', function ($name) {
    return 'Hello, ' . ucfirst($name) . '!';
});

// 4. Ad�m: �ki say�y� toplayan dinamik sum rotas�
Route::get('/sum/{number1}/{number2}', function ($number1, $number2) {
    return (string) ($number1 + $number2);
});

// 6. Ad�m: Temporary About Page
Route::get('/about', function () {
    return view('about');
});

// 7. Ad�m: JSON Health Check rotas�
Route::get('/api/health', function () {
    return response()->json([
        'status' => 'ok',
    ]);
});

// 8. Ad�m: POST /api/users (Yeni kullan�c� ekleme)
Route::post('/api/users', function (Request $request) use ($getInitialUsers, $getPayload) {
    $users = Cache::get('alumni_users', $getInitialUsers());
    $payload = $getPayload($request);

    $nextId = count($users) > 0 ? (max(array_column($users, 'id')) + 1) : 1;

    $newUser = [
        'id' => $nextId,
        'name' => $payload['name'] ?? 'Dilara Mumcu',
        'email' => $payload['email'] ?? 'dilara@alumni.edu',
        'role' => $payload['role'] ?? 'alumni',
        'department' => $payload['department'] ?? 'Computer Engineering',
        'graduation_year' => isset($payload['graduation_year']) ? (int) $payload['graduation_year'] : 2024,
        'current_company' => $payload['current_company'] ?? 'Google',
        'job_title' => $payload['job_title'] ?? 'Software Engineer',
        'linkedin_url' => $payload['linkedin_url'] ?? 'https://linkedin.com/in/dilaramumcu',
        'skills' => $payload['skills'] ?? ['PHP', 'Laravel', 'Docker', 'MySQL'],
        'created_at' => now()->toIso8601String(),
    ];

    $users[] = $newUser;
    Cache::forever('alumni_users', $users);

    return response()->json([
        'success' => true,
        'message' => 'User created successfully and stored without database (via Cache)!',
        'data' => $newUser,
    ], 201);
});

// 9. Ad�m: GET /api/users (T�m kullan�c�lar� listeleme)
Route::get('/api/users', function () use ($getInitialUsers) {
    $users = Cache::get('alumni_users', $getInitialUsers());

    return response()->json([
        'success' => true,
        'count' => count($users),
        'data' => $users,
    ]);
});

// 10. Adım: PUT /api/users/{id} (Kullanıcı bilgilerini tam değiştirme - RFC standartlarına uygun)
Route::put('/api/users/{id}', function (Request $request, $id) use ($getInitialUsers, $getPayload) {
    $users = Cache::get('alumni_users', $getInitialUsers());
    $foundIndex = null;

    foreach ($users as $index => $u) {
        if ((string)$u['id'] === (string)$id) {
            $foundIndex = $index;
            break;
        }
    }

    if ($foundIndex === null) {
        return response()->json([
            'success' => false,
            'message' => "User with ID {$id} not found.",
        ], 404);
    }

    $payload = $getPayload($request);

    // REST standartlarına göre PUT tam bir değiştirmedir (full replacement).
    // İstekte gönderilmeyen veya boş bırakılan tüm alanlar sıfırlanır (null olur).
    $users[$foundIndex] = [
        'id'              => (int) $id,
        'name'            => $payload['name'] ?? null,
        'email'           => $payload['email'] ?? null,
        'role'            => $payload['role'] ?? null,
        'department'      => $payload['department'] ?? null,
        'graduation_year' => (isset($payload['graduation_year']) && $payload['graduation_year'] !== '') ? (int) $payload['graduation_year'] : null,
        'current_company' => $payload['current_company'] ?? null,
        'job_title'       => $payload['job_title'] ?? null,
        'linkedin_url'    => $payload['linkedin_url'] ?? null,
        'skills'          => (isset($payload['skills']) && is_array($payload['skills'])) ? $payload['skills'] : null,
        'created_at'      => $users[$foundIndex]['created_at'] ?? now()->toIso8601String(),
        'updated_at'      => now()->toIso8601String(),
    ];

    Cache::forever('alumni_users', $users);

    return response()->json([
        'success' => true,
        'message' => "User {$id} replaced successfully (PUT: omitted fields reset to null)",
        'data'    => $users[$foundIndex],
    ]);
});

// 11. Ad�m: PATCH /api/users/{id} (Kullan�c� bilgilerini k�smi g�ncelleme)
Route::patch('/api/users/{id}', function (Request $request, $id) use ($getInitialUsers, $getPayload) {
    $users = Cache::get('alumni_users', $getInitialUsers());
    $foundIndex = null;

    foreach ($users as $index => $u) {
        if ((string)$u['id'] === (string)$id) {
            $foundIndex = $index;
            break;
        }
    }

    if ($foundIndex === null) {
        return response()->json([
            'success' => false,
            'message' => "User with ID {$id} not found.",
        ], 404);
    }

    $payload = $getPayload($request);

    // Gelen her bir alan� dinamik olarak g�ncelle
    foreach ($payload as $key => $val) {
        if ($key !== 'id' && $key !== 'created_at' && $key !== '_method' && $key !== '_token') {
            if ($key === 'graduation_year') {
                $val = (int) $val;
            }
            $users[$foundIndex][$key] = $val;
        }
    }

    $users[$foundIndex]['updated_at'] = now()->toIso8601String();

    Cache::forever('alumni_users', $users);

    return response()->json([
        'success' => true,
        'message' => "User {$id} partially updated successfully (PATCH, in cache)",
        'data' => $users[$foundIndex],
    ]);
});

// Tekil kullan�c� getirme: GET /api/users/{id}
Route::get('/api/users/{id}', function ($id) use ($getInitialUsers) {
    $users = Cache::get('alumni_users', $getInitialUsers());

    foreach ($users as $u) {
        if ((string)$u['id'] === (string)$id) {
            return response()->json([
                'success' => true,
                'data' => $u,
            ]);
        }
    }

    return response()->json([
        'success' => false,
        'message' => "User with ID {$id} not found.",
    ], 404);
});

// Kullan�c� listesini s�f�rlama
Route::post('/api/users/reset', function () use ($getInitialUsers) {
    Cache::forget('alumni_users');
    return response()->json([
        'success' => true,
        'message' => 'Users list reset to initial defaults.',
        'data' => $getInitialUsers(),
    ]);
});

// 12. Adım: DELETE /api/users/{id} (Kullanıcı silme)
Route::delete('/api/users/{id}', function ($id) use ($getInitialUsers) {
    $users = Cache::get('alumni_users', $getInitialUsers());
    $foundIndex = null;

    foreach ($users as $index => $u) {
        if ((string)$u['id'] === (string)$id) {
            $foundIndex = $index;
            break;
        }
    }

    if ($foundIndex === null) {
        return response()->json([
            'success' => false,
            'message' => "User with ID {$id} not found.",
        ], 404);
    }

    $deletedUser = $users[$foundIndex];
    array_splice($users, $foundIndex, 1);
    Cache::forever('alumni_users', $users);

    return response()->json([
        'success' => true,
        'message' => "User {$id} deleted successfully.",
        'deleted_user' => $deletedUser,
    ]);
});

// 13. Adım: GET /api/swagger.json (Saf OpenAPI 3.0 JSON Spesifikasyonu)
Route::get('/api/swagger.json', function () {
    return response()->json(SwaggerSpec::get(), 200, [
        'Content-Type' => 'application/json; charset=utf-8'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
});

// 14. Adım: GET /api/swagger (Tarayıcıda Swagger UI, Postman ve API istemcilerinde OpenAPI JSON)
Route::get('/api/swagger', function (Request $request) {
    $format = $request->query('format');
    $accept = $request->header('Accept', '');

    // Tarayıcı istekleri 'text/html' içerir.
    // Postman ve API araçları ise default olarak '*/*' veya 'application/json' gönderir.
    $isBrowser = str_contains($accept, 'text/html') && $format !== 'json';

    if ($format === 'html' || $isBrowser) {
        return view('swagger', ['spec' => SwaggerSpec::get()]);
    }

    return response()->json(SwaggerSpec::get(), 200, [
        'Content-Type' => 'application/json; charset=utf-8'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
});