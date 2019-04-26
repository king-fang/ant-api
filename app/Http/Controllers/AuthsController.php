<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Http\Requests\AuthRequest;
use App\Models\Permission\Perm;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class AuthsController extends ApiController
{

    use ThrottlesLogins;

    /**
     * 获取token
     */
    public function token(AuthRequest $request)
    {
        //验证登录次数
        if($this->hasTooManyLoginAttempts($request))
        {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if(!Auth::attempt($request->validated())){

            $this->incrementLoginAttempts($request);
            return $this->error('账号和密码错误');
        }

        $user = $request->user();

        $tokenResult = $user->createToken('hulu');

        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addWeeks(5);

        $token->save();
        //增加登录id 和时间
        $user->last_ip   = request()->getClientIp();
        $user->last_time = now();
        $user->save();
        return $this->success([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => strtotime(Carbon::parse(
            )->toDateTimeString())
        ]);
    }

     //管理员信息
    public function userinfo()
    {
        $users =  Auth::user();
        $roles = array_column($users->roles->toArray(), 'number');
        return $this->success(['users'=>$users, 'roles'=>$roles]);

    }

    //退出
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->success('退出成功');
    }

    //获取菜单
    public function menus()
    {
        return $this->success(getMenuComponmentsTree(Perm::get()));
    }

    protected function username()
    {
        return 'name';
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        return $this->error(Lang::get('auth.throttle', ['seconds' => $seconds]),422);
    }
}
