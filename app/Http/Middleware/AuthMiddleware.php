<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * AuthMiddleware
 *
 * Enforces session authentication and Role-Based Access Control (RBAC)
 * across Web and API routes according to ddd.md Section 4.
 *
 * Supported Roles:
 * - guests (unauthenticated)
 * - unverified (newly registered, pending verification)
 * - student
 * - alumni
 * - academics (also accepts legacy 'academician')
 * - admin
 *
 * Usage examples:
 * - ->middleware('auth.portal')                 // Requires any authenticated user
 * - ->middleware('role:student,alumni')         // e.g. Job applications
 * - ->middleware('role:academics,admin')        // e.g. Event creation
 * - ->middleware('role:alumni,admin')           // e.g. Job posting publishing
 * - ->middleware('role:admin')                  // Admin-only operations
 */
class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Optional list of allowed roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $isApiRequest = $request->expectsJson() || $request->isJson() || $request->is('api/*');

        // 1. Authentication Check (Blocks 'guests')
        if (!Auth::check()) {
            if ($isApiRequest) {
                return response()->json([
                    'success' => false,
                    'error'   => 'UNAUTHENTICATED',
                    'message' => 'Authentication is required to access this resource.',
                ], 401);
            }

            return redirect()->guest('/login')
                ->with('warning', 'Bu sayfaya erişmek için lütfen önce giriş yapınız.');
        }

        // If no specific roles were requested, authentication alone is sufficient
        if (empty($roles)) {
            return $next($request);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $userRole = $this->normalizeRole($user->role);
        $allowedRoles = array_map(fn (string $role) => $this->normalizeRole($role), $roles);
        $requiredLabels = array_values(array_unique(array_map(fn (string $r) => User::formatRoleLabel($r), $allowedRoles)));
        $currentLabel = User::formatRoleLabel($userRole);

        // 2. Unverified Account Guard
        if ($userRole === User::ROLE_UNVERIFIED && !in_array(User::ROLE_UNVERIFIED, $allowedRoles, true)) {
            $reason = 'Hesabınız şu anda Doğrulanmamış (unverified) statüsündedir. Bu işlemi gerçekleştirebilmek için hesap doğrulama aşamasının tamamlanması ve uygun rolün (' . implode(', ', $requiredLabels) . ') tanımlanması gerekmektedir.';

            if ($isApiRequest) {
                return response()->json([
                    'success'        => false,
                    'error'          => 'ACCOUNT_UNVERIFIED',
                    'current_role'   => User::ROLE_UNVERIFIED,
                    'required_roles' => $allowedRoles,
                    'message'        => $reason,
                ], 403);
            }

            return response()->view('errors.403', [
                'isUnverified'       => true,
                'title'              => 'Hesabınız Henüz Doğrulanmamış',
                'reason'             => $reason,
                'currentRoleLabel'   => $currentLabel,
                'requiredRoleLabels' => $requiredLabels,
            ], 403);
        }

        // 3. Role-Based Authorization Check
        if (!in_array($userRole, $allowedRoles, true)) {
            $reason = "Mevcut rolünüz ({$currentLabel}) bu işlemi gerçekleştirmek için yetkili değildir. Bu işlem yalnızca şu roller tarafından yapılabilir: " . implode(', ', $requiredLabels) . '.';

            if ($isApiRequest) {
                return response()->json([
                    'success'        => false,
                    'error'          => 'FORBIDDEN_ROLE',
                    'current_role'   => $userRole,
                    'required_roles' => $allowedRoles,
                    'message'        => $reason,
                ], 403);
            }

            return response()->view('errors.403', [
                'isUnverified'       => false,
                'title'              => 'Bu İşlem İçin Yetkiniz Bulunmamaktadır',
                'reason'             => $reason,
                'currentRoleLabel'   => $currentLabel,
                'requiredRoleLabels' => $requiredLabels,
            ], 403);
        }

        return $next($request);
    }

    /**
     * Normalize role names for consistent comparisons.
     */
    protected function normalizeRole(?string $role): string
    {
        $normalized = strtolower(trim((string) $role));

        if ($normalized === 'academician') {
            return User::ROLE_ACADEMICS;
        }

        return $normalized !== '' ? $normalized : User::ROLE_UNVERIFIED;
    }
}
