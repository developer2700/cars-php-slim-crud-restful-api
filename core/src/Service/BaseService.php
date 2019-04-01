<?php

namespace App\Service;

use App\Exception\CarException;
use Respect\Validation\Validator as v;

/**
 * Base Service.
 */
abstract class BaseService
{
    /**
     * Validate and sanitize a  name.
     *
     * @param string $name
     * @return string
     * @throws CarException
     */
    protected static function validateName($name)
    {
        if (!v::alnum()->length(2, 100)->validate($name)) {
            throw new UserException('Invalid name.', 400);
        }

        return $name;
    }

    /**
     * Validate and sanitize a email address.
     *
     * @param string $emailValue
     * @return string
     * @throws UserException
     */
    protected static function validateEmail($emailValue)
    {
        $email = filter_var($emailValue, FILTER_SANITIZE_EMAIL);
        if (!v::email()->validate($email)) {
            throw new UserException('Invalid email', 400);
        }

        return $email;
    }

    /**
     * Validate and sanitize a car name.
     *
     * @param string $name
     * @return string
     * @throws CarException
     */
    protected static function validateCarName($name)
    {
        if (!v::length(2, 100)->validate($name)) {
            throw new CarException('Invalid name.', 400);
        }

        return $name;
    }

    /**
     * Validate and sanitize a car status.
     *
     * @param int $status
     * @return int
     * @throws CarException
     */
    protected static function validateCarStatus($status)
    {
        if (!v::numeric()->between(0, 1)->validate($status)) {
            throw new CarException('Invalid status', 400);
        }

        return $status;
    }

    /**
     * Validate and sanitize a note name.
     *
     * @param string $name
     * @return string
     * @throws CarException
     */
    protected static function validateCarModel($name)
    {
        if (!v::alnum()->length(2, 50)->validate($name)) {
            throw new CarException('The name of the car is invalid.', 400);
        }

        return $name;
    }
}
