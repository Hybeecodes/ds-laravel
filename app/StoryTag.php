<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoryTag extends Model
{
    //
    protected $fillable = ['story_id', 'tag_id'];
}
