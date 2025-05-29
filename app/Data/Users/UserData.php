<?php

namespace App\Data\Users;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class UserData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $email_verified_at;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var string
     */
    public string $remember_token;

    /**
     * @var string
     */
    public string $created_at;

    /**
     * @var string
     */
    public string $updated_at;
}
