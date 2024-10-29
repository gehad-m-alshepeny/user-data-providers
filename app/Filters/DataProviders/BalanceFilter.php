<?php

namespace App\Filters\DataProviders;

use Closure;

class BalanceFilter
{
    protected $balanceMin;
    protected $balanceMax;

    public function __construct($balanceMin, $balanceMax)
    {
        $this->balanceMin = $balanceMin;
        $this->balanceMax = $balanceMax;
    }

    public function __invoke($data, Closure $next)
    {
        $filtered = collect($data)->filter(function ($item) {
            return $item['parentAmount'] >= $this->balanceMin && $item['parentAmount'] <= $this->balanceMax;
        });

        return $next($filtered->toArray());
    }
}
