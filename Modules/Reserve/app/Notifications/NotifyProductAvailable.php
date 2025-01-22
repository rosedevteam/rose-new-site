<?php

namespace Modules\Reserve\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NotifyProductAvailable extends Notification
{

    use Queueable;

    protected $phone;
    protected $product;

    public function __construct($phone, $product)
    {
        $this->phone = $phone;
        $this->product = $product;
    }

    public function via($notifiable)
    {
        //
    }

    public function toSms($notifiable): array
    {
        return [
            'template_id' => config('services.sms.verify'),
            'phone' => $this->phone,
            'product' => $this->product,
        ];
    }
}
