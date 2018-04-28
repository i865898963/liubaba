<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/24 0024
 * Time: 20:57
 */

namespace app\admin\model;

use think\Model;
class Author extends Model
{
//  查询
    public function selectM($id=''){
        if($id){
           $data=$this->find($id);
        }else{
           $data=$this->select();
        }
        return $data;
    }
}