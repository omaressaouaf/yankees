<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderNotification extends Notification
{
    use Queueable;
    public $order;
    public $event_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order ,string $event_name)
    {
        $this->order = $order;
        $this->event_name = $event_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "order" => $this->order,
            'url' => '/admin/orders/' . $this->order->id,
            'event_name' => $this->event_name
        ];
    }
}
