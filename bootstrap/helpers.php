<?php

use Illuminate\Support\Facades\Route;

//此方法会将当前请求的路由名称转换为 CSS 类名称，作用是允许我们针对某个页面做页面样式定制
function route_class(){
    return str_replace('.','-',Route::currentRouteName());
}

function make_excerpt($value,$length=200){
    //将换行符或回车符替换成空格
    $excerpt = trim(preg_replace('/\r\n|\n+/',' ',strip_tags($value)));
    return str_limit($excerpt,$length);
}