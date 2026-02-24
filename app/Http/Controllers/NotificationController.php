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
}
