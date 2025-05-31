<?php

namespace App\Http\Api\Orders;


use App\Data\Orders\ViewOrderDataOptions;
use App\Repositories\Orders\ViewOrderRepository;
use App\Standards\ApiResponse\Classes\ApiResponse;
use App\Standards\Enums\ErrorMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * Provides actions for Cart.
 */
class OrdersController
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        try
        {
            $record = ViewOrderRepository::query()->find($request->get('id'));
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            return ApiResponse::error(ErrorMessage::INVALID_DATA->value);
        }

        return ApiResponse::success($record?->toArray() ?? [], '');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        try
        {
            $options = ViewOrderDataOptions::fromArray([ user()->id ]);

            $records = ViewOrderRepository::query()->records($options);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            return ApiResponse::error(ErrorMessage::INVALID_DATA->value);
        }

        return ApiResponse::success($records->toArray(), '');
    }
}
