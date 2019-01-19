<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Form;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecycleController extends Controller
{
    public function overview(Request $request)
    {
        // 概览表单的提交情况
        $id = $request->input('id');

        $record = Record::with('attachment')
            ->where('form_id', $id)
            ->orderBy('code')
            ->get();

        return [
            'success' => true,
            'records' => $record
        ];
    }

    // 提交信息
    public function recycle(Request $request)
    {
        $id = $request->input('id');
        $recycle = $request->input('recycle');

        $recycle['name'] = trim($recycle['name']);
        $recycle['code'] = trim($recycle['code']);

        $record = Record::where('form_id', $id)
            ->where('code', $recycle['code'])
            ->first();

        if (!$record)
        {
            $record = new Record();
        } else {
            $record->attachment->each(function ($attachment)
            {
                $attachment->delete_file();
                $attachment->delete();
            });
        }

        $record->form_id = $id;
        $record->name = $recycle['name'];
        $record->code = $recycle['code'];
        $record->save();

        foreach ($recycle['attachment'] as $attachment_data)
        {
            $attachment_data['record_id'] = $record->id;

            $attachment = new Attachment();
            $attachment->store($attachment_data);
            $attachment->save();
        }

        return [
            'success' => true,
            'record_id' => $record->id
        ];
    }

    public function attachment(Request $request)
    {
        $id = $request->input('id');

        $attachment = Attachment::find($id);

        return Storage::download($attachment->name);
    }

    public function export(Request $request)
    {
        $id = $request->input('id');
        $form = Form::find($id);
        $filename = storage_path(str_random(32) . '.zip');

        $zipper = new \Chumper\Zipper\Zipper;
        $zipper->make($filename);

        foreach ($form->record as $record)
        {
            $folder = $zipper->folder($record->name . $record->code);

            foreach ($record->attachment as $index => $attachment)
            {
                $extension = pathinfo($attachment->name, PATHINFO_EXTENSION);

                $folder->add(storage_path('app/' . $attachment->name), ($index + 1).'.'.$extension);
            }

        }

        $zipper->close();

        return response()->download($filename, $form->name . '.zip')->deleteFileAfterSend(true);
    }
}
