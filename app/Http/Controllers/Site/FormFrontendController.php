<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;

class FormFrontendController extends Controller
{
    public function index()
    {
        $forms = Form::where('is_active', true)->latest()->get();
        return view('site.forms.index', compact('forms'));
    }

    public function show(string $slug)
    {
        $form = Form::where('slug', $slug)
            ->where('is_active', true)
            ->with(['fields' => function ($q) {
                $q->where('is_active', true)->orderBy('position');
            }])->firstOrFail();

        return view('site.forms.show', compact('form'));
    }

    public function submit(Request $request, string $slug)
    {
        $form = Form::where('slug', $slug)->with('fields')->firstOrFail();

        $rules = [];
        foreach ($form->fields as $field) {
            if ($field->is_required) {
                $rules['field_' . $field->id] = 'required';
            }
        }

        $data = $request->validate($rules);

        // لاگ ارسال فرم (فعلاً ساده)
        \Log::info('Form submitted', [
            'form_id' => $form->id,
            'data' => $data,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'فرم با موفقیت ارسال شد');
    }
}
