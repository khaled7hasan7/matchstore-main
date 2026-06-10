<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewsletterJob;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $subscribers = Subscriber::query()
            ->when($search, function ($query, $search) {
                $query->where('email', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => Subscriber::count(),
            'active' => Subscriber::where('status', 'active')->count(),
            'unsubscribed' => Subscriber::where('status', 'unsubscribed')->count(),
        ];

        return view('admin.subscribers.index', compact('subscribers', 'stats', 'search', 'status'));
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', __('cms.newsletter.success_deleted'));
    }

    public function export()
    {
        $subscribers = Subscriber::where('status', 'active')->get();

        $filename = 'subscribers_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($subscribers) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['Email', 'Status', 'Subscribed Date']);

            // Add data
            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->email,
                    $subscriber->status,
                    $subscriber->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function updateStatus(Request $request, $id)
    {
        $subscriber = Subscriber::findOrFail($id);

        $request->validate([
            'status' => 'required|in:active,unsubscribed',
        ]);

        $subscriber->update(['status' => $request->status]);

        return redirect()->route('admin.subscribers.index')
            ->with('success', __('cms.newsletter.success_status_updated'));
    }

    public function compose()
    {
        $activeSubscribersCount = Subscriber::where('status', 'active')->count();
        return view('admin.subscribers.compose', compact('activeSubscribersCount'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $subscribers = Subscriber::where('status', 'active')->get();

        if ($subscribers->isEmpty()) {
            return redirect()->back()->with('error', __('cms.newsletter.error_no_subscribers'));
        }

        // Dispatch jobs to queue
        foreach ($subscribers as $subscriber) {
            SendNewsletterJob::dispatch($subscriber->email, $request->subject, $request->content);
        }

        return redirect()->route('admin.subscribers.index')
            ->with('success', __('cms.newsletter.success_sent', ['count' => $subscribers->count()]));
    }
}
