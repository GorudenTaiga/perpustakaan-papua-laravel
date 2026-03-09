<?php

namespace App\Services;

use App\Models\PushSubscription;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class WebPushService
{
    private WebPush $webPush;

    public function __construct()
    {
        $this->webPush = new WebPush([
            'VAPID' => [
                'subject'    => config('app.vapid_subject', 'mailto:admin@perpustakaan.id'),
                'publicKey'  => config('app.vapid_public_key'),
                'privateKey' => config('app.vapid_private_key'),
            ],
        ]);

        $this->webPush->setReuseVAPIDHeaders(true);
    }

    /**
     * Send a push notification to all subscriptions for a given member.
     */
    public function sendToMember(string $membershipNumber, string $title, string $body, array $data = []): void
    {
        $subscriptions = PushSubscription::where('member_id', $membershipNumber)->get();

        if ($subscriptions->isEmpty()) return;

        $payload = json_encode([
            'title' => $title,
            'body'  => $body,
            'icon'  => '/favicon_io/apple-touch-icon.png',
            'badge' => '/favicon_io/apple-touch-icon.png',
            'url'   => '/notifications',
            'data'  => $data,
        ]);

        $staleEndpoints = [];

        foreach ($subscriptions as $sub) {
            $subscription = Subscription::create([
                'endpoint'        => $sub->endpoint,
                'keys'            => [
                    'p256dh' => $sub->p256dh,
                    'auth'   => $sub->auth,
                ],
            ]);

            $this->webPush->queueNotification($subscription, $payload);
        }

        // Send all queued notifications and collect expired subscriptions
        foreach ($this->webPush->flush() as $report) {
            if (!$report->isSuccess()) {
                $statusCode = $report->getResponse()?->getStatusCode();
                // 404 or 410 means the subscription is no longer valid
                if (in_array($statusCode, [404, 410])) {
                    $staleEndpoints[] = $report->getEndpoint();
                }
            }
        }

        // Clean up stale subscriptions
        if (!empty($staleEndpoints)) {
            PushSubscription::whereIn('endpoint', $staleEndpoints)->delete();
        }
    }

    /**
     * Send to all members (broadcast).
     */
    public function sendToAll(string $title, string $body, array $data = []): void
    {
        $memberIds = PushSubscription::distinct()->pluck('member_id');
        foreach ($memberIds as $memberId) {
            $this->sendToMember($memberId, $title, $body, $data);
        }
    }
}
