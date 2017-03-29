<?php

namespace App\Http\Middleware;

use Input;
use Auth;
use Closure;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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
        if ($this->auth->guest()) {
            return redirect()->route('user.login')->withErrors('请先登录');
        }
        return $next($request);
        /*
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            elseif(Input::get('ssuser')){
                $callback = Input::get('ssuser');
                return $callback.'('.json_encode([
                    'callback' => $callback,
                    'sta' => 101,
                    'msg' => '请先登录'
                ]).')';
            }
            else {
                return redirect()->route('user.login')->withErrors('请先登录');
            }
        }
        elseif ($this->auth->user()->lock == User::LOCK) {
            Auth::logout();
            return redirect()->route('user.login')->withErrors('用户已经锁定');
        }

        return $next($request);*/
    }
}
