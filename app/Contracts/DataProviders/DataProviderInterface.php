<?php

namespace App\Contracts\DataProviders;

interface DataProviderInterface
{
    public function getUsers(): array;
}