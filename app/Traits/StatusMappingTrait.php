<?php

namespace App\Traits;

trait StatusMappingTrait
{
    protected function mapStatus(array $statusMap, &$value)
    {
        $value['status'] = $statusMap[$value['status']] ?? 'unknown';
    }
}
