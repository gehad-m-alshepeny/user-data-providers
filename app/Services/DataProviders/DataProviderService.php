<?php

namespace App\Services\DataProviders;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\LazyCollection;
use App\Factories\DataProviders\DataProviderFactory;
use Illuminate\Pipeline\Pipeline;
use App\Filters\DataProviders\StatusFilter;
use App\Filters\DataProviders\CurrencyFilter;
use App\Filters\DataProviders\BalanceFilter;
use App\Helpers\Pagination; 

class DataProviderService
{

    protected $pagination;

    public function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @param array $data
     * @return array
     */
    public function getUsers(array $data): array
    {
        $page = $data['page'] ?? 1;
        $perPage = $data['perPage'] ?? 10;

        $provider = $data['provider'] ?? null;
        $data = [];

        // Get the list of providers
        $providers = $provider ? [$provider] : array_keys(Config::get('dataproviders'));

        foreach ($providers as $providerName) {
            $dataProvider = DataProviderFactory::create($providerName);

            // Get data from the provider
            $providerData = $dataProvider->getUsers();

            $filteredData = [];
            LazyCollection::make($providerData)
                ->chunk(1000)
                ->each(function ($chunk) use ($data, &$filteredData) {
                    $filteredChunk = $this->applyFilters($chunk->toArray(), $data);
                    $filteredData[] = is_array($filteredChunk) ? $filteredChunk : $filteredChunk->toArray();
                });

            $data = array_merge($data, ...$filteredData);
        }

        // Paginate the data after filtering
        $paginatedData= $this->pagination->paginate($data, $page, $perPage);
        return [
            'data' => $paginatedData['data'], 
            'pagination' => $paginatedData['pagination'],
        ];
    }

     /**
     * Apply the filters using Laravel Pipeline.
     *
     * @param array $data
     * @param array $validatedData
     * @return array
     */
    public function applyFilters($data, array $validatedData)
    {
        $filters = [];

        if (isset($validatedData['status'])) {
            $filters[] = new StatusFilter($validatedData['status']);
        }

        if (isset($validatedData['currency'])) {
            $filters[] = new CurrencyFilter($validatedData['currency']);
        }

        if (isset($validatedData['balanceMin']) && isset($validatedData['balanceMax'])) {
            $filters[] = new BalanceFilter($validatedData['balanceMin'], $validatedData['balanceMax']);
        }

        return app(Pipeline::class)
            ->send($data)
            ->through($filters)
            ->thenReturn();
    }

}
