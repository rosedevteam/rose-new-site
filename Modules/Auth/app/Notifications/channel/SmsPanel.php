<?php

namespace Modules\Auth\Notifications\channel;


use Kavenegar\KavenegarApi;
use Kavenegar\Laravel\Message\KavenegarMessage;

class SmsPanel
{
    public function send($notifiable, $notification)
    {

        try{
            $data = $notification->toSms($notifiable);
            $receptor = $data['phone'];
            $token = $data['otp'];
            $template="verify";
            //Send null for tokens not defined in the template
            //Pass token10 and token20 as parameter 6th and 7th

            $kavenegar = new KavenegarApi(config('services.sms.api'));

            $kavenegar->VerifyLookup($receptor, $token , '' , '' , $template);

        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
    }
}
