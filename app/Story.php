<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'body', 'category', 'slug', 'user_id'];

    protected $dates = ['deleted_at'];
    //
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'story_tags', 'story_id', 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'story_id');
    }

    public function views()
    {
        return $this->hasMany('App\StoryView', 'story_id');
    }

    public static function new($postData)
    {
        $story = new Story($postData);
        $story->save();
        return $story;
    }

    public static function makeSlug($title)
    {
        return str_slug($title, "_");
    }
}
