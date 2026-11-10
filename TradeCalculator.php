<?php

namespace App\Services;

use App\Models\Fruit;

class TradeCalculator
{
    public function total(array $items): int
    {
        $total = 0;
        foreach ($items as $item) {
            $fruit = Fruit::find($item['id'] ?? 0);
            if ($fruit) {
                $total += $fruit->value * max(1, (int) ($item['qty'] ?? 1));
            }
        }
        return $total;
    }

    public function evaluate(array $offer, array $receive): array
    {
        $left = $this->total($offer);
        $right = $this->total($receive);
        $diff = $right - $left;
        $pct = $left > 0 ? ($diff / $left) * 100 : ($right > 0 ? 100 : 0);
        $limit = config('compass.fair_threshold');
        $result = $pct > $limit ? 'WIN' : ($pct < -$limit ? 'LOSE' : 'FAIR');
        return [
            'offer_total' => $left,
            'receive_total' => $right,
            'difference' => $diff,
            'percent' => round($pct, 1),
            'result' => $result,
            'threshold' => $limit,
        ];
    }
}
