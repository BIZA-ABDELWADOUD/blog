<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Blogtag;
use App\Blogcategory;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    
    public function index()
    {
        return Blog::with(['categories','tags'])->latest()->get();
    }


    public function store(Request $request)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        return Blog::where('id',$request->id)->delete();
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

  

    public function createBlog(BlogRequest $request) {
        $categories = $request->category_id;
        $tags = $request->tag_id;

        $blogCategories = [];
        $blogTags = [];
        DB::beginTransaction();
        try {
            
            $blog = Blog::create([
                'title' => $request->title,
                 'slug' => $request->title,
                'post' => $request->post,
                'post_excerpt' => $request->post_excerpt,
                'user_id' => Auth::user()->id,
                'metaDescription'=> $request->metaDescription,
                'jsonData'=> $request->jsonData
            ]);
            foreach($categories as $cat) {
                array_push($blogCategories,['category_id' => $cat,'blog_id' => $blog->id]);
            }
            Blogcategory::insert($blogCategories);
    
            foreach($tags as $tag) {
                array_push($blogTags,['tag_id' => $tag,'blog_id' => $blog->id]);
            }
            Blogtag::insert($blogTags);
            DB::commit();
            return $blog;

        } catch (\Exception $e) {
            DB::rollback();
                return 'no';
        }
        
    }

    public function GetSingleBlog(Request $request,$id) {

        return Blog::with(['categories','tags'])->where('id',$id)->first();

    }

}
