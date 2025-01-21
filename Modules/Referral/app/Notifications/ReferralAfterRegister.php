<?php

namespace Modules\Referral\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Referral\Notifications\channels\ChannelAfterRegister;

class ReferralAfterRegister extends Notification
{
    //todo make a global class for sms channels

    use Queueable;

    protected $name;
    protected $phone;
    protected $score;
    /**
     * Create a new notification instance.
     */
    public function __construct($phone , $name , $score)
    {
        $this->phone = $phone;
        $this->name = $name;
        $this->score = $score;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return [ChannelAfterRegister::class];
    }

    public function toChannelAfterRegister($notifiable)
    {
        return [
            'phone' => $this->phone,
            'name' => $this->name,
            'score' => $this->score
        ];
    }
}
