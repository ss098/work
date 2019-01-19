<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    // 存储文件到磁盘
    public function store($attachment)
    {
        $content = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $attachment['data']));
        $extension = pathinfo($attachment['name'], PATHINFO_EXTENSION);
        $filename = str_random(32) . '.' . $extension;

        Storage::put($filename, $content);

        $this->record_id = $attachment['record_id'];
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
