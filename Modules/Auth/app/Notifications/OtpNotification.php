<?php

namespace Modules\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Modules\Auth\Notifications\channel\SmsPanel;

class OtpNotification extends Notification
{
    use Queueable;

    protected $phone;
    protected $otp;

    public function __construct($phone, $otp)
    {
        $this->phone = $phone;
        $this->otp = $otp;
    }
    public function via($notifiable): array
    {
        return [SmsPanel::class];
    }

    public function toSms($notifiable): array
    {
        return [
            'template_id' => config('services.sms.verify'),
            'phone' => $notifiable->phone,
            'otp' => $notifiable->otp,
        ];
    }
}
