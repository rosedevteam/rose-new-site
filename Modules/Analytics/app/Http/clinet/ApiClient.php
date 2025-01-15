<?php

use Illuminate\Http\Client\ConnectionException;

class ApiClient
{
    private string $url = 'https://data3.nadpco.com/api/';

    public function token()
    {
        try {
            $response = Http::withBasicAuth(
                config('services.nadpco_api.username'),
                config('services.nadpco_api.password'),
            )->post($this->url . 'v2/Token');
            $token = json_decode($response->body(), true)['token'];
            config(['services.nadpco_api.token' => $token]);
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
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
            $response = Http::withToken(config('services.nadpco_api.token'))
                ->withQueryParameters([
                    'companyId' => $id
                ])->get($this->url . '/v3/TS/RealTimeTradesToday');
            dd(json_decode($response->body(), true));
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }

    public function legalTrades($id)
    {
        try {
            $response = Http::withToken(config('services.nadpco_api.token'))
                ->withQueryParameters([
                    'companyId' => $id,
                ])->get($this->url . '/v3/TS/RealTimeLegalTradesToday');
            dd(json_decode($response->body(), true));
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }

    public function indexValues($id)
    {
        try {
            $response = Http::withToken(config('services.nadpco_api.token'))
                ->withQueryParameters([
                    'indexId' => $id
                ])->get($this->url . '/v3/TS/RealTimeIndexValuesToday');
            dd(json_decode($response->body(), true));
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }

    public function bidAsk($id)
    {
        try {
            $response = Http::withToken(config('services.nadpco_api.token'))
                ->withQueryParameters([
                    'companyId' => $id
                ])->get($this->url . '/v3/TS/RealTimeBidAskToday');
            dd(json_decode($response->body(), true));
        } catch (ConnectionException $e) {
            dd($e->getMessage());
        }
    }
}
