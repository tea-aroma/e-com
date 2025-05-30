<?php

namespace App\Http\Api\Products;


use App\Data\ProductDescriptions\ProductDescriptionDataAttributes;
use App\Data\Products\ProductDataAttributes;
use App\Data\Products\ViewProductDataOptions;
use App\Http\Api\ApiController;
use App\Http\Requests\Products\ProductRequest;
use App\Repositories\Products\ProductDescriptionRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Products\ViewProductRepository;
use App\Standards\ApiResponse\Classes\ApiResponse;
use App\Standards\Enums\ErrorMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * Provides actions for Products.
 */
class ProductsController extends ApiController
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
            $record = ViewProductRepository::query()->find($request->get('id'));
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
            $options = ViewProductDataOptions::fromArray($request->all());

            $records = ViewProductRepository::query()->records($options);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            return ApiResponse::error(ErrorMessage::INVALID_DATA->value);
        }

        return ApiResponse::success($records->toArray(), '');
    }

    /**
     * @param ProductRequest $request
     *
     * @return JsonResponse
     */
    public function create(ProductRequest $request): JsonResponse
    {
        try
        {
            DB::beginTransaction();

            $productAttributes = ProductDataAttributes::fromArray($request->all());

            $productDescriptionAttributes = ProductDescriptionDataAttributes::fromArray($request->all());

            $product = ProductRepository::query()->write($productAttributes);

            $productDescriptionAttributes->description = $request->post('product_description');

            $productDescriptionAttributes->product_id = $product->id;

            ProductDescriptionRepository::query()->write($productDescriptionAttributes);

            DB::commit();

            $record = ViewProductRepository::query()->find($product->id);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());

            return ApiResponse::error(ErrorMessage::INVALID_DATA->value);
        }

        return ApiResponse::success($record->toArray(), '');
    }
}
