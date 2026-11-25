<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * ProfileController
 *
 * Protected by AuthMiddleware ('auth.portal').
 * Provides authenticated user-specific pages:
 * - Personal Dashboard (/profile/dashboard)
 * - Profile & Account Settings (/profile/settings)
 * - Password Management (/profile/password)
 */
class ProfileController extends Controller
{
    /**
     * Show the authenticated user's personal dashboard (GET /profile/dashboard).
     */
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = User::with([
            'applications.jobPosting',
            'jobPostings.applications',
            'events',
        ])->findOrFail(Auth::id());

        return view('profile.dashboard', compact('user'));
    }

    /**
     * Show the authenticated user's profile & account settings page (GET /profile/settings).
     */
    public function settings()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('profile.settings', compact('user'));
    }

    /**
     * Update the authenticated user's own profile information (PUT /profile/settings).
     * Strictly prevents role self-escalation.
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'            => ['required', 'string', 'min:2', 'max:191'],
            'email'           => ['required', 'string', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user->id)],
            'department'      => ['required', 'string', 'max:191'],
            'graduation_year' => ['nullable', 'integer', 'min:1950', 'max:2035'],
            'current_company' => ['nullable', 'string', 'max:191'],
            'job_title'       => ['nullable', 'string', 'max:191'],
            'linkedin_url'    => ['nullable', 'url', 'max:255'],
            'skills'          => ['nullable', 'string', 'max:500'],
        ], [
            'name.required'       => 'Ad Soyad alanı zorunludur.',
            'email.required'      => 'E-posta adresi zorunludur.',
            'email.email'         => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique'        => 'Bu e-posta adresi başka bir hesap tarafından kullanılmaktadır.',
            'department.required' => 'Fakülte / Bölüm bilgisi zorunludur.',
            'linkedin_url.url'    => 'Geçerli bir LinkedIn bağlantısı (https://...) giriniz.',
        ]);

        // Never allow client-side role mutation from profile settings
        $user->update([
            'name'            => trim($validated['name']),
            'email'           => strtolower(trim($validated['email'])),
            'department'      => trim($validated['department']),
            'graduation_year' => $validated['graduation_year'] ?? null,
            'current_company' => !empty($validated['current_company']) ? trim($validated['current_company']) : null,
            'job_title'       => !empty($validated['job_title']) ? trim($validated['job_title']) : null,
            'linkedin_url'    => !empty($validated['linkedin_url']) ? trim($validated['linkedin_url']) : null,
            'skills'          => $validated['skills'] ?? null,
        ]);

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile settings updated successfully.',
                'data'    => $user->fresh()->toArray(),
            ]);
        }

        return redirect('/profile/settings')
            ->with('success', 'Profil ayarlarınız başarıyla güncellendi.');
    }

    /**
     * Update the authenticated user's password (PATCH /profile/password).
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $rules = [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if (!empty($user->password)) {
            $rules['current_password'] = ['required', 'string'];
        }

        $validated = $request->validate($rules, [
            'current_password.required' => 'Mevcut şifrenizi girmeniz gerekmektedir.',
            'password.required'         => 'Yeni şifre alanı zorunludur.',
            'password.min'              => 'Yeni şifreniz en az 8 karakter olmalıdır.',
            'password.confirmed'        => 'Yeni şifre ve şifre tekrarı birbiriyle eşleşmiyor.',
        ]);

        if (!empty($user->password) && !Hash::check($validated['current_password'], $user->password)) {
            if ($request->wantsJson() || $request->isJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect.',
                ], 422);
            }

            return back()->with('error', 'Girdiğiniz mevcut şifre hatalı.');
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully.',
            ]);
        }

        return redirect('/profile/settings')
            ->with('success', 'Hesap şifreniz güvenli bir şekilde güncellendi.');
    }
}
