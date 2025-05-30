<?php

namespace App\Standards\ApiResponse\Classes;


use Illuminate\Http\JsonResponse;
use ReflectionClass;


/**
 * Provides the standard for the api response.
 */
class ApiResponse
{
    /**
     * @var array|object|null
     */
    public array | object | null $data = null;

    /**
     * @var string
     */
    public string $message = '';

    /**
     * @var int
     */
    public int $status = 200;

    /**
     * @var mixed
     */
    public mixed $errors = null;

    /**
     * @param array $array
     */
    private function __construct(array $array)
    {
        foreach ($array as $key => $value)
        {
            if (is_null($value))
            {
                continue;
            }

            $this->$key = $value;
        }
    }

    /**
     * Converts current instance to JsonResponse.
     *
     * @return JsonResponse
     */
    public function toJsonResponse(): JsonResponse
    {
        return new JsonResponse($this->getProperties());
    }

    /**
     * Gets properties.
     *
     * @return array
     */
    protected function getProperties(): array
    {
        $properties = [];

        $reflectionProperties = (new ReflectionClass($this))->getProperties();

        foreach ($reflectionProperties as $property)
        {
            $properties[ $property->getName() ] = $property->getValue($this);
        }

        return $properties;
    }

    /**
     * Gets the success response.
     *
     * @param array|object $data
     * @param string       $message
     * @param int          $status
     *
     * @return JsonResponse
     */
    public static function success(array | object $data, string $message, int $status = 200): JsonResponse
    {
        return self::fromArray([ 'data' => $data, 'message' => $message, 'status' => $status ]);
    }

    /**
     * Gets the error response.
     *
     * @param string     $message
     * @param int        $status
     * @param mixed|null $errors
     *
     * @return JsonResponse
     */
    public static function error(string $message, int $status = 200, mixed $errors = null): JsonResponse
    {
        return self::fromArray([ 'message' => $message, 'status' => $status, 'errors' => $errors ]);
    }

    /**
     * Creates an instance by the specified array and return a JsonResponse.
     *
     * @param array $array
     *
     * @return JsonResponse
     */
    public static function fromArray(array $array): JsonResponse
    {
        return (new static($array))->toJsonResponse();
    }
}
