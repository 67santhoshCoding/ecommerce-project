<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Category;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $title                  = "Category List";
        $breadCrum              = array('Category', 'Categories List');
        if($request->ajax()){
          
            $data = Category::select('categories.*',
            DB::raw('IF(categories.parent_id = 0, "Parent", parent_categories.name ) as parent_name '))
            ->leftJoin('categories as parent_categories', 'parent_categories.id', '=', 'categories.parent_id')->orderBy('id','desc');
            $keywords = $request->get('search')['value'];
            $datatables = Datatables::of($data)
                    ->filter(function ($query) use ($keywords) {
                        if ($keywords) {
                            $date = date('Y-m-d', strtotime($keywords));
                            return $query->where('categories.name', 'like', "%{$keywords}%")
                            ->orWhere('categories.slug', 'like', "%{$keywords}%")
                            ->orWhere('parent_categories.name', 'like', "%{$keywords}%")
                            ->orWhereDate("categories.created_at", $date);
                        }
                        })
                    ->addIndexColumn()
                    ->addColumn('action',function($row){
                        $view = '';
                        $delete = '';
                        $view = '<a href="'.route('category.addEdit',$row->id).'"  style="margin-right:15px"> <i class="fa fa-edit" style="font-size:20px;"  aria-hidden="true"></i></a>';
                        $delete = '<a href="javascript:void(0)"  onClick="categoryDeleteData('.$row->id.')" >  <i class="fa fa-trash-o" style="font-size:20px;" aria-hidden="true"></i></a>';
                        return $view.$delete;
                    })
                    ->editColumn('image',function($row){
                        
                            if($row->image)
                            {
                                $imagePath = '/upload/category/'.$row->id.'/'.$row->image;
                                $url = Storage::url('app/'.$row->image);
                                $path = asset($url);
                                $image = '<div class="symbol symbol-45px me-5" ><img src="'.$path.'" alt="no image" ></div>';
                            }
                            else{
                                $image = '';
                            }
                            return $image;
                    })
                    ->editColumn('status',function($row){
                        $val = $row->status;
                        $status  = '<a href="javascript:void(0);"   onClick="categoryStatus('.$row->id.')"   class="btn btn-'.(($row->status == 'published')? 'success':'danger').'">'.$row->status.' </a>' ;
                        return $status;
                    })
                    ->rawColumns(['action','status','image']);
                    return $datatables->make(true);

        }

        return view('admin.partials.product.category.index',compact('title','breadCrum'));
    }
    public function addOrEdit(Request $request)
    {
        $id = $request->id ?? '';
        if($id)
        {
            // dd($id);
            $info = Category::find($id);
            $category = Category::where('status','published')->where('parent_id',0)->get();
            return view('admin.partials.product.category.form',compact('category','info'));
        }else {

            $category = Category::where('status','published')->where('parent_id',0)->get();
            return view('admin.partials.product.category.form',compact('category'));
        }

    }
    public function store(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $validator =  Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,'.$id.',id,deleted_at,NULL',
            'image' => 'mimes:jpeg,png,jpg',
        ]);
      
        if($validator->passes())
        {
            
            $id = $request->id;
           $int['name']                 = $request->name;
           $int['slug']                 = \Str::slug($request->name);
           $int['description']          = $request->description;
           $int['order_by']             = $request->order_by;
          
           if($request->is_parent)
           {
                $int['parent_id']  = 0;
           }
           else{
                $int['parent_id']  = $request->parent_id;
           }
           if($request->status == 'on')
           {
                $int['status']  = "published";
           }
           else{
                $int['status']  = "unpublished";
           }
           if($request->is_featured)
           {
                $int['is_featured']  = 'Yes';
           }
           else{
            $int['is_featured']  = 'No';

           }
           
           
           $data = Category::updateOrCreate(
            ['id'=>$id],$int);

            if($request->file('image'))
            {
                $directory = 'public/upload/category/'.$data->id;
                Storage::deleteDirectory($directory);

                $path = $request->file('image')->store('public/upload/category/'.$data->id);
            
                $data['image']  = $path;
                $data->save();
            }
           

           $error = 0;
           $message = $validator->errors()->all();
           return response()->json(['error'=>$error,'message'=>$message]);
        }
        else{
            $error = 1;
            $message = $validator->errors()->all();
            return response()->json(['error'=>$error,'message'=>$message]);
        }
        
    }
    public function edit($id)
    {
        if($id)
        {
            // dd($id);
            $info = Category::find($id);
            // $category = Category::where('status','published')->where('parent_id',0)->get();
            return view('admin.partials.product.category.form',compact('info'));
        }
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        $data = Category::find($id)->delete();
        if($data == 'true')
        {
            $error = 0;
            return response()->json(['error'=>$error]);
        }
        $error = 1;
        return response()->json(['error'=>$error]);

    }
    public function status(Request $request)
    {
        $id = $request->id;
        $data = Category::find($id);
        if($data->status == 'published')
        {
            $data->status = "unpublished";
            $data->update();
        }
        else {
            $data->status = "published";
            $data->update();
        }
        return response()->json(['message'=>"Status Update Successfully"]);
    }
}
