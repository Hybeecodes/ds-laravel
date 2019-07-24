<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    public function stories()
    {
        return $this->belongsToMany('App\Story', 'story_tags', 'tag_id', 'story_id');
    }

    public static function exists($tagId)
    {
        return Tag::where('id', $tagId)->exists();
    }
}
