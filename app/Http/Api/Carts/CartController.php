<?php

namespace App\Http\Api\Carts;


use App\Data\CartProducts\ViewCartProductDataOptions;
use App\Data\Carts\CartDataAttributes;
use App\Repositories\CartProducts\ViewCartProductsRepository;
use App\Repositories\Carts\CartRepository;
use App\Standards\ApiResponse\Classes\ApiResponse;
use App\Standards\Enums\ErrorMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * Provides actions for Cart.
 */
class CartController
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
            $values = CartDataAttributes::fromArray(user()->toArray());

            $attributes = CartDataAttributes::fromArray([ 'user_id' => user()->id ]);

            $record = CartRepository::query()->findOrCreate($attributes, $values);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            return ApiResponse::error(ErrorMessage::INVALID_DATA->value);
        }

        return ApiResponse::success($record->toArray(), '');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function products(Request $request): JsonResponse
    {
        try
        {
            $options = new ViewCartProductDataOptions($request->all());

            $records = ViewCartProductsRepository::query()->records($options);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            return ApiResponse::error(ErrorMessage::INVALID_DATA->value);
        }

        return ApiResponse::success($records->toArray(), '');
    }
}
