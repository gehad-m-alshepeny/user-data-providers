<?php

namespace App\Filters\DataProviders;

use Closure;

class CurrencyFilter
{
    protected $currency;

    public function __construct($currency)
    {
        $this->currency = $currency;
    }

    public function __invoke($data, Closure $next)
    {
        $filtered = collect($data)->filter(function ($item) {
            return $item['currency'] === $this->currency;
        });

        return $next($filtered->toArray());
    }
}
