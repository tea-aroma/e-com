<?php

namespace App\Http\Api\Authorization;


use App\Data\Users\UserDataAttributes;
use App\Http\Api\ApiController;
use App\Http\Requests\Api\Authorization\RegisterRequest;
use App\Repositories\Users\UserRepository;
use App\Standards\ApiResponse\Classes\ApiResponse;
use App\Standards\Enums\ApiTokenName;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


/**
 * Provides logic actions for Register.
 */
class RegisterController extends ApiController
{
    /**
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $attributes = new UserDataAttributes($request->post());

        $attributes->password = Hash::make($request->post('password'));

        $user = UserRepository::query()->write($attributes);

        $token = $user->createToken(ApiTokenName::DEFAULT->value)->plainTextToken;

        return ApiResponse::success($user, $token);
    }
}
