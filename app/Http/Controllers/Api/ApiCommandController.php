<?php

namespace App\Http\Controllers\Api;

use App\Classes\Helpers\ModelHelper;
use App\Model\{Brands, Service, ServiceCategory, Payment};
use App\Http\Controllers\Controller;
use Exception;
use Error;
use ErrorException;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="ReferenceBooks",
 *     description="Request return of list reference books",
 * )
 * Class ApiCommandController
 * @package App\Http\Controllers\Api
 */
class ApiCommandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('checkActiveUser');
    }

    /**
     * @OA\Get(
     *     path="/payment_options",
     *     operationId="getPayments",
     *     tags={"ReferenceBooks"},
     *     summary="Returns list of payments",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\JsonContent(
     *              type="array",
     *             @OA\Items(ref="#/components/schemas/Payments")
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function payments()
    {
        try {
            ModelHelper::getReferenceList(Payment::class, $result);
            return response()->json($result ?? []);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/brands",
     *     operationId="getBrands",
     *     tags={"ReferenceBooks"},
     *     summary="Returns list of brands",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *          @OA\JsonContent(
     *              type="array",
     *             @OA\Items(ref="#/components/schemas/Brands")
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function brands()
    {
        try {
            ModelHelper::getReferenceList(Brands::class, $result);
            return response()->json($result ?? []);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/services",
     *     operationId="getServices",
     *     tags={"ReferenceBooks"},
     *     summary="Returns list of services",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *          @OA\JsonContent(
     *              type="array",
     *             @OA\Items(ref="#/components/schemas/Service")
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function services()
    {
        try {
            ModelHelper::getReferenceList(Service::class, $result);
            return response()->json($result ?? []);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/category",
     *     operationId="getCategory",
     *     tags={"ReferenceBooks"},
     *     summary="Returns list of category",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function category()
    {
        try {
            ModelHelper::getReferenceList(ServiceCategory::class, $result);
            return response()->json($result ?? []);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
