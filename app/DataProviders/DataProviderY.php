<?php

namespace App\DataProviders;

use App\Contracts\DataProviders\DataProviderInterface;
use Cerbero\JsonParser\JsonParser;
use Illuminate\Support\Facades\Log;
use App\Traits\StatusMappingTrait;

class DataProviderY implements DataProviderInterface
{
    use StatusMappingTrait;

    protected $statusMap;

    public function __construct()
    {
        $this->statusMap = [
            100 => 'authorised',
            200 => 'decline',
            300 => 'refunded',
        ];
    }

    public function getUsers(): array
    {
        $data = [];
        try {
            $jsonParser = new JsonParser(storage_path('app/data/dataproviderY.json'));
            $jsonParser->traverse(function ($value, $key, JsonParser $parser) use (&$data) {
                $this->mapStatus($this->statusMap, $value);
                $data[] = $value;
            });
        } catch (\Exception $e) {
            Log::error('Error occurred in DataProviderY: ' . $e->getMessage());
            return [];
        }

        return $data;
    }
}
