<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Attachment extends Model
{
    use SoftDeletes;

    // 存储文件到磁盘
    public function store($attachment)
    {
        $record_id = $attachment['record_id'];
        $content = base64_decode(preg_replace('#^data:(.+);base64,#iU', '', $attachment['data']));

        $extension = pathinfo($attachment['name'], PATHINFO_EXTENSION);
        $filename = $record_id . '/' . Str::random(8) . '.' . $extension;

        Storage::put($filename, $content);

        $this->record_id = $record_id;
        $this->name = $filename;
        $this->size = Storage::size($filename);
    }

    public function delete_file()
    {
        Storage::delete($this->name);
    }

    public function record()
    {
        return $this->belongsTo('App\Record');
    }
}
