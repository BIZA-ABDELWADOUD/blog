<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Blog extends Model
{
    protected $table = 'blogs';
     protected $fillable = ['id','title','post','post_excerpt','slug','user_id','featuredImage','metaDescription','views','jsonData'];

   
    public function setSlugAttribute($title) {
        $this->attributes['slug'] = $this->UniqueSlug($title);
    }

    private function UniqueSlug($title) {
        $slug = Str::slug($title,'-');
        $count = Blog::where('slug','LIKE',"{$slug}%")->count();
        $newCount = $count > 0 ? ++$count : '';
        return $newCount > 0 ? "$slug-$newCount" : $slug;

    }

    public function tags() {

        return $this->belongsToMany('App\Tag','blogtags');
    }

    public function categories() {
        return $this->belongsToMany('App\Category','blogcategories');

    }

}
