<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23 0023
 * Time: 16:43
 */

namespace app\admin\Controller;


use think\Controller;
use app\admin\model\Colum as ColumModel;
class Colum extends Controller
{
    public function index()
    {   $model=new ColumModel();
        if(request()->isPost()){
            $data=request()->post();
            foreach ($data as $key =>$val){
                $model->updateM(['sort'=>$val],$key);
            }
            $this->success('排序更新成功',url('index'));
        }else {
            $data=$model->coltree();
            $res=$model->selectM();
            $count=count($res);
            $this->assign('count',$count);
            $this->assign('dat',$data);
            return view();
        }
    }


//    添加
    public  function add(){
        $data=request()->post();
        $model=new ColumModel();
        $validate=\think\Loader::validate('Colum');
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }else{
            $res=$model->addM($data);
            if($res){
                $this->success('添加成功',url('index'));
            }else{
                $this->error('添加失败');
            }
        }

    }
//    前置操作
    protected $beforeActionList=[
        'delSon'=>['only'=>'del'],
    ];
//删除子类
    public function delSon(){
        $id=input('id');
        $model=new ColumModel();
        $delSonId=$model->getChilds($id);
        if($delSonId){
            $model->delM($delSonId);
        }
    }
//    删除
    public function del($id)
    {
        $model=new ColumModel();
        $res=$model->delM($id);
        if($res){
            $this->success('删除成功',url('index'));
        }else{
            $this->error('删除失败');
        }
    }
//    修改
    public function update($id)
    {
        $model=new ColumModel();
        if(request()->isPost()){
            $data=request()->post();
            $validate=\think\Loader::validate('Colum');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }else{
                $res=$model->updateM($data,$id);
                if($res){
                    $this->success('修改成功',url('index'));
                }else{
                    $this->error('修改失败');
                }
            }

        }else{
            $fdata=$model->selectM($id);
            $this->assign('fdata',$fdata);
            $data=$model->coltree();
            $this->assign('dat',$data);
            return view();
        }

    }
}