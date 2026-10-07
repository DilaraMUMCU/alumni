<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\SwaggerSpec;
use App\Models\User;

// Gelen isteği format farketmeksizin (JSON, raw, urlencoded, form-data) ayrıştıran yardımcı fonksiyon
$getPayload = function (Request $request) {
    $payload = [];

    // 1. Raw body (JSON veya query-string formatı)
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

// 1. & 5. Adım: Base URL (/) -> Temporary Main Page
Route::get('/', function () {
    return view('welcome');
});

// 2. Adım: Sabit hello rotası
Route::get('/hello', function () {
    return 'Hello, world!';
});

// 3. Adım: Dinamik isim parametreli hello rotası
Route::get('/hello/{name}', function ($name) {
    return 'Hello, ' . ucfirst($name) . '!';
});

// 4. Adım: İki sayıyı toplayan dinamik sum rotası
Route::get('/sum/{number1}/{number2}', function ($number1, $number2) {
    return (string) ($number1 + $number2);
});

// 6. Adım: Temporary About Page
Route::get('/about', function () {
    return view('about');
});

// 7. Adım: JSON Health Check rotası
Route::get('/api/health', function () {
    return response()->json([
        'status' => 'ok',
    ]);
});

// 8. Adım: POST /api/users (Yeni kullanıcı ekleme - User Model üzerinden)
Route::post('/api/users', function (Request $request) use ($getPayload) {
    $payload = $getPayload($request);
    $user = User::create($payload);

    return response()->json([
        'success' => true,
        'message' => 'User created successfully and stored without database (via Cache)!',
        'data' => $user->toArray(),
    ], 201);
});

// 9. Adım: GET /api/users (Tüm kullanıcıları listeleme - User Model üzerinden)
Route::get('/api/users', function () {
    $users = User::all();

    return response()->json([
        'success' => true,
        'count' => count($users),
        'data' => array_map(fn($u) => $u->toArray(), $users),
    ]);
});

// 10. Adım: PUT /api/users/{id} (Kullanıcı bilgilerini tam değiştirme - RFC standartlarına uygun)
Route::put('/api/users/{id}', function (Request $request, $id) use ($getPayload) {
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => "User with ID {$id} not found.",
        ], 404);
    }

    $payload = $getPayload($request);
    $user->update($payload, fullReplacement: true);

    return response()->json([
        'success' => true,
        'message' => "User {$id} replaced successfully (PUT: omitted fields reset to null)",
        'data'    => $user->toArray(),
    ]);
});

// 11. Adım: PATCH /api/users/{id} (Kullanıcı bilgilerini kısmi güncelleme)
Route::patch('/api/users/{id}', function (Request $request, $id) use ($getPayload) {
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => "User with ID {$id} not found.",
        ], 404);
    }

    $payload = $getPayload($request);
    $user->update($payload, fullReplacement: false);

    return response()->json([
        'success' => true,
        'message' => "User {$id} partially updated successfully (PATCH, in cache)",
        'data' => $user->toArray(),
    ]);
});

// Tekil kullanıcı getirme: GET /api/users/{id}
Route::get('/api/users/{id}', function ($id) {
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => "User with ID {$id} not found.",
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $user->toArray(),
    ]);
});

// Kullanıcı listesini sıfırlama
Route::post('/api/users/reset', function () {
    $users = User::reset();
    return response()->json([
        'success' => true,
        'message' => 'Users list reset to initial defaults.',
        'data' => array_map(fn($u) => $u->toArray(), $users),
    ]);
});

// 12. Adım: DELETE /api/users/{id} (Kullanıcı silme)
Route::delete('/api/users/{id}', function ($id) {
    $deletedUser = User::deleteById($id);

    if (!$deletedUser) {
        return response()->json([
            'success' => false,
            'message' => "User with ID {$id} not found.",
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => "User {$id} deleted successfully.",
        'deleted_user' => $deletedUser->toArray(),
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