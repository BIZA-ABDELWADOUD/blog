<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    
    public function index()
    {
        // get all tags
        return Tag::latest()->get();
        
    }


    public function store(TagRequest $request)
    {
        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function update(TagRequest $request)
    {
        return Tag::where('id',$request->id)->update([
            'tagName' => $request->tagName
        ]);
      
    }

    public function destroy(Request $request)
    {
        return Tag::where('id',$request->id)->delete();
        
    }

  
}
