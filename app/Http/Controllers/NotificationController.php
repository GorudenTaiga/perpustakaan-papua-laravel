<?php

namespace App\Http\Controllers;

use App\Models\Notification;
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
}
