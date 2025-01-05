<?php

namespace App\Http\Controllers;

use Arr;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Database\Eloquent\Model;

abstract class Controller
{
    use SEOTools;

    protected static function log(?Model $model, array $properties, string $message)
    {
        if (isset($properties['before'], $properties['after'])) {

            $properties['before'] = Arr::except($properties['before'], ['updated_at']);
            $properties['after'] = Arr::except($properties['after'], ['updated_at']);

            $difference = ['before' => [], 'after' => []];
            foreach ($properties['before'] as $key => $beforeValue) {
                $afterValue = $properties['after'][$key];
                if ($afterValue != $beforeValue) {
                    $difference['before'][$key] = $beforeValue;
                    $difference['after'][$key] = $afterValue;
                }
            }
            $properties = $difference;
        }

        if ($model) {
            $properties['id'] = $model->id;
        }
        $properties = json_encode($properties, JSON_UNESCAPED_UNICODE);

        $log = activity()
            ->causedBy(auth()->user())
            ->withProperties($properties);
        if ($model) {
            $log->performedOn($model);
        }
        $log->log($message);
    }
}
