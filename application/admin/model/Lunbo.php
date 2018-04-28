<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23 0023
 * Time: 13:34
 */

namespace app\admin\model;
use think\Model;

class Lunbo extends Model
{
//    查询
    public function selectM($id='')
    {
        if($id){
            $data=$this->find($id);
        }else{
            $data=$this->select();
        }

        return $data;
    }
//    添加
    public function addM($arr)
    {
        if($this->save($arr)){
            return true;
        }else{
            return false;
        }
    }
//    删除
    public function delM($id)
    {
       return $this::destroy($id);
    }
//    更新
    public function updateM($arr,$id)
    {
        return $this->save($arr,['id'=>$id]);
    }

}