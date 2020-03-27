<?php
   
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
  
class FileUploadController extends Controller{

    public function fileUpload()
    {
        return view('fileUpload');
    }  
  
    public function fileUploadPost(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:jpg,png,gif|max:2048',
        // ]);

        //$name = $file->getClientOriginalName();
        //$ext =  $request->file->extension();


        $fileName = time().'-'.$request->avatar->getClientOriginalName();     
        $request->avatar->move(public_path('avatars'), $fileName);
   
        return back();
          //  ->with('success','Avatar actualizado.')
          //  ->with('file',$fileName);
   
    }
}