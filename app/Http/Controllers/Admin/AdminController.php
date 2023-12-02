<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function admin(){
        return view('admin.index');
    } // end method

    public function profile(){
        $id=Auth::user()->id;
        $adminData=User::findOrFail($id);
        return view('admin.profile',compact('adminData'));
    } // end method

    public function login(){
        return view('admin.login');
    } // end method

    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
