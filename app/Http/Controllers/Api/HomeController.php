<?php

namespace App\Http\Controllers\Api;

use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Http\Controllers\Controller;

/**
 * @SWG\Swagger(
 *     basePath="/api",
 *     host="doska.local",
 *     schemes={"https"},
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Board API",
 *         description="HTTP JSON API",
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="OAuth2",
 *         type="oauth2",
 *         flow="password",
 *         tokenUrl="https://localhost:8080/oauth/token"
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header"
 *     ),
 *     @SWG\Definition(
 *         definition="ErrorModel",
 *         type="object",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     )
 * )
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @SWG\Get(
     *     path="/",
     *     tags={"Info"},
     *     @SWG\Response(
     *         response="200",
     *         description="API version",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="version", type="string")
     *         ),
     *     )
     * )
     */
    public function index()
    {
        return ['name' => 'Board Api'];
    }
}
