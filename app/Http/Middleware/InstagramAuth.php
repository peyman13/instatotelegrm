<?php

namespace App\Http\Middleware;
use MetzWeb\Instagram\Instagram;

use Redirect;
use Closure;

class InstagramAuth
{

    public $instagram;

    public function __construct(){
        $this->instagram = new Instagram(array(
            'apiKey'      => config('instagram.apiKey'),
            'apiSecret'   => config('instagram.apiSecret'),
            'apiCallback' => config('instagram.apiCallback')
        ));
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('token')){
            return $next($request);
        }
        else{
            return Redirect::to($this->instagram->getLoginUrl(['basic','public_content','follower_list']));
        }
    }
}
