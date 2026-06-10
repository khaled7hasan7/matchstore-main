<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Check if email already exists
        $existing = Subscriber::where('email', $validated['email'])->first();

        if ($existing) {
            if ($existing->status === 'active') {
                return response()->json([
                    'success' => false,
                    'message' => __('store.newsletter.already_subscribed'),
                ], 409);
            } else {
                // Reactivate subscription
                $existing->update(['status' => 'active']);
                return response()->json([
                    'success' => true,
                    'message' => __('store.newsletter.resubscribed'),
                ]);
            }
        }

        // Create new subscription
        Subscriber::create([
            'email' => $validated['email'],
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => __('store.newsletter.success'),
        ]);
    }

    public function unsubscribe(Request $request)
    {
        $email = base64_decode($request->query('email'));

        $subscriber = Subscriber::where('email', $email)->first();

        // Get site settings for branding
        $siteSettings = SiteSetting::first();

        if ($subscriber) {
            $subscriber->update(['status' => 'unsubscribed']);
            return view('emails.unsubscribed', [
                'email' => $email,
                'siteSettings' => $siteSettings
            ]);
        }

        return view('emails.unsubscribed', [
            'email' => $email,
            'notFound' => true,
            'siteSettings' => $siteSettings
        ]);
    }
}
