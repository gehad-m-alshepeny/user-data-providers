<?php

namespace App\Http\Controllers\api\v1\DataProviders;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataProviders\DataProviderRequest;
use App\Services\DataProviders\DataProviderService;
use Exception;
use Illuminate\Http\JsonResponse;

class DataProviderController extends Controller
{
    protected $dataProviderService;

    public function __construct(DataProviderService $service)
    {
        $this->dataProviderService = $service;
    }

    public function index(DataProviderRequest $request): JsonResponse
    {
        try {
            $users = $this->dataProviderService->getUsers($request->validated()); 
            
            return response()->json([
                'status' => 'success',
                'data' => $users['data'], 
            ], 200);
        } catch (Exception $e) {
            \Log::error('Error fetching users: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching users. Please try again later.'
            ], 500);
        }
    }
}
