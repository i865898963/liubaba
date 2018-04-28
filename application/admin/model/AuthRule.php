<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/28 0028
 * Time: 15:47
 */

namespace app\admin\model;

use think\Model;
class AuthRule  extends Model
{
    //无限分类
    public function authRuleCol(){
        $data=$this->select();
        return $this->sort($data);
    }
    //数组改造
    public function sort($data,$pid=0){
        static $arr=array();
        foreach ($data as $val) {
            if($val['pid']==$pid){
                $arr[]=$val;
                $this->sort($data,$val['id']);
            }
        }
        return $arr;
    }
    //查
    public function selectM($id='')
    {
        if($id){
            $data=$this->find($id);
        }else{
            $data=$this->select();
        }
        return $data;
    }
//查找父级的level
    public function selectPid($id)
    {
        return $this->where('id',$id)->field('level')->find();
    }

//    找子类
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

}