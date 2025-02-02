<?php

namespace Modules\Analytics\Http\client;

use Http;
use Modules\Analytics\Models\Company;

class ApiClient
{
    private const url = "https://apis.sourcearena.ir/api/";

    public function all()
    {
        try {
            $response = Http::get(self::url, [
                'token' => config('services.sourcearena.token'),
                'all' => '',
                'type' => '2',
            ]);

            $data = json_decode($response->body(), true);

            foreach ($data as $item) {
                Company::upsert([
                    'name' => $item['name'],
                    'full_name' => $item['full_name'],
                    'first_price' => $item['first_price'],
                    'close_price' => $item['close_price'],
                    'close_price_change' => $item['close_price_change'],
                    'close_price_change_percent' => $item['close_price_change_percent'],
                    'final_price' => $item['final_price'],
                    'final_price_change' => $item['final_price_change'],
                    'final_price_change_percent' => $item['final_price_change_percent'],
                    'yesterday_price' => $item['yesterday_price'],
                    'trade_number' => $item['trade_number'],
                    'trade_volume' => $item['trade_volume'],
                    'trade_value' => $item['trade_value'],
                    'market_value' => $item['market_value'],
                    'all_stocks' => $item['all_stocks'],
                    'real_buy_volume' => $item['real_buy_volume'],
                    'co_buy_volume' => $item['co_buy_volume'],
                    'real_sell_volume' => $item['real_sell_volume'],
                    'co_sell_volume' => $item['co_sell_volume'],
                    'real_buy_count' => $item['real_buy_count'],
                    'co_buy_count' => $item['co_buy_count'],
                    'real_sell_count' => $item['real_sell_count'],
                    'co_sell_count' => $item['co_sell_count'],
                    'eps' => $item['eps'],
                    'p_e' => $item['P:E'],
                ]);
            }

        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
