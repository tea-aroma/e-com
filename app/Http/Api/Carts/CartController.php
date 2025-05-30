<?php

namespace App\Http\Api\Carts;


use App\Data\CartProducts\ViewCartProductDataOptions;
use App\Http\Requests\Api\Carts\CartProductAppendRequest;
use App\Http\Requests\Api\Carts\CartProductRemoveRequest;
use App\Http\Requests\Payments\PaymentRequest;
use App\Repositories\CartProducts\ViewCartProductsRepository;
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
            $record = cart()->getCart();
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

    /**
     * @param CartProductAppendRequest $request
     *
     * @return JsonResponse
     */
    public function append(CartProductAppendRequest $request): JsonResponse
    {
        try
        {
            $record = cart()->append($request->post('product_id'), $request->post('quantity'));
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            return ApiResponse::error(ErrorMessage::INVALID_DATA->value);
        }

        return ApiResponse::success($record->toArray(), '');
    }

    /**
     * @param CartProductRemoveRequest $request
     *
     * @return JsonResponse
     */
    public function delete(CartProductRemoveRequest $request): JsonResponse
    {
        try
        {
            $id = cart()->delete($request->post('product_id'));
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            return ApiResponse::error(ErrorMessage::INVALID_DATA->value);
        }

        return ApiResponse::success([], 'Product successfully removed.');
    }

    /**
     * @param PaymentRequest $request
     *
     * @return JsonResponse
     */
    public function payment(PaymentRequest $request): JsonResponse
    {
        try
        {
            if (cart()->isEmpty())
            {
                return ApiResponse::error(ErrorMessage::CART_EMPTY->value);
            }

            $token = cart()->payment($request);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            return ApiResponse::error(ErrorMessage::INVALID_DATA->value);
        }

        return ApiResponse::success([], $token);
    }
}
