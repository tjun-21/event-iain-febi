<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('isUserLoggedIn')) {
    function isUserLoggedIn()
    {
        return Auth::check() || session('peserta_logged_in');
    }
}

if (!function_exists('getCurrentUserData')) {
    function getCurrentUserData()
    {
        return session('user_data');
    }
}

if (!function_exists('getLoginType')) {
    function getLoginType()
    {
        return session('login_type', 'guest');
    }
}

// if (!function_exists('isAdmin')) {
//     function isAdmin()
//     {
//         $roleName = user_role_name();
//         return in_array(strtolower($roleName), ['admin', 'administrator', 'super admin']);
//     }
// }

// if (!function_exists('isPeserta')) {
//     function isPeserta()
//     {
//         $roleName = user_role_name();
//         return in_array(strtolower($roleName), ['peserta', 'participant', 'member']);
//     }
// }

// if (!function_exists('user_name')) {
//     function user_name()
//     {
//         // Cek apakah user admin sedang login
//         if (Auth::check()) {
//             return Auth::user()->name;
//         }

//         // Cek apakah peserta sedang login
//         if (session('peserta_logged_in') && session('user_data')) {
//             $userData = session('user_data');
//             if (isset($userData['name'])) {
//                 return $userData['name'];
//             }
//         }

//         return null; // Return null instead of 'Guest'
//     }
// }

if (!function_exists('user_display_name')) {
    function user_display_name()
    {
        // Prioritas: cek admin login
        if (Auth::check()) {
            return Auth::user()->name;
        }

        // Kedua: cek peserta login
        if (session('peserta_logged_in') && session('user_data')) {
            $userData = session('user_data');
            if (isset($userData['name']) && !empty($userData['name'])) {
                return $userData['name'];
            }
        }

        // Fallback ke session login_type check
        if (session('login_type') === 'peserta' && session('peserta_id')) {
            // Ambil data peserta langsung dari database sebagai fallback
            try {
                $peserta = \App\Models\Peserta::find(session('peserta_id'));
                if ($peserta) {
                    return $peserta->nama;
                }
            } catch (\Exception $e) {
                // Silently fail and continue to fallback
            }
        }

        return 'User'; // Final fallback
    }
}

if (!function_exists('user_email')) {
    function user_email()
    {
        // Cek apakah user admin sedang login
        if (Auth::check()) {
            return Auth::user()->email;
        }

        // Cek apakah peserta sedang login
        if (session('peserta_logged_in') && session('user_data')) {
            return session('user_data')['email'];
        }

        return null;
    }
}

if (!function_exists('user_id')) {
    function user_id()
    {
        // Ambil id peserta dari session user_data
        if (session('peserta_logged_in') && session('user_data')) {
            return session('user_data')['id'] ?? null;
        }
        return null;
    }
}

// if (!function_exists('user_type_label')) {
//     function user_type_label()
//     {
//         $roleName = user_role_name();

//         if (!$roleName) {
//             return 'Guest';
//         }

//         // Return the actual role name instead of hardcoded labels
//         return ucfirst($roleName);
//     }
// }

if (!function_exists('user_roles_id')) {
    function user_roles_id()
    {
        // Cek apakah user admin sedang login
        if (Auth::check()) {
            return Auth::user()->roles_id ?? null;
        }

        // Cek apakah peserta sedang login
        if (session('peserta_logged_in') && session('user_data')) {
            return session('user_data')['roles_id'] ?? null;
        }

        return null;
    }
}

if (!function_exists('user_role_name')) {
    function user_role_name()
    {
        $rolesId = user_roles_id();

        if ($rolesId) {
            try {
                $role = \App\Models\Role::find($rolesId);
                return $role ? $role->name : null;
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }
}

if (!function_exists('user_has_role')) {
    function user_has_role($roleNames)
    {
        $userRoleName = user_role_name();

        if (!$userRoleName) {
            return false;
        }

        // Convert to array if string
        if (is_string($roleNames)) {
            $roleNames = [$roleNames];
        }

        // Case insensitive comparison
        return in_array(strtolower($userRoleName), array_map('strtolower', $roleNames));
    }
}

if (!function_exists('user_can_access')) {
    function user_can_access($allowedRoles)
    {
        return user_has_role($allowedRoles);
    }
}

if (!function_exists('current_user_full_info')) {
    function current_user_full_info()
    {
        $userData = getCurrentUserData();
        $loginType = getLoginType();
        $roleName = user_role_name();

        return [
            'id' => user_id(),
            'name' => user_display_name(),
            'email' => user_email(),
            'login_type' => $loginType, // Keep login_type for backward compatibility
            // 'type_label' => user_type_label(),
            'roles_id' => user_roles_id(),
            'role_name' => $roleName,
            // 'is_admin' => isAdmin(),
            // 'is_peserta' => isPeserta(),
            'is_logged_in' => isUserLoggedIn(),
            'has_role' => function ($roles) {
                return user_has_role($roles);
            }
        ];
    }
}

if (!function_exists('debug_session_data')) {
    function debug_session_data()
    {
        return [
            'peserta_logged_in' => session('peserta_logged_in'),
            'peserta_id' => session('peserta_id'),
            'login_type' => session('login_type'),
            'user_data' => session('user_data'),
            'roles_id' => user_roles_id(),
            'role_name' => user_role_name(),
            'auth_check' => Auth::check(),
            'auth_user' => Auth::check() ? Auth::user()->name : null
        ];
    }
}
