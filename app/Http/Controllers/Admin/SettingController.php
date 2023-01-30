<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $id = $user->id;
        $data = User::find($id);
        return view('admin.partials.setting.profile.index',compact('data'));
    }
    public function store(Request $request)
    {
        $validator                  = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'mobile' => 'required|numeric|digits:10',
            'files' => 'mimes:jpg,jpeg,png',
           
        ]);
        if($validator->passes())
        {
            
            $id = $request->id;
            $data = User::find($id);
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['mobile'] = $request->mobile;
            if($request->file('files'))
            {
                $directory = 'admin/uploads/profile/'.$id;
                File::deleteDirectory($directory);
                
                $fileName = $request->file('files')->getClientOriginalName();
                $fileName = str_replace([' ','{','}','(',')'],'',$fileName);
                $path = public_path('admin/uploads/profile/'.$id.'/');
                $filePath = 'admin/uploads/profile/'.$id.'/';
                if(!File::exists($path))
                {
                    File::makeDirectory($path,0777,true,true);
                }
                $request->file('files')->move(public_path($filePath),$fileName);
                $fileName = $filePath.$fileName;
                // $fileName = $request->file('files')->store('/uploads/profile/'.$id);
                $data['profile'] = $fileName;

            }
            if($request->password)
            {
                $validator                  = Validator::make($request->all(), [
                    'old_password' => 'required',
                    'password' => 'min:6',
                    'confoirm_password' => 'required_with:password|same:password|min:6',
                ]);
                if ($validator->passes()) {
                if ((Hash::check($request->get('old_password'), Auth::user()->password))) {

                    $password = Hash::make($request->password);
                    $data['password'] = $password;

                }
                else{
                    $error = 1;
                    $message = "Old password dons't match";
                    return response()->json(['error'=> $error, 'message' => $message]);
                }
                }
                else {
                    $error = 1;
                    $message = $validator->errors()->all();
                    return response()->json(['error'=> $error, 'message' => $message]);
                }

            }
           
            $data->save();
            $error = 0;
            return response()->json(['error'=>$error]);

        }
        else{
            $error = 1;
            $message = $validator->errors()->all();
            return response()->json(['error'=>$error,'message'=>$message]);
        }
    //     return $validator->errors()->all();
    //    return $request->file('files')->store('docs');
        // dd($request->all());

    }
    public function profileImageDelete(Request $request)
    {
        $id=$request->id;
        $data = User::find($id);
        $data['profile'] = '';
        $data->update(); 
        $directory = 'admin/uploads/profile/'.$id;
        File::deleteDirectory($directory);
        $error = 0;
        return response()->json(['error'=>$error,'message'=>"Image Deleted successfully"]);
    }
    public function settingPage()
    {
        return view('admin.partials.setting');

    }

}
