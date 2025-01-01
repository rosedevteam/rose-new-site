<?php

namespace App\traits;

trait ModelJson
{
    public function toJson($model)
    {
        return json_encode($model->toArray());
    }
}
