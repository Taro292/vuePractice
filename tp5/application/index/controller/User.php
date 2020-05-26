<?php

namespace app\index\controller;

use think\Controller;
use app\common\model\User as UserModel;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:*');
header('Access-Control-Allow-Credentials:false');
class User extends Controller
{

    // 注册
    public function register()
    {
        // 判断请求类型
        if (request()->isPost()) {
            $captcha = input('post.captcha'); //获取get的验证码
            $pwd = input('post.password'); //获取密码
            $email = input('post.email'); //获取邮箱     
            $user = model('user'); //调用模型
            $alHave = $user->where('email',$email)->find();//查询是否存在邮箱
            $user['email'] = $email; //邮箱账号赋值
            $user['password'] = md5($pwd);
            // if (!captcha_check($captcha)) {
            //     //验证失败
            //     return json(['msg' => '验证码错误', 'code' => 0]);
            // } else {
                if($alHave){
                    return json(['msg'=>'邮箱已存在','code'=>'0']);
                }else{
                    if ($user->save()) {
                        return json(['msg' => '注册成功', 'code' => 1]);
                    } else {
                        return json(['msg' => '注册失败', 'code' => 0]);
                    }
                }
                
            // }
        }
    }
    // 获取token
    public function getToken()
    {
        $token = $this->request->token('__token__', 'sha1'); //tp5自带表单令牌token
        return json(['token' => $token]);
    }
    // 登录
    public function login()
    {

        // 判断请求类型
        if (request()->isPost()) {
            $captcha = input('post.captcha'); //获取post的验证码
            $email = input('post.email'); //获取post的邮箱
            $pwd = input('post.password'); //获取post的密码
            $user = model('user'); //用户表
            $data = $user->where('email', $email)->find();
            $token = $this->request->token('__token__', 'sha1'); //tp5自带表单令牌token
            if ($data) {
                //captcha手动验证
                // if (!captcha_check($captcha)) {
                //     //验证失败
                //     return json(['msg' => '验证码错误', 'code' => 0]);
                // } else {
                    if (md5($pwd) !== $data['password']) {
                        return json(['msg' => '用户名或密码错误', 'code' => 0 ]);
                    } else {
                        return json(['msg' => '登录成功', 'code' => 1, 'data' => $data, 'token' => $token]);
                    }
                };
            // } else {
            //     return json(['msg' => '用户不存在', 'code' => 0]);
            // }
        } else {
            return json(['msg' => '请求方法错误', 'code' => 0]);
        }
    }
    // 个人信息修改接口
    public function edit()
    {
        $editData = input('post.'); //获取post的所有数据；
        $id = input('post.id'); //获取post的id
        $user = model('user'); //用户表
        $situation = $user->allowField(true)->save($editData, ['id' => $id]); //更新情况
        //判断是否保存
        if (!$situation) {
            return json(['msg' => '更新失败', 'code' => 0]); //失败返回
        } else {
            return json(['msg' => '更新成功', 'code' => 1, 'data' => $user]); //成功返回
        }
    }
}
