<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

   public function login(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

   
    $admin = Admin::where('username', $request->username)->first();

    if (!$admin) {
        return back()->with('error', 'Username tidak ditemukan');
    }

    if (!Hash::check($request->password, $admin->password)) {
        return back()->with('error', 'Password salah');
    }

    session([
        'admin'      => true,
        'admin_id'   => $admin->id,
        'admin_role' => $admin->role,
        'admin_name' => $admin->nama,
    ]);

   
    if ($admin->role == 'admin_jtik') {
       
        return redirect()->route('admin.jtik.index');
    } else {
       
        return redirect()->route('admin.prodi.index');
    }
}

    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.login');
    }
}
