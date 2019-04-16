<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use SoftDeletes;
    
    public function attachment()
    {
        return $this->hasMany('App\Attachment');
    }

    public function form()
    {
        return $this->belongsTo('App\Form');
    }
}
