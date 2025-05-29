<?php

namespace App\Http\Api\Authorization;


use App\Http\Requests\Api\Authorization\LoginRequest;
use App\Repositories\Users\UserRepository;
use App\Standards\ApiResponse\Classes\ApiResponse;
use App\Standards\Enums\ApiTokenName;
use App\Standards\Enums\ErrorMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


/**
 * Provides logic actions for Login.
 */
class LoginController
{
    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = UserRepository::query()->findByCode($request->post('email'));

        if (!$user || !Hash::check($request->post('password'), $user->getAttributeValue('password')))
        {
            return ApiResponse::error(ErrorMessage::INVALID_DATA->format(), 401);
        }

        $token = $user->createToken(ApiTokenName::DEFAULT->value)->plainTextToken;

        return ApiResponse::success($user, $token);
    }
}
