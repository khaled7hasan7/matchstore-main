<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Models\Contact;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('themes.xylo.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $contact = Contact::create($validated);

        // Notify the store inbox; a mail failure must not hide the message —
        // it is already stored and visible in the admin panel.
        try {
            $siteSettings = SiteSetting::first();
            $adminEmail = $siteSettings->contact_email ?? config('mail.from.address');

            if ($adminEmail) {
                $storeName = $siteSettings->site_name ?? config('app.name');
                Mail::to($adminEmail)
                    ->send((new ContactMessageMail($contact, $storeName))->locale(app()->getLocale()));
            }
        } catch (\Throwable $e) {
            Log::error('Contact form mail failed: '.$e->getMessage());
        }

        return redirect()->back()->with('success', __('store.contact.success_message'));
    }
}
