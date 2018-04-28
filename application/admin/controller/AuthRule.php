<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/28 0028
 * Time: 15:33
 */

namespace app\admin\Controller;


use think\Controller;
use app\admin\model\AuthRule as AuthRuleModel;
class AuthRule extends Controller
{
public function index()
{
    $authModel=new AuthRuleModel();
    $data=$authModel->authRuleCol();
    $this->assign('data',$data);
    return view();
}
public function add(){
    $authModel=new AuthRuleModel();
    if(request()->isPost()){
        $data=request()->post();
       //查询当前数据父级Id
        $dataPid=$authModel->selectPid($data['pid']);
        if($dataPid){
            $data['level']=$dataPid['level']+1;
        }else{
            $data['level']=0;
        }
        $res=$authModel->save($data);
        if($res){
            $this->success('添加成功',url('index'));
        }else{
            $this->error('添加失败');
        }

    }else{
        $data=$authModel->authRuleCol();
        $this->assign('data',$data);
        return view();
    }

}
public function  update($id){
    $authModel=new AuthRuleModel();
    if(request()->isPost()){
        $data=request()->post();
        $dataPid=$authModel->selectPid($data['pid']);
        if($dataPid){
            $data['level']=$dataPid['level']+1;
        }else{
            $data['level']=0;
        }
        $res=$authModel->save($data,$id);
        if($res){
            $this->success('修改成功',url('index'));
        }else{
            $this->error('修改失败');
        }
    }else{
        $fdata=$authModel->selectM($id);
        $data=$authModel->authRuleCol();
        $this->assign([
            'fdata'=>$fdata,
            'data'=>$data,
        ]);
        return view();
    }

}

//    前置操作
    protected $beforeActionList=[
        'delSon'=>['only'=>'del'],
    ];
//删除子类
    public function delSon(){
        $id=input('id');
        $authModel=new AuthRuleModel();
        $delSonId=$authModel->getChilds($id);
        if($delSonId){
            $authModel->delM($delSonId);
        }
    }
//    删除
    public function del($id)
    {
        $authModel=new AuthRuleModel();
        $res=$authModel->delM($id);
        if($res){
            $this->success('删除成功',url('index'));
        }else{
            $this->error('删除失败');
        }
    }






}