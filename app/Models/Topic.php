<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    //一个帖子下有多条回复
    public function replies(){
        return $this->hasMany(Reply::class);
    }

    //一个帖子有一个分类
    public function category(){
        return $this->belongsTo(Category::class);
    }
    //一个帖子有一个用户/作者
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query,$order){
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order){
            case 'recent':
                $query = $this->recent();
                break;
            default:
                $query = $this->recentReplied();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('category','user');
    }

    public function scopeRecentReplied($query){
        // 当话题有新回复时，将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at','desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at','desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }


}
