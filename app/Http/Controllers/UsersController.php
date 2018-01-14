<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    //用户信息相关


    public function show(User $user){
        return view('users.show',compact('user'));
    }

    public function edit(User $user){
        return view('users.edit',compact('user'));
    }

    //UserRequest是表单请求验证（FormRequest） 是 Laravel 框架提供的用户表单数据验证方案，此方案相比手工调用 validator 来说，能处理更为复杂的验证逻辑，更加适用于大型程序
    public function update(UserRequest $request,User $user,ImageUploadHandler $uploader){

        $data = $request->all();

        if($request->avatar){
            $result = $uploader->save($request->avatar,'avatars',$user->id,362);
            if($result){
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功!');
    }
}
