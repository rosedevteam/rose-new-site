<?php

namespace Modules\Analytics\Http\client;

use Cache;
use Http;
use Illuminate\Http\Client\ConnectionException;

class ApiClient
{
    private string $url = 'https://data3.nadpco.com/api/';

    private static function getToken()
    {
        return Cache::get('nadpco-api-token');
    }

    public function token()
    {
        Cache::remember('nadpco-api-token', 60 * 24, function () {
            try {
                $response = Http::withBasicAuth(
                    config('services.nadpco_api.username'),
                    config('services.nadpco_api.password'),
                )->post($this->url . 'v2/Token');
                return json_decode($response->body(), true)['token'];
            } catch (ConnectionException $e) {
                dd($e->getMessage());
            }
        });
        dd(self::getToken());
    }

    public function companies()
    {
        $response = Http::get($this->url . '/v3/BaseInfo/Companies');
        dd(json_decode($response->body(), true));
    }

    public function indices()
    {
        $response = Http::get('https://data.nadpco.com/v1/baseInfo/Indices');
        dd(json_decode($response->body(), true));
    }

    public function trades($id)
    {
        try {
            $response = Http::withToken(self::getToken())
                ->withQueryParameters(['companyId' => $id])
                ->get($this->url . '/v3/TS/RealTimeTradesToday');
            dd(json_decode($response->body(), true));
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }

    public function legalTrades($id)
    {
        try {
            $response = Http::withToken(self::getToken())
                ->withQueryParameters(['companyId' => $id,])
                ->get($this->url . '/v3/TS/RealTimeLegalTradesToday');
            dd(json_decode($response->body(), true));
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }

    public function indexValues($id)
    {
        try {
            $response = Http::withToken(self::getToken())
                ->withQueryParameters(['indexId' => $id])
                ->get($this->url . '/v3/TS/RealTimeIndexValuesToday');
            dd(json_decode($response->body(), true));
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }

    public function bidAsk($id)
    {
        try {
            $response = Http::withToken(self::getToken())
                ->withQueryParameters(['companyId' => $id])
                ->get($this->url . '/v3/TS/RealTimeBidAskToday');
            dd(json_decode($response->body(), true));
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }
}
