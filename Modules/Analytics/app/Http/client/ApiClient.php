<?php

namespace Modules\Analytics\Http\client;

use Cache;
use Http;
use Illuminate\Http\Client\ConnectionException;

class ApiClient
{
    private const url = "https://data3.nadpco.com/api/";

    private static function getToken()
    {
        $token = Cache::get('nadpco-api-token');
        if (!$token) {
            $token = self::token();
        }
        return $token;
    }

    private static function token()
    {
        return Cache::remember('nadpco-api-token', 60 * 24, function () {
            try {
                $response = Http::withBasicAuth(
                    config('services.nadpco_api.username'),
                    config('services.nadpco_api.password'),
                )->post(self::url . 'v2/Token');
                return json_decode($response->body(), true)['token'];
            } catch (ConnectionException $e) {
                dd($e->getMessage());
            }
        });
    }

    public static function companies()
    {
        return json_decode(Http::get(self::url . '/v3/BaseInfo/Companies'), true);
    }

    public static function indices()
    {
        return json_decode(Http::get('https://data.nadpco.com/v1/baseInfo/Indices'), true);
    }

    public static function trades($id)
    {
        try {
            $response = Http::withToken(self::getToken())
                ->withQueryParameters(['companyId' => $id])
                ->get(self::url . '/v3/TS/RealTimeTradesToday');
            return json_decode($response->body(), true);
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }

    public static function legalTrades($id)
    {
        try {
            $response = Http::withToken(self::getToken())
                ->withQueryParameters(['companyId' => $id])
                ->get(self::url . '/v3/TS/RealTimeRealLegalTradesToday');
            return json_decode($response->body(), true);
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }

    public static function indexValues($id)
    {
        try {
            $response = Http::withToken(self::getToken())
                ->withQueryParameters(['indexId' => $id])
                ->get(self::url . '/v3/TS/RealTimeIndexValuesToday');
            return json_decode($response->body(), true);
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }

    public static function bidAsk($id)
    {
        try {
            $response = Http::withToken(self::getToken())
                ->withQueryParameters(['companyId' => $id])
                ->get(self::url . '/v3/TS/RealTimeBidAskToday');
            return json_decode($response->body(), true);
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }
}
