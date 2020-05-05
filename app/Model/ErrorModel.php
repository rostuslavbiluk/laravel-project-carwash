<?php

/**
 * @OA\Schema(
 *     schema="ErrorModel",
 *     @OA\Property(property="status", type="string", example="error"),
 * )
 */
class ErrorModel extends Exception
{
    /**
     * @OA\Property(format="int32");
     * @var int
     */
    public $code;

    /**
     * @OA\Property();
     * @var string
     */
    public $message;
}