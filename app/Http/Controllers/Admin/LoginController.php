<?php

namespace App\Http\Controllers\Admin;


use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Services\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index ()
    {
        $img=[
            'https://chevereto.nosoxo.com/content/images/system/home_cover_1634533979107_6c022e.jpg',
            'https://chevereto.nosoxo.com/content/images/system/home_cover_1634534018295_4a3c6b.jpg',
            'https://chevereto.nosoxo.com/content/images/system/home_cover_1634533979154_cce623.jpg',
            'https://chevereto.nosoxo.com/content/images/system/home_cover_1634533941753_bd3c47.jpg'
            ];
        return view ('admin.login.index', ['bgimg' => $img[array_rand($img)]]);
    }

    public function check (Request $request)
    {
        $username = $request->input ('username');
        $password = $request->input ('password');
        $captcha  = $request->input ('captcha');
        if (!captcha_check ($captcha)) {
            return ajax_error_result ('验证码不正确');
        }
        $result       = ['refresh' => true];
        $LoginService = new LoginService();
        try {
            $ret = $LoginService->checkLogin ($username, $password, LoginService::ADMIN_TYPE);
            if ($ret === true) {

                $msg=['code'=>0,'message'=>'登录成功','url'=>$_SERVER['HTTP_HOST'].'/admin/'];
                return json_encode($msg);
//                return ajax_success_result ('登录成功');
            } else {
                return ajax_error_result ('登录失败', $result);
            }
        } catch (BusinessException $e) {
            return ajax_error_result ($e->getMessage (), $result);
        }
    }

    public function captcha ()
    {
        return captcha ('admin_login');
    }
}
