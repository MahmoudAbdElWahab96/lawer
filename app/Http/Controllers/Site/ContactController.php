<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        if ($request->filled('message_prefix') && $request->filled('message')) {
            $request->merge([
                'message' => $request->input('message_prefix')."\n\n".$request->input('message'),
            ]);
        } elseif ($request->filled('message_prefix') && ! $request->filled('message')) {
            $request->merge([
                'message' => $request->input('message_prefix')."\n\nطلب استشارة عبر نموذج الموقع.",
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'practice_area_id' => ['nullable', 'exists:practice_areas,id'],
            'message' => ['required', 'string', 'min:5', 'max:5000'],
        ], [
            'name.required' => __('site.validation.name_required'),
            'phone.required' => __('site.validation.phone_required'),
            'email.email' => __('site.validation.email'),
            'message.required' => __('site.validation.message_required'),
            'message.min' => __('site.validation.message_min'),
        ]);

        ContactMessage::create($validated + [
            'locale' => app()->getLocale(),
        ]);

        return back()
            ->withFragment('booking')
            ->with('contact_success', true);
    }
}
