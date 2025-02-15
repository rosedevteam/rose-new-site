<?php

namespace App\Traits;

trait AwardScore
{
    public function awardScore(int $score, string $log)
    {
        auth()->user()->scores()->create([
            'score' => $score,
            'log' => $log,
            'type' => 'credit',
        ]);
    }
}
