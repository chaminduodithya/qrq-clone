<?php

namespace App\Services;

use App\Models\Ticket;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushNotificationService
{
    public static function send(Ticket $ticket, string $title, string $body)
    {
        if (!$ticket->push_subscription) {
            return;
        }

        $auth = [
            'VAPID' => [
                'subject' => config('app.url'),
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        $subscription = Subscription::create($ticket->push_subscription);

        $webPush->queueNotification(
            $subscription,
            json_encode([
                'title' => $title,
                'body' => $body,
                'url' => route('join.queue', $ticket->queue->slug) . '?ticket=' . $ticket->id
            ])
        );

        foreach ($webPush->flush() as $report) {
            if (!$report->isSuccess()) {
                // Handle deletion of expired subscriptions if needed
                if ($report->isSubscriptionExpired()) {
                    $ticket->update(['push_subscription' => null]);
                }
            }
        }
    }
}
