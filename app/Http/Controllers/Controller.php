<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="SOUND INSIGHTS",
 *      description="RESTFUL API for sound insights web application",
 *      @OA\Contact(
 *          name="Ibrahimolayinkaa@gmail.com",
 *          email="Ibrahimolayinkaa@gmail.com",
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * 
 * 
 * *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="host server"
 *  )
 *
 * 
 * 
 *  @OA\Server(
*      url="http://localhost:5000",
 *      description="Localhost on port 5000"
 * )
 * 
 *
 * 
 * 
 * @OA\Tag(
 *      name="Sound Insights",
 *      description="This is sound insights LARAVEL RESTFUL API",
 * )
 * 
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
 
}
