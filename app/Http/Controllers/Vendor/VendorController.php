<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function vendor(){
        return view('vendor.dashboard');
    } // end method

    public function profile()
    {
        $id = Auth::user()->id;
        $adminData = User::findOrFail($id);
        return view('vendor.profile', compact('adminData'));
    } // end method

    public function profileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::findOrFail($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/vendor_image/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/vendor_image'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Vendor Profile Update Success!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method

    public function changepassword()
    {
        return view('vendor.changepassword');
    } // end method

    public function updatepassword(Request $request)
    {
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required|confirmed',
        ]);

        if(!Hash::check($request->old_password,auth::user()->password)){
            return back()->with('error','Old Password not Match!');
        }
        User::whereId(auth()->user()->id)->update([
            'password'=>Hash::make($request->new_password)
        ]);
        return back()->with('success','Password Update Success!');

    } // end method

    public function login()
    {
        return view('vendor.login');
    } // end method

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('vendor.login');
    }
}
