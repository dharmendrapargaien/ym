<?php

namespace App\Http\Middleware;

use Closure;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //if request does not have uesr id
        if(!$request->has('user_id')) {

            return \Response::json(['status' => 'fail'], 400);
        } 
        
        //fetching the user id according to access token
        $token = $request->get('access_token');
        $oauthAccessTokens = \DB::table('oauth_access_tokens');
        $oauthSessions = \DB::table('oauth_sessions');

        $session_id = $oauthAccessTokens->whereId($token)->first()->session_id;
        $user_id = $oauthSessions->whereId($session_id)->first()->owner_id;

        //if access token do not match the un authorizing
        if($user_id != $request->get('user_id'))
            return \Response::json(['status' => 'fail'], 401);

        return $next($request);
    }
}
