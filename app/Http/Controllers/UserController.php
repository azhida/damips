<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // 用户注册
    public function register(Request $request)
    {
        $user_name = $request->user_name;
        $email = $request->email;
        $password = $request->password;
        $mobile = $request->mobile;

        Log::error(' $params : ' . json_encode($request->input()));

        if (!isset($mobile) || $mobile != '') {
            return $this->responseError('参数错误');
        }

        if (!isset($password)) {
            return $this->responseError('请输入密码');
        }

        $insert_data = [
            'user_name' => $user_name,
            'email' => $email,
            'password' => md5($password),
            'mobile' => $mobile,
            'add_time' => date('Y-m-d H:i:s'),
        ];

        $user_id = DB::table('user')->insertGetId($insert_data);
        if ($user_id) {
            return $this->responseSuccess();
        } else {
            return $this->responseError();
        }
    }

    // 用户登录
    public function login(Request $request)
    {
        $user_name = $request->user_name;
        $email = $request->email;
        $password = $request->password;
        $user_info = DB::table('user')->where('user_name', $user_name)->orWhere('email', $email)->first();
        if ($user_info) {
            // 已注册，去 验证密码
            if (md5($password) != $user_info['password']) {
                $res = ['error' => 1, 'msg' => '密码错误'];
            } else {
                $res = ['error' => 0, 'msg' => '登录成功'];
            }
        } else {
//            $res = ['error' => 0, 'msg' => '未注册'];
            // 未注册，去注册
            $this->register($user_name, $email, $password);
        }

        return response()->json($res);
    }

    // 检测用户是否已经注册
    public function isRegister(Request $request, $data)
    {
        $user_name = $request->user_name;
        $email = $request->email;

        $user_info = DB::table('user')->where('user_name', $user_name)->orWhere('email', $email)->first();
        if ($user_info) {
            $res = ['error' => 1, 'msg' => '已注册'];
        } else {
            $res = ['error' => 0, 'msg' => '未注册'];
        }
        return response()->json($res);
    }
}
