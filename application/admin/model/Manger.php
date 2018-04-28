<?php
namespace app\admin\model;
use think\Model;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/21 0021
 * Time: 20:12
 */
class Manger extends Model
{
    /**
     * @param $arr
     * @return bool
     */
    public function addM($arr){
            $arr['password']=md5($arr['password']);
            if($this->save($arr)){
                return true;
            }else{
                return false;
            }
    }

    /**
     * @param $id
     * @return int
     */
    public function delM($id){
        return  $this::destroy($id);
    }

    /**
     * @param $arr
     * @return $this
     */
    public function editM($arr){
        if($arr['password']){
            $arr['password']=md5($arr['password']);
        }else{
            $data=$this->find($arr['id']);
            $arr['password']=$data['password'];
        }
        $res=$this::update(["username"=>$arr['username'],'password'=>$arr['password'],'status'=>$arr['status'],'id'=>$arr['id']]);
        return $res;
    }

}