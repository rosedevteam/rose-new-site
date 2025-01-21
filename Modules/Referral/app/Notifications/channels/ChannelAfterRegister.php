<?php

namespace Modules\Referral\Notifications\channels;

use Kavenegar\KavenegarApi;

class ChannelAfterRegister
{
    public function send($notifiable, $notification)
    {
        try{
            $data = $notification->toChannelAfterRegister($notifiable);
            $receptor = $data['phone'];
            $token = $data['name'];
            $score = $data['score'];

            $template= 'ReferralAfterRegister';
            //Send null for tokens not defined in the template
            //Pass token10 and token20 as parameter 6th and 7th

            $kavenegar = new KavenegarApi(config('services.sms.api'));

            $res = $kavenegar->VerifyLookup($receptor, $token , $score , '' , $template);
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
