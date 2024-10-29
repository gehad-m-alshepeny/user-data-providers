<?php

namespace App\Factories\DataProviders;

use Illuminate\Support\Facades\Config;
use App\Contracts\DataProviders\DataProviderInterface;

class DataProviderFactory
{
    public static function create(string $provider): DataProviderInterface
    {
        $providerClass = Config::get("dataproviders.$provider.class");

        if (!$providerClass) {
            throw new \InvalidArgumentException("Provider $provider not found in configuration.");
        }

        return app($providerClass); 
    }
}
