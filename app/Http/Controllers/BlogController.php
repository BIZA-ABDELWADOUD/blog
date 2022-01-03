<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function uploadEditorImage(Request $request) {
        $this->validate($request,[
            'image' => 'required|mimes:jpg,png,jpeg'
        ]);
        $picname = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads/blogs'),$picname);
        return response()->json([
            'success' => 1,
            'file' => [
                'url' => "http://discovermogador.com/uploads/blogs/$picname"
            ]
        ]);
       return $picname;
    }
}
