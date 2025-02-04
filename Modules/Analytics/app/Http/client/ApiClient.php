<?php

namespace Modules\Analytics\Http\client;

use Http;

class ApiClient
{
    private const url = "https://apis.sourcearena.ir/api/";

    private function performRequest(array $parameters)
    {
        $parameters['token'] = config('services.sourcearena.token');
        $response = Http::get(self::url, $parameters);

        $data = json_decode($response->body(), true);

        dd($data);
        return $data;
    }

    public function getCompanies()
    {
        return $this->performRequest([
            'all' => '',
            'type' => '2',
        ]);
    }

    public function getIndices()
    {
        return $this->performRequest([
            'market' => 'indices',
        ]);
    }

    public function getBourseData()
    {
        return $this->performRequest([
            'market' => 'bourse',
            'days' => 7,
        ]);

    }
}
