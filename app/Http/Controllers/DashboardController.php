<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        // Middleware sudah diatur di routes/web.php

        // Middleware untuk verifikasi email (opsional)
        // $this->middleware('verified');
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'user_data' => getCurrentUserData(),
            'login_type' => getLoginType(),
            // Tambahkan data lain yang diperlukan untuk tampilan dashboard
        ];

        return view('dashboard.index', $data);
    }
}
