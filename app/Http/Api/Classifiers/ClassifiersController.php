<?php

namespace App\Http\Api\Classifiers;


use App\Data\Classifiers\ClassifierDataOptions;
use App\Http\Api\ApiController;
use App\Repositories\Classifiers\ClassifierRepository;
use App\Standards\ApiResponse\Classes\ApiResponse;
use App\Standards\Enums\ClassifierModel;
use App\Standards\Enums\ErrorMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * Provides actions for classifiers.
 */
class ClassifiersController extends ApiController
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        try
        {
            $options = new ClassifierDataOptions($request->all());

            $records = ClassifierRepository::forModel(ClassifierModel::fromName($options->classifier_model)->value)->records($options);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage(), $e->getTrace());

            return ApiResponse::error(ErrorMessage::INVALID_DATA->value, 422);
        }

        return ApiResponse::success($records->toArray(), '');
    }
}
