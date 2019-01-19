<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function attachment()
    {
        return $this->hasMany('App\Attachment');
    }

    public function form()
    {
        return $this->belongsTo('App\Form');
    }
}
