<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * RegisterController
 *
 * Handles first-time user registration and assigns the 'unverified' onboarding role.
 * Note: Account verification completion workflow is intentionally deferred;
 * newly registered users remain in the 'unverified' state upon creation.
 */
class RegisterController extends Controller
{
    /**
     * Display the public registration page (GET /register).
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/users/' . Auth::id())
                ->with('warning', 'Zaten aktif bir oturumunuz bulunmaktadır.');
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming first-time registration request (POST /register, POST /api/register).
     */
    public function register(Request $request)
    {
        $this->ensureUsersSchemaReady();

        $isApiRequest = $request->wantsJson() || $request->isJson() || $request->is('api/*');

        $rules = [
            'name'            => ['required', 'string', 'min:2', 'max:191'],
            'email'           => ['required', 'string', 'email', 'max:191', 'unique:users,email'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            'department'      => ['required', 'string', 'max:191'],
            'graduation_year' => ['nullable', 'integer', 'min:1950', 'max:2035'],
            'current_company' => ['nullable', 'string', 'max:191'],
            'job_title'       => ['nullable', 'string', 'max:191'],
            'linkedin_url'    => ['nullable', 'url', 'max:255'],
            'skills'          => ['nullable'],
            'terms'           => $isApiRequest ? ['sometimes', 'accepted'] : ['accepted'],
        ];

        $messages = [
            'name.required'           => 'Ad Soyad alanı zorunludur.',
            'name.min'                => 'Ad Soyad en az 2 karakter olmalıdır.',
            'email.required'          => 'E-posta adresi zorunludur.',
            'email.email'             => 'Lütfen geçerli bir e-posta adresi giriniz.',
            'email.unique'            => 'Bu e-posta adresi ile sistemde zaten kayıtlı bir hesap bulunmaktadır.',
            'password.required'       => 'Şifre alanı zorunludur.',
            'password.min'            => 'Şifreniz güvenlik gereği en az 8 karakter olmalıdır.',
            'password.confirmed'      => 'Girdiğiniz şifre ve şifre tekrarı birbiriyle eşleşmiyor.',
            'department.required'     => 'Fakülte / Bölüm bilgisi zorunludur.',
            'graduation_year.integer' => 'Mezuniyet yılı geçerli bir yıl olmalıdır.',
            'graduation_year.min'     => 'Mezuniyet yılı 1950 veya sonrası olmalıdır.',
            'graduation_year.max'     => 'Mezuniyet yılı 2035 veya öncesi olmalıdır.',
            'linkedin_url.url'        => 'Lütfen geçerli bir LinkedIn profil bağlantısı (https://...) giriniz.',
            'terms.accepted'          => 'Kayıt olabilmek için üyelik koşullarını ve aydınlatma metnini onaylamanız gerekmektedir.',
        ];

        $validated = $request->validate($rules, $messages);

        // Strictly force 'unverified' role for all first-time registrations
        $user = User::create([
            'name'            => trim($validated['name']),
            'email'           => strtolower(trim($validated['email'])),
            'password'        => Hash::make($validated['password']),
            'role'            => User::ROLE_UNVERIFIED,
            'department'      => trim($validated['department']),
            'graduation_year' => $validated['graduation_year'] ?? null,
            'current_company' => !empty($validated['current_company']) ? trim($validated['current_company']) : null,
            'job_title'       => !empty($validated['job_title']) ? trim($validated['job_title']) : null,
            'linkedin_url'    => !empty($validated['linkedin_url']) ? trim($validated['linkedin_url']) : null,
            'skills'          => $validated['skills'] ?? null,
        ]);

        if ($isApiRequest) {
            return response()->json([
                'success'             => true,
                'source'              => 'RegisterController@register',
                'message'             => 'Account registered successfully with unverified status. Verification is pending.',
                'assigned_role'       => User::ROLE_UNVERIFIED,
                'verification_status' => 'pending',
                'data'                => $user->toArray(),
            ], 201);
        }

        Auth::login($user);
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        return redirect('/users/' . $user->id)->with(
            'success',
            "Kaydınız başarıyla oluşturuldu! İlk kez kayıt olduğunuz için hesabınız 'Doğrulanmamış' statüsüyle tanımlandı."
        );
    }

    /**
     * Display the public login page (GET /login).
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect('/admin')
                : redirect('/users/' . Auth::id());
        }

        return view('auth.login');
    }

    /**
     * Authenticate an existing user (POST /login).
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'E-posta adresi zorunludur.',
            'email.email'       => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre alanı zorunludur.',
        ]);

        $email = strtolower(trim($credentials['email']));

        if (Auth::attempt(['email' => $email, 'password' => $credentials['password']])) {
            if ($request->hasSession()) {
                $request->session()->regenerate();
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();

            if ($request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful.',
                    'role'    => $user->role,
                    'data'    => $user->toArray(),
                ]);
            }

            if ($user->isAdmin()) {
                return redirect()->intended('/admin')
                    ->with('success', "Hoş geldiniz, {$user->name}. Yönetim paneline yönlendirildiniz.");
            }

            return redirect()->intended('/users/' . $user->id)
                ->with('success', "Hoş geldiniz, {$user->name}.");
        }

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'E-posta adresi veya şifre hatalı.');
    }

    /**
     * Log out the authenticated user session (POST /logout).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully.',
            ]);
        }

        return redirect('/')->with('success', 'Oturumunuz güvenli bir şekilde sonlandırıldı.');
    }

    /**
     * Idempotently ensure the 'users' table has password, remember_token,
     * and the 'unverified' role enum option even before manual migration runs.
     */
    protected function ensureUsersSchemaReady(): void
    {
        try {
            if (!Schema::hasTable('users')) {
                return;
            }

            $needsPassword = !Schema::hasColumn('users', 'password');
            $needsRemember = !Schema::hasColumn('users', 'remember_token');

            if ($needsPassword || $needsRemember) {
                Schema::table('users', function (Blueprint $table) use ($needsPassword, $needsRemember) {
                    if ($needsPassword) {
                        $table->string('password')->nullable()->after('email');
                    }
                    if ($needsRemember) {
                        $table->rememberToken()->after('skills');
                    }
                });
            }

            if (DB::getDriverName() === 'mysql') {
                $col = DB::selectOne("SHOW COLUMNS FROM `users` LIKE 'role'");
                $type = strtolower((string) ($col->Type ?? ''));
                if ($type !== '' && !str_contains($type, 'unverified')) {
                    DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('unverified', 'student', 'alumni', 'academics', 'admin') NOT NULL DEFAULT 'unverified'");
                }
            }
        } catch (\Throwable $e) {
            // Allow normal validation / query lifecycle to proceed if DB is read-only or mock
        }
    }
}
