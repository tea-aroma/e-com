<?php

namespace App\Http\Api\Payments;


use App\Http\Api\ApiController;
use App\Http\Requests\Payments\PaymentAcceptRequest;
use App\Standards\ApiResponse\Classes\ApiResponse;
use App\Standards\Payment\PaymentHistory;
use Illuminate\Http\JsonResponse;


/**
 * Provides actions for Payments.
 */
class PaymentController extends ApiController
{
    /**
     * @param PaymentAcceptRequest $request
     *
     * @return JsonResponse
     */
    public function accept(PaymentAcceptRequest $request): JsonResponse
    {
        $paymentHistory = new PaymentHistory($request->input('token'));

        $isAccept = $paymentHistory->accept();

        if (!$isAccept)
        {
            return ApiResponse::error('');
        }

        return ApiResponse::success([], 'Payment accepted.');
    }
}
