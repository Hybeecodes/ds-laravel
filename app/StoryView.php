<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoryView extends Model
{
    //
    protected $fillable = ['story_id', 'viewed_by'];

    public function story()
    {
        return $this->belongsTo('App/Story', 'story_id');
    }

    public function viewer()
    {
        return $this->belongsTo('App/User', 'viewed_by');
    }
}
