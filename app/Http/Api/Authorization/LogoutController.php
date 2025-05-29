<?php

namespace App\Http\Api\Authorization;


use App\Http\Api\ApiController;
use App\Standards\ApiResponse\Classes\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 *Provides logic actions for Logout.
 */
class LogoutController extends ApiController
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::success([], 'Logged out successfully.');
    }
}
