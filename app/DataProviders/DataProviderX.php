<?php

namespace App\DataProviders;

use App\Contracts\DataProviders\DataProviderInterface;
use Cerbero\JsonParser\JsonParser;
use Illuminate\Support\Facades\Log;
use App\Traits\StatusMappingTrait;

class DataProviderX implements DataProviderInterface
{
    use StatusMappingTrait;

    protected $statusMap;

    public function __construct()
    {
        $this->statusMap = [
            1 => 'authorised',
            2 => 'decline',
            3 => 'refunded',
        ];
    }

    public function getUsers(): array
    {
        $data = [];
        try {
            $jsonParser = new JsonParser(storage_path('app/data/dataproviderX.json'));
            $jsonParser->traverse(function ($value, $key, JsonParser $parser) use (&$data) {
                $this->mapStatus($this->statusMap, $value);
                $data[] = $value;
            });
        } catch (\Exception $e) {
            Log::error('Error occurred in DataProviderX: ' . $e->getMessage());
            return [];
        }

        return $data;
    }
}
