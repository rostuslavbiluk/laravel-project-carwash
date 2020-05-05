<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @OA\Schema(
 *     schema="Order",
 *     type="object",
 *     title="Order - example return request",
 *     @OA\Property(property="id", format="int64", type="integer", readOnly=true),
 *     @OA\Property(property="user_id", format="int64", type="integer", example="1"),
 *     @OA\Property(property="profile_id", format="int64", type="integer", example="1"),
 *     @OA\Property(property="entity_id", format="int64", type="integer", example="1"),
 *     @OA\Property(property="payment_id", format="int64", type="integer", example="1"),
 *     @OA\Property(property="services_id", format="int64", type="integer", example="1"),
 *     @OA\Property(property="cost", type="integer"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="comment", type="string"),
 *     @OA\Property(property="params", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Order extends BaseModel
{
    protected $guarded = ['id'];
}
