<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponseWithHttpStatus;
use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class IsAdmin
{
    use ApiResponseWithHttpStatus;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = Auth::user();
        if(auth()->user()->is_admin == 1){
            return $next($request);
        }
   
        return $this->apiResponse("You don't have permission to access!",null,null,Response::HTTP_FORBIDDEN,false);
    }
}
