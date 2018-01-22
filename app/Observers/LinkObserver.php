<?php
/**
 * Created by PhpStorm.
 * User: ybyan
 * Date: 2018/1/22
 * Time: 20:59
 */

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    // 在保存时清空 cache_key 对应的缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}