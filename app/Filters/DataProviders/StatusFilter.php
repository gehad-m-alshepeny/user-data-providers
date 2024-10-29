<?php

namespace App\Filters\DataProviders;

use Closure;

class StatusFilter
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function __invoke($data, Closure $next)
    {
        $filtered = collect($data)->filter(function ($item) {
            return $item['status'] === $this->status;
        });

        return $next($filtered->toArray());
    }
}
