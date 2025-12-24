<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = DB::select('select * from ADMIN where Username = ? limit 1', [$data['username']]);
        if (!count($admin)) {
            return Redirect::back()->withErrors(['username' => 'Invalid credentials']);
        }
        $admin = (array)$admin[0];

        if (!Hash::check($data['password'], $admin['Password'])) {
            return Redirect::back()->withErrors(['password' => 'Invalid credentials']);
        }

        session(['admin_id' => $admin['AdminID'], 'admin_username' => $admin['Username']]);

        return redirect()->route('admin.books.index');
    }

    public function logout()
    {
        session()->forget(['admin_id','admin_username']);
        return redirect()->route('admin.login');
    }
}
