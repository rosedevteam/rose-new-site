<?php

namespace App\Traits;

trait AwardScore
{
    public function awardScore(int $score, string $log, string $label)
    {
        auth()->user()->scores()->create([
            'score' => $score,
            'log' => $log,
            'label' => $label,
            'type' => 'credit',
        ]);

        $message = 'شما ' . $score . ' امتیاز گرفتید';
        toast($message, 'success', 'top-right');
    }
}
