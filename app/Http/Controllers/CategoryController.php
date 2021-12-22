<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function index()
    {
        return Category::latest()->get();
    }


    public function store(CategoryRequest $request)
    {
        return Category::create([
            'categoryName' => $request->categoryName,
            'categoryIcon' => 'uploads/categories/'.$request->categoryIcon
        ]);
    }

    public function update(Request $request)
    {
        return Category::where('id',$request->id)->update([
            'categoryName' => $request->categoryName,
            'categoryIcon' => $request->categoryIcon
        ]);
    }


    public function destroy(Request $request)
    {
        $path = $request->categoryIcon;
        if(file_exists($path)) {
            @unlink($path);
        }
        
        return Category::where('id',$request->id)->delete();
      
    }

    public function upload(Request $request) 

    {
        $this->validate($request,[
            'file' => 'bail|required|mimes:jpg,png,jpeg'
        ]);
         $picname = time().'.'.$request->file->extension();
         $request->file->move(public_path('uploads/categories'),$picname);
        return $picname;
    }

    public function uploadedit(Request $request) 

    {
        $this->validate($request,[
            'file' => 'bail|required|mimes:jpg,png,jpeg'
        ]);
         $picname = time().'.'.$request->file->extension();
         $request->file->move(public_path('uploads/categories'),$picname);
        return '/uploads/categories/'.$picname;
    }

    public function deleIconfromserver(Request $request) {
         $icon_name = $request->imageName;
         $file_path = public_path().'/uploads/categories/'.$icon_name;
      
        if(file_exists($file_path)) {
            @unlink($file_path);
        }
        return 'deleted';
    }

    
}
