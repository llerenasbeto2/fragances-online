<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try{
            //auth()->logout();
            auth('api')->logout();
            return response()->json(['message' => 'Successfully logged out']);

        }catch(JWTException $exception){
            return response()->json(['message' => 'Token not found.'], status:401);
            
        }
    }
}
