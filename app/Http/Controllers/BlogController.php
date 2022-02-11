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

    public function slug() {
        $title = 'this is a testing title changed for our blog';
        return Blog::create([
            
            'title' => $title,
            'post' => "this is the post",
            'post_excerpt' => "this is",
          
            'user_id' => 1,
            'metaDescription'=> "description"
        ]);
        // return $title;
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
            return 'yes';

        } catch (\Exception $e) {
            DB::rollback();
                return 'no';
        }
        
     
    }

    public function getBlogs() {
        return Blog::with(['categories','tags'])->get();
    }
}
