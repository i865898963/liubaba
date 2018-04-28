<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23 0023
 * Time: 17:13
 */

namespace app\admin\model;

use think\Model;
class Colum extends Model
{
//无限分类展示
    public function coltree()
    {
        $res=$this->order('sort desc')->select();
        return $this->sort($res);
    }
//数组改造
    public function sort($data,$pid=0,$level=0){
        static $arr=array();
        foreach ($data as $key=>$val){
            if($val['pid']==$pid){
                $val['level']=$level;
                $arr[]=$val;
                $this->sort($data,$val['id'],$level+2);
            }
        }
        return $arr;
    }
    //    添加
    public function addM($arr)
    {
        return $this->save($arr);
    }
//找出子类
    public function getChilds($id){
        $res=$this->select();
        return $this->_getChilds($res,$id);
    }

    public function _getChilds($data,$id)
    {
        static $arr=array();
        foreach ($data as $key=>$val){
            if($val['pid']==$id){
                $arr[]=$val['id'];
                $this->_getChilds($data,$val['id']);
            }
        }
        return $arr;
    }
//    删除子类
    public function delM($id){
        return $this::destroy($id);
    }
//  查询
    public function selectM($id=''){
        if($id){
            $data=$this->find($id);
        }else{
            $data=$this->select();
            return $data;
        }
    }
//    修改
    public function updateM($arr,$id){
        $res=$this->where('id', $id)->update($arr);
        if($res){
            return true;
        }else{
            return false;
        }
    }
}