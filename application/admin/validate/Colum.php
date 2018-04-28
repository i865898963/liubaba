<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/24 0024
 * Time: 20:32
 */

namespace app\admin\validate;

use think\Validate;
class Colum extends Validate
{
    protected  $rule=[
        'name'=>'unique:Colum|require',
    ];

    protected  $message=[
        'name:require'=>'栏目不允许为空',
        'name:unique'=>'栏目名称不能重复',
    ];
    protected $scene=[
        'add'=>'name',
        'edit'=>'name',
    ];
}