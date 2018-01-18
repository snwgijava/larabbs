<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable{
        notify as protected laravelNotify;
    }

    //重写了notify方法，调用 $user->notify() 时， users 表里的 notification_count 将自动 +1
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()){
            return ;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    //一个用户可以有多条评论
    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function isAuthorOf($model){
        return $this->id == $model->user_id;
    }

    //清除消息 通知
    public function markAsRead(){
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
