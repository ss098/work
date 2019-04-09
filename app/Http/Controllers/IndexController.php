<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        return view('app');
    }

    public function create(Request $request)
    {
        $name = $request->input('name');

        if ($name) {
            $form = Form::create(['name' => $name]);

            return [
                'success' => true,
                'id' => $form->id
            ];
        }
    }

    public function detail(Request $request)
    {
        $id = $request->input('id');

        $detail = Form::find($id);

        if ($detail)
        {
            return [
                'success' => true,
                'detail' => $detail
            ];
        }

        return [
            'success' => false
        ];
    }

    public function all(Request $request)
    {
        $form = Form::withCount('record')->orderBy('id', 'desc')->get();

        return [
            'success' => true,
            'forms' => $form
        ];
    }
}
