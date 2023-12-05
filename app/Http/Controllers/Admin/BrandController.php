<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Image;

class BrandController extends Controller
{
    public function index(){
        $data=Brand::latest()->get();
        return view('admin.brand.index',compact('data'));
    } // end method

    public function add(){
        return view('admin.brand.add_brand');
    } // end method

    public function store(Request $request){
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = uniqid() . $file->getClientOriginalName();
            Image::make($file)->resize(300,300)->save('upload/brand/'.$filename);
            $save_url='upload/brand/'.$filename;
        }
        Brand::insert([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name,'-'),
            'image'=>$save_url,
            'created_at'=>Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Brand Insert Success!',
            'alert-type' => 'success'
        );
        return redirect()->route('brand.list')->with($notification);
    } // end method

    public function edit($id){
        $data=Brand::findOrFail($id);
        return view('admin.brand.edit',compact('data'));
    } // end method

    public function update(Request $request,$id){
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = uniqid() . $file->getClientOriginalName();
            Image::make($file)->resize(300,300)->save('upload/brand/'.$filename);
            $save_url='upload/brand/'.$filename;
        }
        Brand::findOrFail($id)->update([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name,'-'),
            'image'=>$save_url,
            'updated_at'=>Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Brand Update Success!',
            'alert-type' => 'success'
        );
        return redirect()->route('brand.list')->with($notification);
    } // end method

    public function delete($id){
        $data=Brand::findOrFail($id);
        
        $data->delete();


        $notification = array(
            'message' => 'Brand Delete Success!',
            'alert-type' => 'success'
        );
        return redirect()->route('brand.list')->with($notification);
    }
}
