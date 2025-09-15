<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peserta;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Middleware akan diatur di routes/web.php
    }

    /**
     * Show the login form.
     */
    public function index()
    {
        // Jika user sudah login (admin atau peserta), redirect ke dashboard dengan pesan
        if (Auth::check() || session('peserta_logged_in')) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah login!');
        }

        return view('login.index', [
            'title' => 'Login - Febi Event'
        ]);
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Rate limiting to prevent brute force attacks
        $key = 'login.' . $request->ip();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => [trans('auth.throttle', ['seconds' => $seconds])],
            ]);
        }
        // dd($key);

        $email = $request->email;
        $password = $request->password;
        $remember = $request->boolean('remember');

        // Cek di tabel User (Admin) terlebih dahulu
        $user = User::where('email', $email)->first();
        // dd($user);
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();
            \Illuminate\Support\Facades\RateLimiter::clear($key);
            // dd($user);
            // Set user type dan data in session
            // $request->session()->put('login_type', 'admin');
            $request->session()->put('user_data', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles_id' => $user->role_id ?? null // Tambahkan roles_id untuk admin

            ]);
            // dd($request->session());
            return $this->authenticated($request, $user, 'admin');
        }

        // Jika tidak ditemukan di User, cek di tabel Peserta
        $peserta = Peserta::where('email', $email)->first();
        if ($peserta) {
            $isValidPassword = false;

            // Cek password hash terlebih dahulu
            if ($peserta->password && Hash::check($password, $peserta->password)) {
                $isValidPassword = true;
            }
            // Fallback: cek dengan NIK sebagai password (untuk backward compatibility)
            elseif ($password === $peserta->nik) {
                $isValidPassword = true;
            }

            if ($isValidPassword) {
                // Set peserta session data
                $request->session()->put('peserta_logged_in', true);
                $request->session()->put('peserta_id', $peserta->id);
                // $request->session()->put('login_type', 'peserta');
                $request->session()->put('user_data', [
                    'id' => $peserta->id,
                    'name' => $peserta->nama,
                    'email' => $peserta->email,
                    'roles_id' => $peserta->roles_id // Tambahkan roles_id untuk peserta

                ]);
                $request->session()->regenerate();
                \Illuminate\Support\Facades\RateLimiter::clear($key);

                return $this->authenticated($request, $peserta, 'peserta');
            }
        }

        // If login attempt was unsuccessful, increment rate limiting
        \Illuminate\Support\Facades\RateLimiter::hit($key, 60);

        throw ValidationException::withMessages([
            'email' => ['Email atau password tidak valid.'],
        ]);
    }

    /**
     * The user has been authenticated.
     */
    protected function authenticated(Request $request, $user, $userType = 'admin')
    {
        // dd($user);
        // Log successful login
        \Illuminate\Support\Facades\Log::info('User logged in', [
            'user_id' => $user->id,
            // 'name' => $user->name ?? $user->name,
            'email' => $user->email,
            'type' => $userType,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        // dd(session('user_data', []));

        // Get user name and role information
        $userData = session('user_data', []);
        $roleId = $userData['roles_id'] ?? $user->roles_id ?? null;
        $roleName = 'Unknown Role';
        if ($roleId) {
            $role = Role::find($roleId);
            $roleName = $role ? $role->name : 'Unknown Role';
        }
        // Penentuan nama berdasarkan role
        if (is_string($roleName) && preg_match('/admin/i', $roleName)) {
            $userName = $user->name;
        } else {
            $userName = $user->nama ?? $user->name;
        }

        // Get role_id from session data (more reliable for both admin and peserta)
        $userData = session('user_data', []);
        $roleId = $userData['roles_id'] ?? $user->roles_id ?? null;

        // Get role name from database
        $roleName = 'Unknown Role';
        if ($roleId) {
            $role = Role::find($roleId);
            $roleName = $role ? $role->name : 'Unknown Role';
        }

        // Set success message with user name and role
        $message = 'Welcome back, ' . $userName . '! (Role: ' . $roleName . ')';

        // Redirect ke dashboard yang sama
        return redirect()->intended(route('dashboard'))->with('success', $message);
    }
    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Clear peserta session data
        $request->session()->forget(['peserta_logged_in', 'peserta_id', 'user_data']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
