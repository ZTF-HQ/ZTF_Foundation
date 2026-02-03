<?php

namespace App\Http\Controllers;

/**
* @OA\Info(
*       version="1.0",
*       title="ZTF Foundation Api Documentation",
*       description="These are the docuementation for ztf foundation api documentation",
*       @OA\Contact(
*                email="josiasdavidsuccess@gmail.com"
*           )
*       )
*       @OA\SecurityScheme(
*           securityScheme="BearerAuth",
*           type="http",
*           scheme="bearer",
*           bearerFormat="JWT"
*       )
*           
*/
abstract class Controller
{

}
