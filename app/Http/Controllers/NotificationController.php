<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $member = Auth::user()->member;
        $notifications = Notification::where('member_id', $member->membership_number)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('pages.member.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $member = Auth::user()->member;
        $notification = Notification::where('member_id', $member->membership_number)
            ->findOrFail($id);

        $notification->update(['read_at' => now()]);

        return redirect()->back();
    }

    public function markAllAsRead()
    {
        $member = Auth::user()->member;
        Notification::where('member_id', $member->membership_number)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'Semua notifikasi telah dibaca.');
    }

    public function unreadCount()
    {
        $member = Auth::user()->member;
        $count = Notification::where('member_id', $member->membership_number)
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    public function getLatest(Request $request)
    {
        $member = Auth::user()->member;
        $since = $request->query('since');

        $query = Notification::where('member_id', $member->membership_number)
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->limit(10);

        if ($since) {
            $query->where('created_at', '>', $since);
        }

        $notifications = $query->get(['id', 'title', 'message', 'type', 'created_at']);

        return response()->json(['notifications' => $notifications]);
    }

    public function stream(Request $request)
    {
        $member = Auth::user()->member;
        $membershipNumber = $member->membership_number;
        $since = $request->query('since', now()->subSeconds(10)->toISOString());

        return response()->stream(function () use ($membershipNumber, $since) {
            // Tell client to wait 3s before reconnecting if connection drops
            echo "retry: 3000\n\n";
            if (ob_get_level()) ob_flush();
            flush();

            $lastCheck = $since;
            $iterations = 0;
            $maxIterations = 30; // ~90s per connection, then client auto-reconnects

            while ($iterations < $maxIterations && !connection_aborted()) {
                $notifications = Notification::where('member_id', $membershipNumber)
                    ->whereNull('read_at')
                    ->where('created_at', '>', $lastCheck)
                    ->orderBy('created_at', 'asc')
                    ->get(['id', 'title', 'message', 'type', 'created_at']);

                $lastCheck = now()->toISOString();

                if ($notifications->isNotEmpty()) {
                    foreach ($notifications as $notif) {
                        echo "event: notification\n";
                        echo "data: " . json_encode($notif) . "\n\n";
                    }
                    if (ob_get_level()) ob_flush();
                    flush();
                }

                // Heartbeat to keep the connection alive through proxies/load balancers
                echo ": keepalive\n\n";
                if (ob_get_level()) ob_flush();
                flush();

                sleep(3);
                $iterations++;
            }
        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache, no-store, must-revalidate',
            'X-Accel-Buffering' => 'no',   // Disable Nginx buffering
            'Connection'        => 'keep-alive',
        ]);
    }

    public function subscribePush(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|string',
            'p256dh'   => 'required|string',
            'auth'     => 'required|string',
        ]);

        $member = Auth::user()->member;

        PushSubscription::updateOrCreate(
            ['endpoint' => $request->endpoint],
            [
                'member_id' => $member->membership_number,
                'p256dh'    => $request->p256dh,
                'auth'      => $request->auth,
            ]
        );

        return response()->json(['ok' => true]);
    }

    public function unsubscribePush(Request $request)
    {
        $request->validate(['endpoint' => 'required|string']);

        PushSubscription::where('endpoint', $request->endpoint)->delete();

        return response()->json(['ok' => true]);
    }

    public function vapidPublicKey()
    {
        return response()->json(['key' => config('app.vapid_public_key')]);
    }
}
