<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * @OA\Info(
 *     title="Api documentations for project",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="rostuslavbiluk@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Tag(
 *     name="Main",
 *     description="Request return of list reference books",
 * )
 * @OA\OpenApi(
 *      @OA\Server(
 *          description="CarWash API documentation",
 *          url="http://laravel.loc/api"
 *      ),
 *     @OA\ExternalDocumentation(
 *          description="find more info here",
 *          url="https://swagger.io/about"
 *      )
 * )
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="X-APP-ID",
 *     securityScheme="X-APP-ID"
 * )
 *
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
