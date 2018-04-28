<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23 0023
 * Time: 15:55
 */

namespace app\admin\validate;

use think\Validate;
class Lunbo extends  Validate
{
    protected $rule=[
        'img'=>'require',
    ];
    protected $messge=[
        'img:require'=>'图片不能为空',
    ];
    protected $scene=[
        'add'=>['img',],
    ];
}