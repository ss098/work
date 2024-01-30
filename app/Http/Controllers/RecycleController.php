<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Form;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class RecycleController extends Controller
{
    public function overview(Request $request)
    {
        // 概览表单的提交情况
        $id = $request->input('id');
        $order_by = $request->input('order_by');

        $record = Record::with('attachment')
            ->where('form_id', $id);

        if (in_array($order_by, ['code', 'updated_at'])) {
            $record->orderBy($order_by);
        }

        return [
            'success' => true,
            'records' => $record->get()
        ];
    }

    // 提交信息
    public function recycle(Request $request)
    {
        $id = $request->input('id');
        $recycle = $request->input('recycle');

        $recycle['name'] = trim($request->input('recycle.name'));
        $recycle['code'] = trim($request->input('recycle.code'));

        $record = Record::where('form_id', $id)
            ->where('code', $recycle['code'])
            ->first();

        if (!$record) {
            $record = new Record();
        } else {
            $record->attachment->each(function ($attachment) {
                $attachment->delete_file();
                $attachment->delete();
            });
        }

        $record->form_id = $id;
        $record->name = $recycle['name'];
        $record->code = $recycle['code'];
        $record->save();

        foreach ($recycle['attachment'] as $attachment_data) {
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
        $format = $request->input('format');
        $form = Form::find($id);
        $filename = storage_path(Str::random(8) . '.zip');

        if (empty($format)) {
            $format = 'name code';
        }

        $zipper = new ZipArchive();
        $zipper->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($form->record as $record) {
            foreach ($record->attachment as $index => $attachment) {
                $extension = pathinfo($attachment->name, PATHINFO_EXTENSION);

                $attachment_name = str_replace('name', $record->name, $format);
                $attachment_name = str_replace('code', $record->code, $attachment_name);

                if ($record->attachment->count() > 1) {
                    $zipper->addFile(storage_path('app/' . $attachment->name), $attachment_name . '/' . ($index + 1) . '.' . $extension);
                } else {
                    $zipper->addFile(storage_path('app/' . $attachment->name), $attachment_name . '.' . $extension);
                }
            }
        }

        $zipper->close();

        return response()->download($filename, $form->name . '.zip')->deleteFileAfterSend();
    }
}
